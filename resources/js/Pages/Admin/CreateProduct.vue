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
    flavor: '',
    roast_level: '',
    brewing_method: '',
    pre_ground: '',
    decaf: '',
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

  if (form.decaf === undefined) {
        form.decaf = 'false'; // Set default value to false
    }
    if (form.pre_ground === undefined) {
        form.pre_ground = 'false'; // Set default value to false
    }
    console.log('Form data:', form); // Log form data to console
    form.post(route('product-centre.store'), {
        onSuccess: () => {
            console.log('Form submitted successfully');
        },
        onError: (errors) => {
            console.error('Form submission error:', errors);
        }
    });
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
                <div class="mb-4">
                    <label for="flavor" class="block text-sm font-medium text-gray-700">Flavor:</label>
                    <select v-model="form.flavor" id="flavor" name="flavor" class="mt-1 p-2 w-full border rounded-md">
                        <option value="Fruity">Fruity</option>
                        <option value="Nutty">Nutty</option>
                        <option value="Chocolatey">Chocolatey</option>
                        <option value="Spicy">Spicy</option>
                        <option value="Others">Others</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="roast_level" class="block text-sm font-medium text-gray-700">Roast Level:</label>
                    <select v-model="form.roast_level" id="roast_level" name="roast_level" class="mt-1 p-2 w-full border rounded-md">
                        <option value="Light">Light</option>
                        <option value="Medium">Medium</option>
                        <option value="Dark">Dark</option>
                        <option value="Espresso">Espresso</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="brewing_method" class="block text-sm font-medium text-gray-700">Brewing Mehtod:</label>
                    <select v-model="form.brewing_method" id="brewing_method" name="brewing_method" class="mt-1 p-2 w-full border rounded-md">
                        <option value="Drip Coffee Maker">Drip Coffee Maker</option>
                        <option value="French Press">French Press</option>
                        <option value="Espresso Machine">Espresso Machine</option>
                        <option value="Pour Over">Pour Over</option>
                        <option value="Aeropress">Aeropress</option>
                        <option value="Cold Brew Maker">Cold Brew Maker</option>
                    </select>
                </div>
                <div class="mb-4">
                  <label class="block text-sm font-medium text-gray-700">Pre-Ground:</label>
                  <div>
                      <input type="radio" v-model="form.pre_ground" id="pre_ground_yes" :value="true" /> 
                      <label for="pre_ground_yes" class="mr-3">Yes</label>
                      <input type="radio" v-model="form.pre_ground" id="pre_ground_no" :value="false" /> 
                      <label for="pre_ground_no">No</label>
                  </div>
              </div>
              <div class="mb-4">
                  <label class="text-sm font-medium text-gray-700">Decaf:</label>
                  <div>
                      <input type="radio" v-model="form.decaf" id="decaf_yes" :value="true" /> 
                      <label for="decaf_yes" class="mr-3">Yes</label>
                      <input type="radio" v-model="form.decaf" id="decaf_no" :value="false" /> 
                      <label for="decaf_no">No</label>
                  </div>
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
