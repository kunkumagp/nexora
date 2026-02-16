<script setup>
import { ref } from 'vue';

const form = ref({ name: '', sku: '', price: 0 });
const submitting = ref(false);

const submit = async () => {
    submitting.value = true;
    try {
        await window.axios.post('/api/products', form.value);
        window.location.href = '/products';
    } catch (e) {
        console.error(e);
    } finally {
        submitting.value = false;
    }
};
</script>

<template>
    <div class="max-w-3xl mx-auto py-6 sm:px-6 lg:px-8">
        <h2 class="text-xl font-semibold mb-4">Create Product</h2>

        <div class="bg-white shadow sm:rounded-lg p-6">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <input v-model="form.name" class="mt-1 block w-full border rounded px-3 py-2" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">SKU</label>
                    <input v-model="form.sku" class="mt-1 block w-full border rounded px-3 py-2" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Price</label>
                    <input type="number" v-model="form.price" class="mt-1 block w-full border rounded px-3 py-2" />
                </div>

                <div class="pt-4">
                    <button @click.prevent="submit" :disabled="submitting" class="px-4 py-2 bg-indigo-600 text-white rounded">Save</button>
                </div>
            </div>
        </div>
    </div>
</template>
