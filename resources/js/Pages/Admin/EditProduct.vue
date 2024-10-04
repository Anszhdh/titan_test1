<script setup>
import { ref } from 'vue';
import { useForm, usePage } from '@inertiajs/inertia-vue3';

const { props } = usePage();

// Form initialization with existing product data
const form = useForm({
  id: props.value.product.id,
  name: props.value.product.name,
  description: props.value.product.description,
  base_price: props.value.product.base_price,
  dealer_price: props.value.product.dealer_price,
  price: props.value.product.price,
  category_id: props.value.product.category ? props.value.product.category.id : null,
  category_name: props.value.product.category ? props.value.product.category.name : '',
  // flavor: props.value.product.flavor ? props.value.product.flavor : '',
  // roast_level: props.value.product.roast_level ? props.value.product.roast_level : '',
  // brewing_method: props.value.product.brewing_method ? props.value.product.brewing_method : '',
  image_url: props.value.product.image_url,
  sku: props.value.product.sku,
  quantity: props.value.product.quantity,
  variations: props.value.product.variations || [],
});

// Categories data from props
const categories = ref(props.value.categories || []);

// Method to update product
const updateProduct = () => {
  form.put(route('product-centre.update', { product: form.id }));
};
</script>
<template>
    <AdminLayout>
      <Head title="Edit Product" />
  
      <div class="p-6 bg-gray-100">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Product Name and Description -->
          <div class="p-6 bg-white shadow-md rounded-md">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">Edit Product</h2>
            <div class="mb-4">
              <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
              <input v-model="form.name" type="text" id="name" class="mt-1 p-2 w-full border rounded-md" />
            </div>
            <div class="mb-4">
              <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
              <textarea v-model="form.description" id="description" class="mt-1 p-2 w-full border rounded-md"></textarea>
            </div>
          </div>
  
           <!-- Media Upload for Image -->
        <div class="p-6 bg-white shadow-md rounded-md">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">Media</h2>
        <div class="mb-4">
            <!-- Display existing image -->
            <img v-if="form.image_url" :src="form.image_url" alt="Product Image" class="w-80 h-auto mb-4 rounded-md" />

            <!-- Update Image input -->
            <label class="block text-sm font-medium text-gray-700">Update Image</label>
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
              <label for="dealer_price" class="block text-sm font-medium text-gray-700">Base Price</label>
              <input v-model="form.dealer_price" type="number" step="0.01" id="dealer_price" class="mt-1 p-2 w-full border rounded-md" />
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
                <label class="block text-sm font-medium text-gray-700">Product Category</label>
                <div class="mt-1 p-2 w-full border rounded-md">
                    <p>{{ `${form.category_name}` }}</p>
                </div>
            </div>
            <!-- <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Flavor</label>
                <div class="mt-1 p-2 w-full border rounded-md">
                    <p>{{ `${form.flavor}` }}</p>
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Roast Level</label>
                <div class="mt-1 p-2 w-full border rounded-md">
                    <p>{{ `${form.roast_level}` }}</p>
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Brewing Method</label>
                <div class="mt-1 p-2 w-full border rounded-md">
                    <p>{{ `${form.brewing_method}` }}</p>
                </div>
            </div> -->
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
            <button @click="updateProduct" class="px-4 py-2 bg-orange-600 text-white rounded-md">Update</button>
          </div>
        </div>
      </div>
    </AdminLayout>
  </template>
  
 