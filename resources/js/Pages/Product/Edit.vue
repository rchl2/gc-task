<script setup>
import { ref } from 'vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';
import { Link, useForm } from '@inertiajs/vue3';
import { Textarea } from '@/components/ui/textarea';
import { ArrowLeftIcon, LoaderIcon } from 'lucide-vue-next';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Card, CardHeader, CardTitle, CardDescription, CardContent } from '@/components/ui/card';

const props = defineProps({
    product: { type: Object }
});

const form = useForm({
    name: props.product.name,
    description: props.product.description || '',
    price: props.product.price,
    stock: props.product.stock,
    rank: props.product.rank
});

// Client validation error bag
const validationErrorBag = ref({});

// Validate form
const validateForm = () => {
    const errors = {};

    // Required check, additional check on number fields
    const required = (value, field, error) => {
        const stringValue = value !== undefined && value !== null ? String(value) : '';
        return !stringValue.trim() && (errors[field] = error);
    };

    // Check on number
    const isPositiveNumber = (value, field, error) => (value && (isNaN(value) || value < 0)) && (errors[field] = error);

    // Validation rules
    required(form.name, 'name', 'Name is required');

    // Validation rules for numbers - price, stock & rank
    required(form.price, 'price', 'Price is required') || isPositiveNumber(parseFloat(form.price), 'price', 'Price must be a valid number');
    required(form.stock, 'stock', 'Stock is required') || isPositiveNumber(parseInt(form.stock), 'stock', 'Stock must be a valid number');
    required(form.rank, 'rank', 'Rank is required') || isPositiveNumber(parseInt(form.rank), 'rank', 'Rank must be a valid number');

    // Assign errors to bag
    validationErrorBag.value = errors;
    return Object.keys(errors).length === 0;
};

const submit = () => {
    if (! validateForm()) return;

    form.put(route('products.update', props.product.id), {
        onSuccess: () => {
            validationErrorBag.value = {};
        }
    });
};

const getErrorMessage = (field) => {
    return validationErrorBag.value[field] || form.errors[field];
};

const hasError = (field) => {
    return !! validationErrorBag.value[field] || !! form.errors[field];
};
</script>
<template>
    <Head title="Products" />

    <AuthenticatedLayout>
        <div class="my-4">
            <div class="mx-auto w-full sm:px-6 lg:px-10">
                <div class="mb-2 bg-white rounded-lg p-4 border">
                    <Link :href="route('products.index')" class="flex items-center text-sm text-gray-700 hover:underline">
                        <ArrowLeftIcon class="w-4 h-4 mr-2" />
                        Products list
                    </Link>
                </div>
                            
                <Card class="w-full border shadow-none">
                    <CardHeader class="border-b">
                        <CardTitle>Product {{ product.name }} - details</CardTitle>
                        <CardDescription>Update the details for "{{ product.name }}" product.</CardDescription>
                    </CardHeader>
                
                    <CardContent>
                        <form @submit.prevent="submit" class="space-y-4">
                            <div class="grid gap-2">
                                <div class="space-y-1 mt-4">
                                    <Label for="name">Product name *</Label>
                                    <Input id="name" v-model="form.name" @blur="validateForm" :class="{ 'border-red-500': hasError('name') }" />
                                    
                                    <p v-if="hasError('name')" class="text-xs text-red-500">
                                        {{ getErrorMessage('name') }}
                                    </p>
                                </div>
                                
                                <div class="space-y-1">
                                    <Label for="description">Description</Label>
                                    <Textarea id="description" v-model="form.description" @blur="validateForm" rows="4" :class="{ 'border-red-500': hasError('description') }" />
                                    
                                    <p v-if="hasError('description')" class="text-xs text-red-500">
                                        {{ getErrorMessage('description') }}
                                    </p>
                                </div>
                                
                                <div class="grid grid-cols-3 gap-4">
                                    <div class="space-y-1">
                                        <Label for="price">Price</Label>

                                        <div class="relative">
                                            <span class="absolute inset-y-0 left-0 flex text-xs items-center pl-3 text-gray-500">PLN</span>

                                            <Input id="price" v-model="form.price" type="number" step="0.01" min="0" class="pl-12" @blur="validateForm" :class="{ 'border-red-500': hasError('price') }" />
                                        </div>

                                        <p v-if="hasError('price')" class="text-xs text-red-500">
                                            {{ getErrorMessage('price') }}
                                        </p>
                                    </div>
                                
                                    <div class="space-y-1">
                                        <Label for="stock">Stock</Label>
                                        <Input id="stock" v-model="form.stock" type="number" min="0" @blur="validateForm" :class="{ 'border-red-500': hasError('stock') }" />

                                        <p v-if="hasError('stock')" class="text-xs text-red-500">
                                            {{ getErrorMessage('stock') }}
                                        </p>
                                    </div>

                                    <div class="space-y-1">
                                        <Label for="rank">Rank</Label>
                                        <Input id="rank" v-model="form.rank" type="number" min="0" @blur="validateForm" :class="{ 'border-red-500': hasError('rank') }" />

                                        <p v-if="hasError('rank')" class="text-xs text-red-500">
                                            {{ getErrorMessage('rank') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end space-x-2">
                                <Button type="submit" class="border shadow-none cursor-pointer" :disabled="form.processing">
                                    <span v-if="form.processing">
                                        <LoaderIcon class="w-4 h-4 mr-2 animate-spin" />
                                        Updating product...
                                    </span>

                                    <span v-else>Update product</span>
                                </Button>
                            </div>
                        </form>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>