<script setup>
import { ref, computed, onMounted} from 'vue';
import { Head, usePage } from '@inertiajs/inertia-vue3';
import axios from 'axios';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const { props } = usePage();
const users = ref(props.value.users);

// Filter users with role != 1
const filteredUsers = computed(() => {
    return users.value.filter(user => user.role !== 1);
});

// Function to delete a user
const deleteUser = async (userId) => {
    if (confirm('Are you sure you want to delete this user?')) {
        try {
            await axios.delete(`/admin/users/${userId}`);
            // Assuming you want to refresh the user list after deletion
            // Fetch users again or update the user list in another way
            // Example:
            // await fetchUsers(); // You should have a function to fetch users
        } catch (error) {
            console.error('Error deleting user:', error);
        }
    }
};

// Function to fetch users again (if needed)
const fetchUsers = async () => {
    try {
        const response = await axios.get('/admin/users');
        users.value = response.data.users; // Update the users ref with new data
    } catch (error) {
        console.error('Error fetching users:', error);
    }
};

// Lifecycle hook to fetch users when the component is mounted
onMounted(() => {
    fetchUsers();
});

</script>

<template>
    <AdminLayout>
        <Head title="User Management" />
        <div class="p-6 bg-white border-b border-gray-200">
            <h1 class="text-2xl font-semibold text-yellow-950 mb-6">User Management</h1>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 text-center">
                    <thead class="bg-[#dad8d7]">
                        <tr>
                            <th class="py-2 px-4 border-b">Name</th>
                            <th class="py-2 px-4 border-b">Email</th>
                            <th class="py-2 px-4 border-b">Role</th>
                            <th class="py-2 px-4 border-b">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in filteredUsers" :key="user.id">
                            <td class="py-2 px-4 border-b">{{ user.name }}</td>
                            <td class="py-2 px-4 border-b">{{ user.email }}</td>
                            <td class="py-2 px-4 border-b">{{ user.role }}</td>
                            <td class="py-2 px-4 border-b">
                                <!-- Add actions like edit, delete, etc. -->
                                <button @click="deleteUser(user.id)" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                                <!-- You can add more actions here -->
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AdminLayout>
</template>

<style scoped>
/* Add any necessary styling here */
</style>
