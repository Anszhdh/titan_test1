<script setup>
import { ref, watch, onMounted } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
  order: {
    type: Object,
    required: true,
  },
});

const emit = defineEmits(['close', 'shipping-updated']);

const showModal = ref(true);
const shippingType = ref('');
const trackingNumber = ref('');

const updateShipping = async () => {
    await Inertia.put(`/admin/orders/${props.order.id}/update-shipping`, {
        shipping_type: shippingType.value,
        tracking_number: trackingNumber.value,
    });
    emit('shipping-updated'); // Emit an event to notify the parent component
    closeModal();
};

const closeModal = () => {
    showModal.value = false;
    emit('close'); // Emit close event to parent component
};

onMounted(() => {
    // Check if order already has shipping details
    if (props.order.shipping) {
        shippingType.value = props.order.shipping.shipping_type || '';
        trackingNumber.value = props.order.shipping.tracking_number || '';
    }
});

watch(() => props.order, (newOrder) => {
    // Update fields if order changes
    if (newOrder.shipping) {
        shippingType.value = newOrder.shipping.shipping_type || '';
        trackingNumber.value = newOrder.shipping.tracking_number || '';
    } else {
        shippingType.value = '';
        trackingNumber.value = '';
    }
});
</script>

<template>
  <div v-if="showModal" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
      <form @submit.prevent="updateShipping">
        <h1 class="font-bold text-xl mb-6">Shipping Information</h1>
        <div class="mb-4">
          <label for="shipping_type" class="block text-gray-700">Shipping Type:</label>
          <input type="text" v-model="shippingType" id="shipping_type" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required />
        </div>
        <div class="mb-4">
          <label for="tracking_number" class="block text-gray-700">Tracking Number:</label>
          <input type="text" v-model="trackingNumber" id="tracking_number" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required />
        </div>
        <div class="flex justify-end">
          <button type="button" @click="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancel</button>
          <button type="submit" class="bg-yellow-950 hover:bg-yellow-950/80 text-white px-4 py-2 rounded">Update</button>
        </div>
      </form>
    </div>
  </div>
</template>
