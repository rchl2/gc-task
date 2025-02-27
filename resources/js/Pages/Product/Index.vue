<script setup>
import { ref, watch, onUnmounted } from 'vue';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import { Search, Plus } from 'lucide-vue-next';
import { Link, Head, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Tooltip, TooltipTrigger, TooltipContent, TooltipProvider } from '@/components/ui/tooltip';
import { Select, SelectTrigger, SelectContent, SelectItem, SelectValue } from '@/components/ui/select';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { AlertDialog, AlertDialogAction, AlertDialogCancel, AlertDialogContent, AlertDialogDescription, AlertDialogFooter, AlertDialogHeader, AlertDialogTitle } from '@/components/ui/alert-dialog';

const props = defineProps({
	products: { type: Object, default: () => ({ data: [], from: null, to: null, total: 0, prev_page_url: null, next_page_url: null, current_page: 1 }) },
	filters: { type: Object, default: () => ({ search: '', perPage: '10' }) },
	showActions: { type: Boolean, default: true }
});

const search = ref(props.filters?.search);
const perPage = ref(props.filters?.perPage);

const showDestroyModal = ref(false);
const deletingProduct = ref(null);

/**
 * Filter products
 */
const filterProducts = () => {
    router.get(route('products.index'), 
    { search: search.value,  perPage: perPage.value }, 
    { preserveState: true, replace: true });
}

/**
 * Switch current page
 */
const switchPage = (page) => {
    router.get(route('products.index', { page }), 
    { search: search.value, perPage: perPage.value },
    { preserveState: true, replace: true });
}

/**
 * Confirm destroy product
 */
const confirmDestroy = (product) => {
    deletingProduct.value = product;
    showDestroyModal.value = true;
};

/**
 * Destroy product
 */
const destroyProduct = () => {
    router.delete(route('products.destroy', deletingProduct.value.id), {
        onSuccess: () => {
            showDestroyModal.value = false;
            deletingProduct.value = null;
        }
    });
};

/**
 * Truncate product description - helper
 */
const truncateProductDescription = (description) => {
  if (! description || ! String(description).trim()) return '-';

  const str = String(description).trim();
  return str.length > 30 ? `${str.slice(0, 30)}...` : str;
}

// Debounce like pro - lodash? : ")
let timeout = null;
watch(search, () => {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
      filterProducts();
    }, 300);
});

// Cleanup - no need for memory leaks
onUnmounted(() => {
  clearTimeout(timeout)
  timeout = null;
})
</script>

<template>
    <Head title="Products" />

    <AuthenticatedLayout>
        <div class="my-4">
            <div class="mx-auto w-full sm:px-6 lg:px-10">
                <div class="flex items-center gap-2 mb-6">
                    <div class="relative flex-1">
                        <Search class="absolute left-2.5 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground" />
                        <Input v-model="search" type="text" placeholder="Search products.." class="pl-8 pr-4 h-10 w-full border rounded-lg bg-white shadow-sm" />
                    </div>

                    <Select v-model="perPage" @update:model-value="filterProducts">
                        <SelectTrigger class="w-36 h-10 py-2 border rounded-lg bg-white shadow-sm hover:border-gray-300">
                            <SelectValue placeholder="Per page" />
                        </SelectTrigger>

                        <SelectContent>
                            <SelectItem value="5">5 per page</SelectItem>
                            <SelectItem value="10">10 per page</SelectItem>
                            <SelectItem value="20">20 per page</SelectItem>
                        </SelectContent>
                    </Select>

                    <Link :href="route('products.create')" class="px-3 py-2 font-medium text-gray-700 bg-white border rounded-lg text-sm transition-colors shadow-sm">
                        <Plus class="w-4 h-4 mr-1 mb-0.5 inline" />
                        Add new product
                    </Link>
                </div>

                <Table className="w-full bg-white rounded-lg border overflow-hidden">
                    <TableHeader className="bg-gray-50">
                        <TableRow className="border-b border-gray-200 hover:bg-transparent">
                            <TableHead className="py-4 text-xs font-semibold text-gray-600 uppercase tracking-wider">Product name</TableHead>
                            <TableHead className="py-4 text-xs font-semibold text-gray-600 uppercase tracking-wider">Description</TableHead>
                            <TableHead className="py-4 text-xs font-semibold text-gray-600 uppercase tracking-wider">Price (PLN)</TableHead>
                            <TableHead className="py-4 text-xs font-semibold text-gray-600 uppercase tracking-wider">In stock</TableHead>
                            <TableHead className="py-4 text-xs font-semibold text-gray-600 uppercase tracking-wider">Rank</TableHead>
                            <TableHead v-if="showActions" className="py-4 px-20 text-xs font-semibold text-gray-600 uppercase tracking-wider text-right">Actions</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="product in products.data" :key="product.id" className="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                            <TableCell className="py-4 px-6 text-sm text-gray-700">
                                 <Link :href="route('products.show', product.id)" className="cursor-pointer text-indigo-500 hover:text-indigo-700">
                                    {{ product.name }}
                                </Link>
                            </TableCell>
                            <TableCell className="py-4 px-6 text-sm text-gray-700">
                                <TooltipProvider>
                                    <Tooltip>
                                    <TooltipTrigger as-child>
                                        <span>{{ truncateProductDescription(product.description) }}</span>
                                    </TooltipTrigger>
                                    <TooltipContent v-if="product.description && product.description.length > 30" class="bg-gray-800 text-white p-2 rounded">
                                        {{ product.description }}
                                    </TooltipContent>
                                    </Tooltip>
                                </TooltipProvider>
                            </TableCell>
                            <TableCell className="py-4 px-6 text-center text-sm text-gray-700 font-medium">{{ Number(product.price).toFixed(2) }} PLN</TableCell>
                            <TableCell className="py-4 px-6 text-center">
                                <span v-if="product.stock > 10" className="px-3 py-1 text-xs rounded-md bg-green-100 text-green-800 font-medium">
                                    {{ product.stock }} in stock
                                </span>
                                <span v-else className="px-3 py-1 text-xs rounded-lg bg-red-100 text-red-800 font-medium">
                                    Empty stock
                                </span>
                            </TableCell>
                            <TableCell className="py-4 px-6 text-center text-sm text-gray-700 font-medium">{{ product.rank }}</TableCell>
                            <TableCell v-if="showActions" className="py-3 px-6">
                                <div className="flex items-center justify-end space-x-3">
                                    <Link :href="route('products.edit', product.id)" className="flex items-center text-xs border-gray-200 bg-white border px-4 py-1 rounded-md text-gray-700 cursor-pointer hover:bg-gray-50">
                                        Edit product
                                    </Link>
                                    
                                    <Button variant="outline" size="sm" @click="confirmDestroy(product)" className="flex items-center text-xs border-gray-200 bg-red-500 border px-4 py-1 rounded-md text-white hover:bg-red-600">
                                        Delete
                                    </Button>
                                </div>
                            </TableCell>
                        </TableRow>
                        <TableRow v-if="products.data.length === 0">
                            <TableCell :colSpan="showActions ? 5 : 4" className="py-12 text-center">
                                <div className="flex flex-col items-center justify-center">
                                    <p className="text-gray-500 font-medium">Products list is empty</p>
                                    <p className="text-gray-400 text-sm mt-1">Add new products to the database to see it here</p>
                                </div>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>

                <div class="bg-white rounded-lg border px-4 flex items-center justify-between mt-4">
                    <p class="text-sm text-gray-500">
                        Showing {{ products.from || 0 }} to {{ products.to || 0 }} of {{ products.total || 0 }} products
                    </p>

                    <div class="flex gap-2 py-2">
                        <Button variant="outline" size="sm" class="py-2" :disabled="!products.prev_page_url" @click="switchPage(products.current_page - 1)">
                            Previous page
                        </Button>

                        <Button variant="outline" size="sm" class="py-2" :disabled="!products.next_page_url" @click="switchPage(products.current_page + 1)">
                            Next page
                        </Button>
                    </div>
                </div>

                <AlertDialog :open="showDestroyModal" @update:open="showDestroyModal = $event">
                    <AlertDialogContent>
                        <AlertDialogHeader>
                            <AlertDialogTitle>Confirm action</AlertDialogTitle>
                            <AlertDialogDescription>
                                Are you sure you want to delete product <span class="font-semibold">"{{ deletingProduct.name }}"</span>? This action cannot be undone.
                            </AlertDialogDescription>
                        </AlertDialogHeader>

                        <AlertDialogFooter>
                            <AlertDialogCancel @click="showDestroyModal = false">Cancel</AlertDialogCancel>
                            <AlertDialogAction @click="destroyProduct" class="text-white bg-red-600 hover:bg-red-700">
                                Delete product
                            </AlertDialogAction>
                        </AlertDialogFooter>
                    </AlertDialogContent>
                </AlertDialog>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
