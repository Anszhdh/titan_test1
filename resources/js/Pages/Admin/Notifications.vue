<template>
    <AdminLayout>
        <div>
            <h2>Admin Notifications</h2>
            <ul>
                <li v-for="notification in notifications" :key="notification.id">
                    <p>{{ notification.data.message }}</p>
                    <router-link :to="`/orders/${notification.data.order_id}`">View Order</router-link>
                </li>
            </ul>
        </div>
    </AdminLayout>
</template>

<script setup>
    import { ref, onMounted } from 'vue';
    import axios from 'axios';
    import AdminLayout from '@/Layouts/AdminLayout.vue';

    const notifications = ref([]);

    const fetchNotifications = async () => {
        try {
            const response = await axios.get('/admin/notifications');
            notifications.value = response.data;
        } catch (error) {
            console.error('Error fetching notifications:', error);
        }
    };

    onMounted(fetchNotifications);
</script>
