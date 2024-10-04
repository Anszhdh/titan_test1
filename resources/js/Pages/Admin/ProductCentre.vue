<script setup>
import { ref } from 'vue';
import { Head, usePage } from '@inertiajs/inertia-vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Inertia } from '@inertiajs/inertia';

const { props } = usePage();
const products = props.value.products || [];

const redirectToAddProduct = () => {
  Inertia.get(route('product.create'));
};

const redirectToEditProduct = (id) => {
  Inertia.get(route('product.edit', id));
};

const deleteProduct = (id) => {
  if (confirm('Are you sure you want to delete this product?')) {
    Inertia.delete(route('product-centre.destroy', id)).then(() => {
      // Reload the page after successful deletion
      Inertia.reload({ only: ['products'] }); // Assuming 'products' is the key for products data in your page
    });
  }
};
</script>

<template>
    <AdminLayout>
      <Head title="Product Centre" />
      
      <div class="p-6 bg-gray-100">
        <div class="max-w-8xl mx-auto">
          <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Product Centre</h1>
            <button @click="redirectToAddProduct" class="px-4 py-2 bg-black text-white rounded-md">Add Product</button>
          </div>
          
          <div class="mb-6">
            <div class="p-4 bg-white shadow-md rounded-md">
              <h2 class="text-xl font-semibold text-gray-800">Total Products</h2>
              <p class="text-2xl text-gray-800">{{ products.length }}</p>
            </div>
          </div>
  
          <!-- Product List with Numbering -->
          <div class="bg-white shadow-md rounded-md">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    #
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Image
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Product Name
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Quantity
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Price
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Actions
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="(product, index) in products" :key="product.id">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span class="text-sm text-gray-900">{{ index + 1 }}</span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <img :src="product.image_url" alt="Product Image" class="w-16 h-16 object-cover" />
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">{{ product.name }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-500">{{ product.quantity }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">RM {{ product.price }}</div>
                    <div class="text-sm text-gray-500">Base: RM {{ product.base_price }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                    <button @click="redirectToEditProduct(product.id)" class="px-4 py-2 bg-green-500 text-white rounded-md">Edit</button>
                    <button @click="deleteProduct(product.id)" class="px-4 py-2 bg-red-600 text-white rounded-md">Delete</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </AdminLayout>
</template>
