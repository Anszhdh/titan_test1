<template>
  <FooterLayout>
    <AuthenticatedLayout>
      <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Your Orders</h1>
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
            <div v-if="order.showDetails" class="mt-4 ">
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
                  </tr>
                </tbody>
              </table>
              <div class="mt-4">
                <div>
                <p v-if="order.shipping"><strong>Shipping Status:</strong> Shipped</p>
                <p v-else-if="order.status === 'Cancelled'"><strong>Shipping Status:</strong> Cancelled</p>
                <p v-else><strong>Shipping Status:</strong> Pending</p>
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
</template>

<script setup>
import { ref, computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import FooterLayout from '@/Layouts/FooterLayout.vue';

const props = defineProps({
  orders: Array,
});

const orders = ref(props.orders.map(order => ({
  ...order,
  orderItems: order.order_items, // Map order_items to orderItems
  showDetails: false, // Add showDetails property to each order
})));

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

const invoiceIconUrl = computed(() => {
    // Assuming you have a route or endpoint to fetch the icon URL
    return '/invoice.png'; // Replace with your actual dynamic URL
});

const toggleDropdown = (orderId) => {
  const order = orders.value.find(ord => ord.id === orderId);
  if (order) {
    order.showDetails = !order.showDetails;
  }
};
</script>

<style scoped>
.container {
  max-width: 800px;
}
</style>
