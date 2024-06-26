<script setup>
import { ref } from 'vue';
import { Head, useForm, usePage } from '@inertiajs/inertia-vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const { props } = usePage();
const products = props.value.products || [];
const categories = props.value.categories || [];

const form = useForm({
    name: '',
    description: '',
    base_price: '',
    price: '',
    category_id: '',
    image: null,
    image_url: '',
    sku: '',
    quantity: '',
    variations: [],
});

const addVariation = () => {
    form.variations.push({ name: '', value: '', price: '', quantity: '' });
};

const removeVariation = (index) => {
    form.variations.splice(index, 1);
};

const handleImageUpload = (event) => {
    form.image = event.target.files[0];
    form.image_url = URL.createObjectURL(event.target.files[0]);
};

const saveProduct = () => {
    form.post(route('product-centre.store'));
};
</script>

<template>
<AdminLayout>
    <Head title="Product Centre" />

    <div class="p-6 bg-gray-100">
      <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Product Name and Description -->
        <div class="p-6 bg-white shadow-md rounded-md">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">Add Product</h2>
          <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
            <input v-model="form.name" type="text" id="name" class="mt-1 p-2 w-full border rounded-md" />
          </div>
          <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea v-model="form.description" id="description" class="mt-1 p-2 w-full border rounded-md"></textarea>
          </div>
        </div>

        <!-- Media Upload -->
        <div class="p-6 bg-white shadow-md rounded-md">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">Media</h2>
          <div class="mb-4">
            <img v-if="form.image_url" :src="form.image_url" alt="Product Image" class="w-full h-auto mb-4 rounded-md" />
            <label class="block text-sm font-medium text-gray-700">Add More Image</label>
            <input @change="handleImageUpload" type="file" class="mt-1 p-2 w-full border rounded-md" />
          </div>
        </div>

        <!-- Pricing -->
        <div class="p-6 bg-white shadow-md rounded-md">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">Pricing</h2>
          <div class="mb-4">
            <label for="base_price" class="block text-sm font-medium text-gray-700">Base Price</label>
            <input v-model="form.base_price" type="number" step="0.01" id="base_price" class="mt-1 p-2 w-full border rounded-md" />
          </div>
          <div class="mb-4">
            <label for="price" class="block text-sm font-medium text-gray-700">Sale Price</label>
            <input v-model="form.price" type="number" step="0.01" id="price" class="mt-1 p-2 w-full border rounded-md" />
          </div>
        </div>

        <!-- Category -->
        <div class="p-6 bg-white shadow-md rounded-md">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">Category</h2>
          <div class="mb-4">
              <label for="category_id" class="block text-sm font-medium text-gray-700">Product Category</label>
              <select v-model="form.category_id" id="category_id" class="mt-1 p-2 w-full border rounded-md">
                  <option v-for="category in categories" :key="category.id" :value="category.id">
                      {{ category.name }}
                  </option>
              </select>
          </div>
         </div>

        <!-- Inventory -->
        <div class="p-6 bg-white shadow-md rounded-md">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">Inventory</h2>
          <div class="mb-4">
            <label for="sku" class="block text-sm font-medium text-gray-700">SKU</label>
            <input v-model="form.sku" type="text" id="sku" class="mt-1 p-2 w-full border rounded-md" />
          </div>
          <div class="mb-4">
            <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
            <input v-model="form.quantity" type="number" id="quantity" class="mt-1 p-2 w-full border rounded-md" />
          </div>
        </div>

         <!-- Variations -->
        <div class="p-6 bg-white shadow-md rounded-md">

          <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">Variations</h2>
          <div v-for="(variation, index) in form.variations" :key="index" class="mb-4">
            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700">Variation Name</label>
              <input v-model="variation.name" type="text" class="mt-1 p-2 w-full border rounded-md" />
            </div>
            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700">Variation Value</label>
              <input v-model="variation.value" type="text" class="mt-1 p-2 w-full border rounded-md" />
            </div>
            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700">Variation Price</label>
              <input v-model="variation.price" type="number" step="0.01" class="mt-1 p-2 w-full border rounded-md" />
            </div>
            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700">Variation Quantity</label>
              <input v-model="variation.quantity" type="number" class="mt-1 p-2 w-full border rounded-md" />
            </div>
            <button @click="removeVariation(index)" class="px-4 py-2 bg-red-600 text-white rounded-md">Remove</button>
          </div>
          <button @click="addVariation" class="px-4 py-2 bg-blue-600 text-white rounded-md">Add Variation</button>
        </div>

        <!-- Save Button -->
        <div class="md:col-span-2 p-6 bg-white shadow-md rounded-md flex justify-end">
          <button @click="saveProduct" class="px-4 py-2 bg-yellow-950/80 text-white rounded-md">Save</button>
        </div>
      </div>
    </div>
</AdminLayout>
</template>
