<script setup>
import { ref, computed } from 'vue';
import { Head, usePage } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import axios from 'axios';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Modal from '@/References/OrderReceipt.vue'; 
import OrderShipping from '@/References/OrderShipping.vue';

const { props } = usePage();
const orders = ref(props.value.orders);

const todayOrder = computed(() => {
    const today = new Date().toDateString();
    return orders.value.filter(order => new Date(order.start_date).toDateString() === today).length;
});

const pendingOrder = computed(() => {
    return orders.value.filter(order => order.status === 'Pending').length;
});

const showModal = ref(false);
const selectedImage = ref('');
const flashMessage = ref(props.value.flash?.success || '');

if (props.value.flash && props.value.flash.success) {
  flashMessage.value = props.value.flash.success;
}

const openModal = (image) => {
    selectedImage.value = image;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
};

// Confirmation state
const confirmingOrder = ref(false);
const confirmAction = ref('');
const orderToConfirm = ref(null);

const confirmOrder = (order) => {
    confirmingOrder.value = true;
    confirmAction.value = 'confirm';
    orderToConfirm.value = order;
};

const cancelOrder = (order) => {
    confirmingOrder.value = true;
    confirmAction.value = 'cancel';
    orderToConfirm.value = order;
};

const proceedAction = async (orderId, action) => {
    try {
        const result = await axios.post(`/orders/${orderId}/${action}`);
        if (result.status === 200) {
            Inertia.visit(window.location.href); // Correctly use the Inertia object
        } else {
            console.error('Failed to update order status');
        }
    } catch (error) {
        console.error('Error updating order status:', error);
    }
};

const resetConfirmation = () => {
    confirmingOrder.value = false;
    confirmAction.value = '';
    orderToConfirm.value = null;
};

const confirmOrderAction = async () => {
    if (orderToConfirm.value) {
        await proceedAction(orderToConfirm.value.id, 'confirm');
        resetConfirmation();
    }
};

const cancelOrderAction = async () => {
    if (orderToConfirm.value) {
        await proceedAction(orderToConfirm.value.id, 'cancel');
        resetConfirmation();
    }
};

const editingOrder = ref(null);
const showEditModal = ref(false);

const openEditModal = (order) => {
  console.log('Opening edit modal for order:', order); // Debugging line
  editingOrder.value = order;
  showEditModal.value = true;
};

const closeEditModal = () => {
  showEditModal.value = false;
  editingOrder.value = null;
};

const deleteOrder = async (orderId) => {
    if (confirm('Are you sure you want to delete this order?')) {
        try {
            await axios.delete(`/admin/orders/${orderId}`);
            Inertia.visit(window.location.href); // Refresh the page
        } catch (error) {
            console.error('Error deleting order:', error);
        }
    }
};

</script>

<template>
    <AdminLayout>
        <Head title="Order Centre" />
        <div class="p-6 bg-white border-b border-gray-200">
            <div v-if="flashMessage" class="alert alert-success">
            {{ flashMessage }}
            </div>
            <h1 class="text-2xl font-semibold text-yellow-950">Order Centre</h1>
            <div class="mt-10">
                <div class="flex justify-between mb-10">
                    <div class="bg-[#a08671]/10 p-6 rounded-xl shadow-md">
                        <div class="text-xl font-bold">{{ orders.length }}</div>
                        <div>Total Orders</div>
                    </div>
                    <div class="bg-[#a08671]/10 p-6 rounded-xl shadow-md">
                        <div class="text-xl font-bold">{{ todayOrder }}</div>
                        <div>New Orders</div>
                    </div>
                    <div class="bg-[#a08671]/10 p-6 rounded-xl shadow-md">
                        <div class="text-xl font-bold">{{ pendingOrder }}</div>
                        <div>Pending Orders</div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200 text-center">
                        <thead class="bg-[#dad8d7]">
                            <tr>
                                <th class="py-2 px-4 border-b text-center">Name</th>
                                <th class="py-2 px-4 border-b text-center">Payment Type</th>
                                <th class="py-2 px-4 border-b text-center">Amount</th>
                                <th class="py-2 px-4 border-b text-center">Status</th>
                                <th class="py-2 px-4 border-b text-center">Date</th>
                                <th class="py-2 px-4 border-b text-center">References</th>
                                <th class="py-2 px-4 border-b text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="order in orders" :key="order.id">
                                <td class="py-2 px-4 border-b">{{ order.user.name }}</td>
                                <td class="py-2 px-4 border-b">{{ order.payment.type }}</td>
                                <td class="py-2 px-4 border-b">{{ order.total_price }}</td>
                                <td class="py-2 px-4 border-b">{{ order.status }}</td>
                                <td class="py-2 px-4 border-b">{{ new Date(order.created_at).toLocaleDateString() }}</td>
                                <td class="py-2 px-4 border-b">
                                    <button @click="openModal(order.payment.payment_proof_url)" class="text-blue-500 underline">View Receipt</button>
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <template v-if="order.status === 'Pending'">
                                        <span @click="confirmOrder(order)" class="cursor-pointer text-green-600 hover:text-green-900" title="Confirm Order">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </span>
                                        <span @click="cancelOrder(order)" class="cursor-pointer text-red-600 hover:text-red-900" title="Cancel Order">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </span>
                                    </template>
                                    <template v-else-if="order.status === 'Confirmed'">
                                        <button 
                                            @click="openEditModal(order)" 
                                            class="bg-green-500 text-white px-2 py-1 mr-4 rounded">
                                            Edit
                                        </button>
                                        <button 
                                            @click="deleteOrder(order.id)" 
                                            class="bg-red-500 text-white px-2 py-1 rounded">
                                            Delete
                                        </button>
                                    </template>
                                    <template v-else>
                                        <!-- Add any additional actions or text if needed for 'Cancelled' status -->
                                    </template>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Modal Component -->
        <Modal :visible="showModal" :image-src="selectedImage" @close="closeModal" />
     <!-- Include OrderShipping Modal -->
        <OrderShipping
        v-if="showEditModal"
        :order="editingOrder"
        @close="closeEditModal"
        @shipping-updated="refreshShippingTable"
        />
        <!-- Confirmation Dialog -->
        <div v-if="confirmingOrder" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-4 rounded-lg shadow-lg">
                <p class="mb-4">Are you sure you want to {{ confirmAction === 'confirm' ? 'confirm' : 'cancel' }} this order?</p>
                <div class="flex justify-between">
                    <button @click="confirmAction === 'confirm' ? confirmOrderAction() : cancelOrderAction()" class="bg-green-500 text-white px-4 py-2 rounded mr-2">Yes</button>
                    <button @click="resetConfirmation" class="bg-red-500 text-white px-4 py-2 rounded ml-2">No</button>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<style scoped>
/* Add any necessary styling here */
</style>
