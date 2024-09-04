<script setup>
import { ref, computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import FooterLayout from '@/Layouts/FooterLayout.vue';

const props = defineProps({
  subscriptions: Array,
});

const formatDate = (dateString) => {
  const date = new Date(dateString);
  const day = date.getDate();
  const month = date.getMonth() + 1;
  const year = date.getFullYear();
  const formattedDay = day < 10 ? `0${day}` : day;
  const formattedMonth = month < 10 ? `0${month}` : month;
  return `${formattedDay}/${formattedMonth}/${year}`;
};

const capitalizeFirstLetter = (string) => {
  return string.charAt(0).toUpperCase() + string.slice(1);
};

const subscriptions = ref(props.subscriptions.map(subscription => ({
  ...subscription,
  showItems: false, // Add showItems property to each subscription
}))
 .sort((a, b) => new Date(b.created_at) - new Date(a.created_at)));

const toggleDropdown = (subscriptionId) => {
  const subscription = subscriptions.value.find(sub => sub.id === subscriptionId);
  if (subscription) {
    subscription.showItems = !subscription.showItems;
  }
};

const invoiceIconUrl = computed(() => {
    // Assuming you have a route or endpoint to fetch the icon URL
    return '/invoice.png'; // Replace with your actual dynamic URL
});

const downloadInvoice = async (subscriptionId) => {
    try {
        const result = await axios.get(`/subscription/${subscriptionId}/invoice`, { responseType: 'blob' });
        const url = window.URL.createObjectURL(new Blob([result.data]));
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', `invoice_${subscriptionId}.pdf`);
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

<template>
  <FooterLayout>
    <AuthenticatedLayout>
      <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6 text-center">Your Subscription</h1>
        <div v-if="subscriptions.length === 0" class="text-center text-gray-500">No subscription found.</div>
        <div v-else>
          <div v-for="subscription in subscriptions" :key="subscription.id" class="border rounded-lg p-4 mb-4">
            <div class="flex justify-between items-start">
              <div>
                <h2 v-if="subscription.type === 'Monthly'" class="text-lg font-semibold">Monthly</h2>
                <h2 v-if="subscription.type === 'Weekly'" class="text-lg font-semibold">Weekly</h2>
                <h2 v-if="subscription.type === 'Bi-Weekly'" class="text-lg font-semibold">Bi-weekly</h2>
                <p class="text-black">Subscription ID: {{ subscription.id }}</p> 
                <p class="text-gray-500">Duration: {{ subscription.duration }} days</p> 
                <p class="text-gray-500">Started on: {{ formatDate(subscription.start_date) }}</p>
                <p class="text-gray-500 mb-4">End on: {{ formatDate(subscription.end_date) }}</p>
                <div>
                    <span class="mr-2 font-bold">Payment Status:</span>
                    <span class="text-blue-500">{{ capitalizeFirstLetter(subscription.payments[0].status) }}</span>
                </div>
                <div>
                    <span class="mr-2 font-bold">Subscription Status:</span>
                    <span class="text-blue-500">{{ capitalizeFirstLetter(subscription.status) }}</span>
                </div>
             
              </div>
              <div class="flex flex-col justify-between items-end ">
                <button @click="toggleDropdown(subscription.id)" class="text-yellow-950 flex items-center">
                  <span>Subscription Item</span>
                  <svg :class="{'transform rotate-180': subscription.showItems}" class="ml-2 h-5 w-5 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                  </svg>
                </button>
                <p class="text-lg font-bold mt-32">Total: RM {{ parseFloat(subscription.price).toFixed(2) }}</p>
              </div>
            </div>
            <div v-if="subscription.showItems" class="mt-10 text-center">
              <h3 class="font-semibold mb-2">Subscription Item:</h3>
              <div v-if="subscription.recommendation && subscription.recommendation.product" class="mb-2">
                <div class="flex justify-center">
                  <img :src="subscription.recommendation.product.image_url" alt="Product Image" class="w-40 h-40 object-cover mb-2 mx-auto" />
                </div>
                <p>{{ subscription.recommendation.product.name }} </p>
                <p>RM {{ parseFloat(subscription.recommendation.product.price).toFixed(2) }}</p>
                <div>
                    <p v-if="subscription.shipping"> <span style="font-weight: bold;">Shipping Status:</span> Shipped</p>
                    <p v-else><span style="font-weight: bold;">Shipping Status:</span> Pending</p>
                    <p v-if="subscription.shipping"><span style="font-weight: bold;">Courier: </span>{{ subscription.shipping.shipping_type }}</p>
                    <p v-if="subscription.shipping"><span style="font-weight: bold;">Tracking Number:</span> {{ subscription.shipping.tracking_number }}</p>
                </div>
                <div class="text-right">
                  <button @click="downloadInvoice(subscription.id)" class="text-blue-500 underline" title="Download Invoice" v-if="subscription.payments[0].status === 'Confirmed'">
                    <img :src="invoiceIconUrl" alt="Download Invoice" class="h-6 ml-5 w-6 inline-block">
                  </button>
                </div>
              </div>
              <p v-else class="text-gray-500">No product found for this subscription.</p>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </FooterLayout>
</template>


