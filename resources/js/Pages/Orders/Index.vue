<template>
  <FooterLayout>
    <AuthenticatedLayout>
      <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Your Orders</h1>
        <div v-if="successMessage" class="mb-4 p-4 text-green-700 bg-green-200 rounded-lg">
          {{ successMessage }}
        </div>
        <div v-if="orders.length === 0" class="text-center text-gray-500">No orders found.</div>
        <div v-else>
          <div v-for="order in orders" :key="order.id" class="border rounded-lg p-4 mb-4">
            <div class="flex justify-between items-center">
              <div>
                <h2 class="text-lg font-semibold">Order #{{ order.id }}</h2>
                <p class="text-gray-500">Placed on: {{ new Date(order.created_at).toLocaleDateString('en-GB') }}</p>
                <p class="text-gray-500">Status: {{ order.status }}</p>
              </div>
              <div class="text-right">
                <button @click="toggleDropdown(order.id)" class="text-yellow-950 flex items-center">
                  <span>Order Details</span>
                  <svg :class="{'transform rotate-180': order.showDetails}" class="ml-2 h-5 w-5 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                  </svg>
                </button>
                <p class="text-lg font-bold">Total: RM {{ parseFloat(order.total_price).toFixed(2) }}</p>
              </div>
            </div>
            <div v-if="order.showDetails" class="mt-4">
              <h3 class="font-semibold mb-2">Order Items:</h3>
              <table class="w-full text-left table-auto border-collapse">
                <thead>
                  <tr>
                    <th class="border-b px-4 py-2">#</th>
                    <th class="border-b px-4 py-2">Name</th>
                    <th class="border-b px-4 py-2">Image</th>
                    <th class="border-b px-4 py-2">Quantity</th>
                    <th class="border-b px-4 py-2">Unit Price</th>
                    <th class="border-b px-4 py-2">Total Price</th>
                    <th class="border-b px-4 py-2">Actions</th>
                  </tr>
                </thead>
                <tbody>
            <tr v-for="(item, index) in order.orderItems" :key="item.id">
              <td class="border-b px-4 py-2">{{ index + 1 }}</td>
              <td class="border-b px-4 py-2">{{ item.product.name }}</td>
              <td class="border-b px-4 py-2">
                <img :src="item.product.image_url" alt="Product Image" class="h-16 w-16 object-cover">
              </td>
              <td class="border-b px-4 py-2">{{ item.quantity }}</td>
              <td class="border-b px-4 py-2">RM {{ parseFloat(item.unit_price).toFixed(2) }}</td>
              <td class="border-b px-4 py-2">RM {{ (item.quantity * item.unit_price).toFixed(2) }}</td>
              <td class="border-b px-4 py-2">
                <!-- Check if the product has been reviewed -->
                  <button
              v-if="!hasReviewed(order.id, item.product.id) && order.status === 'Confirmed'"
              @click="openReviewModal(order.id, item.product.id)"
              class="bg-black text-sm hover:bg-black text-white font-bold px-2 rounded-xl focus:outline-none focus:shadow-outline"
            >
              Review Product
            </button>

              </td>
            </tr>
          </tbody>
              </table>
              <div class="mt-4">
              <div>
                  <p v-if="order.shipping"><strong>Shipping Status:</strong> Shipped</p>
                  <p v-else-if="order.status === 'Cancelled'"><strong>Shipping Status:</strong> Cancelled</p>
                  <p v-else><strong>Shipping Status:</strong> Pending</p>

                  <!-- Display courier and tracking number if shipping exists -->
                  <p v-if="order.shipping"><strong>Courier:</strong> {{ order.shipping.shipping_type }}</p>
                  <p v-if="order.shipping"><strong>Tracking Number:</strong> {{ order.shipping.tracking_number }}</p>
                </div>
                <div class="text-right">
                  <button @click="downloadInvoice(order.id)" class="text-blue-500 underline" title="Download Invoice" v-if="order.status === 'Confirmed'">
                    <img :src="invoiceIconUrl" alt="Download Invoice" class="h-6 ml-5 w-6 inline-block">
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </FooterLayout>
  
  <!-- Review Modal -->
  <div v-if="showReviewModal" class="fixed inset-0 overflow-y-auto z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="relative mx-auto max-w-4xl p-12 bg-white shadow-lg rounded-lg">
      <button @click="closeReviewModal" class="absolute top-0 right-0 m-4 text-gray-500 hover:text-gray-700 focus:outline-none">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
      <h2 class="text-xl font-semibold mb-4">Submit Review</h2>
      <form @submit.prevent="submitReview">
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="rating">Rating</label>
          <select v-model="reviewForm.rating" id="rating" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <option disabled value="">Select a rating</option>
            <option v-for="n in 5" :key="n" :value="n">{{ n }}</option>
          </select>
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="review">Review</label>
          <textarea v-model="reviewForm.review" id="review" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
        </div>
        <div class="text-right">
          <button type="submit" class="bg-black hover:bg-black text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Submit Review
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { usePage, router } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import FooterLayout from '@/Layouts/FooterLayout.vue';
import axios from 'axios';

const props = defineProps({
  orders: Array,
});

const orders = ref(props.orders
  .map(order => ({
    ...order,
    orderItems: order.order_items, // Map order_items to orderItems
    showDetails: false, // Add showDetails property to each order
  }))
  .sort((a, b) => new Date(b.created_at) - new Date(a.created_at)) // Sort orders by created_at in descending order
);
const successMessage = ref('');

const invoiceIconUrl = '/invoice.png'; // Replace with your actual dynamic URL

const toggleDropdown = (orderId) => {
  const order = orders.value.find(ord => ord.id === orderId);
  if (order) {
    order.showDetails = !order.showDetails;
  }
};

const showReviewModal = ref(false);
const reviewForm = ref({
  rating: '',
  review: '',
});
const orderId = ref(null);
const productId = ref(null);

function openReviewModal(orderIdValue, productIdValue) {
  orderId.value = orderIdValue;
  productId.value = productIdValue;
  showReviewModal.value = true;
}

function closeReviewModal() {
  showReviewModal.value = false;
}

async function submitReview() {
  try {
    const response = await axios.post(`/orders/${orderId.value}/review`, {
      rating: reviewForm.value.rating,
      review: reviewForm.value.review,
      product_id: productId.value,
    });

    if (response.data.message === 'Review submitted successfully') {
      successMessage.value = 'Review has been successfully submitted.';
      reviewForm.value.rating = ''; // Clear form fields
      reviewForm.value.review = '';
      closeReviewModal();
      
      // Use Inertia's visit method to refresh the page
      router.visit(window.location.pathname, {
        method: 'get',
        preserveScroll: true,
        preserveState: true,
      });
    }
  } catch (error) {
    console.error('Error submitting review:', error);
  }
}

// Function to check if a product has been reviewed in an order
function hasReviewed(orderId, productId) {
  const order = orders.value.find(order => order.id === orderId);
  if (!order) return false;

  return order.orderItems.some(item => {
    return item.product.id === productId && item.product.reviews.length > 0;
  });
}

const downloadInvoice = async (orderId) => {
  try {
    const result = await axios.get(`/orders/${orderId}/invoice`, { responseType: 'blob' });
    const url = window.URL.createObjectURL(new Blob([result.data]));
    const link = document.createElement('a');
    link.href = url;
    link.setAttribute('download', `invoice_${orderId}.pdf`);
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
  } catch (error) {
    console.error('Error downloading invoice:', error);
  }
};
</script>

<style scoped>
.container {
  max-width: 800px;
}
</style>