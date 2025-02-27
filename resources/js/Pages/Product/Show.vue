<script setup>
import { Link } from '@inertiajs/vue3';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ArrowLeftIcon, PackageIcon, TagIcon, LayersIcon, BarChart4Icon } from 'lucide-vue-next';
import { Card, CardHeader, CardTitle, CardDescription, CardContent } from '@/components/ui/card';

const props = defineProps({
    product: { type: Object }
});
</script>
<template>
    <Head title="Viewing product {{ product.name }}" />

    <AuthenticatedLayout>
        <div class="my-4">
            <div class="mx-auto w-full sm:px-6 lg:px-10">
                <div class="mb-2 bg-white rounded-lg p-4 border flex items-center justify-between">
                    <Link :href="route('products.index')" class="flex items-center text-sm text-gray-700 hover:underline">
                        <ArrowLeftIcon class="w-4 h-4 mr-2" />
                        Products list
                    </Link>

                    <div class="flex space-x-2">
                        <Link :href="route('products.edit', product.id)">
                            <Button variant="outline">Edit product</Button>
                        </Link>
                    </div>
                </div>
                
                <Card class="w-full border shadow-none">
                    <CardHeader class="border-b">
                        <div class="flex items-center justify-between">
                            <div>
                                <CardTitle class="text-xl">{{ product.name }}</CardTitle>
                                <CardDescription class="mt-1">Product details</CardDescription>
                            </div>

                            <Badge class="px-4 py-2" :variant="product.stock > 0 ? 'default' : 'destructive'">
                                {{ product.stock > 0 ? 'In stock' : 'Out of stock' }}
                            </Badge>
                        </div>
                    </CardHeader>
        
                    <CardContent class="pt-6">
                        <div class="grid gap-6">
                            <div>
                                <h3 class="text-base font-semibold text-gray-700 mb-2">Description</h3>
                                <p class="text-gray-900 text-sm">{{ product.description || 'No description' }}</p>
                            </div>
            
                            <Separator />

                            <div v-if="product.image" class="bg-gray-50 p-4 rounded-lg border flex">
                                <img :src="'/storage/' + product.image" :alt="product.name" class="max-w-full h-auto rounded-lg border" style="max-height: 300px;">
                            </div>
                            <div v-else class="text-center text-gray-500">
                                No image uploaded
                            </div>
            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="bg-gray-50 p-4 rounded-lg border">
                                    <div class="flex items-center mb-2">
                                        <TagIcon class="w-4 h-4 mr-2 text-gray-500" />
                                        <h3 class="text-sm font-medium text-gray-500">Price</h3>
                                    </div>

                                    <p class="text-2xl font-semibold">{{ Number(product.price).toFixed(2) }} PLN</p>
                                </div>
            
                                <div class="bg-gray-50 p-4 rounded-lg border">
                                    <div class="flex items-center mb-2">
                                        <LayersIcon class="w-4 h-4 mr-2 text-gray-500" />
                                        <h3 class="text-sm font-medium text-gray-500">Stock</h3>
                                    </div>

                                    <p class="text-2xl font-semibold">{{ product.stock }} in stock</p>
                                </div>
                
                                <div class="bg-gray-50 p-4 rounded-lg border">
                                    <div class="flex items-center mb-2">
                                        <BarChart4Icon class="w-4 h-4 mr-2 text-gray-500" />
                                        <h3 class="text-sm font-medium text-gray-500">Rank</h3>
                                    </div>
                                    <p class="text-2xl font-semibold">{{ product.rank || 'None' }}</p>
                                </div>
                            </div>
            
                            <!-- Additional product metadata could go here -->
                            <div class="text-sm text-gray-500">
                                <p v-if="product.created_at">Created: {{ new Date(product.created_at).toLocaleDateString() }}</p>
                                <p v-if="product.updated_at">Last updated: {{ new Date(product.updated_at).toLocaleDateString() }}</p>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
