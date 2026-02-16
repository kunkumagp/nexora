<script setup>
import { ref, onMounted } from 'vue';

const products = ref([]);
const loading = ref(true);

const fetchProducts = async () => {
    loading.value = true;
    try {
        const res = await window.axios.get('/api/products');
        products.value = res.data;
    } catch (e) {
        console.error(e);
    } finally {
        loading.value = false;
    }
};

onMounted(fetchProducts);
</script>

<template>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold">Products</h2>
            <a href="/products/create" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded">New Product</a>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div v-if="loading">Loading…</div>
                <table v-else class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="p in products" :key="p.id">
                            <td class="px-6 py-4 whitespace-nowrap">{{ p.name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ p.sku }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ p.price }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
