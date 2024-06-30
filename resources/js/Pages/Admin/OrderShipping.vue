<template>
    <div v-if="showEditModal" class="modal">
        <!-- Modal content and styles -->
        <form @submit.prevent="updateShipping">
            <label for="shipping_type">Shipping Type:</label>
            <input type="text" v-model="shippingType" required />

            <label for="tracking_number">Tracking Number:</label>
            <input type="text" v-model="trackingNumber" required />

            <button type="submit">Update Shipping</button>
            <button @click="closeModal">Cancel</button>
        </form>
    </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps(['order']);
const shippingType = ref(props.order.shipping_type || '');
const trackingNumber = ref(props.order.tracking_number || '');
const showEditModal = ref(false);

const updateShipping = () => {
    Inertia.put(`/admin/orders/${props.order.id}/update-shipping`, {
        shipping_type: shippingType.value,
        tracking_number: trackingNumber.value,
    }).then(() => {
        closeModal();
        Inertia.visit(window.location.href); // Refresh the page after update
    });
};

const closeModal = () => {
    showEditModal.value = false;
};

onMounted(() => {
    console.log('Order data in modal:', props.order);
    showEditModal.value = true; // Ensure modal shows on mount or on edit trigger
});

watch(() => props.order, () => {
    // Update form fields when order prop changes
    shippingType.value = props.order.shipping_type || '';
    trackingNumber.value = props.order.tracking_number || '';
});
</script>
