<template>
  <div class="relative" @click.stop="toggleDropdown">
    <button class="relative focus:outline-none">
      <svg
        :class="['h-6 w-6', iconColor]"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-5-5.917V4a2 2 0 10-4 0v1.083A6.002 6.002 0 004 11v3.159c0 .538-.214 1.055-.595 1.436L2 17h5m4 0v1a3 3 0 01-6 0v-1m6 0H9"
        />
      </svg>
      <span
        v-if="unreadCount"
        class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full"
      >
        {{ unreadCount }}
      </span>
    </button>
    <div
      v-if="dropdownOpen"
      class="absolute right-0 mt-2 w-60 bg-white rounded-md shadow-lg z-20"
    >
      <ul>
        <li
          v-for="notification in notifications"
          :key="notification.id"
          class="p-2 border-b hover:bg-gray-100 cursor-pointer"
          @click="markAsRead(notification.id)"
        >
          {{ notification.data.message }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, defineProps } from 'vue';
import axios from 'axios';

const props = defineProps({
  iconColor: {
    type: String,
    default: 'text-white',
  },
});

const notifications = ref([]);
const unreadCount = ref(0);
const dropdownOpen = ref(false);

const fetchNotifications = async () => {
  const response = await axios.get('/notifications');
  notifications.value = response.data.notifications;
  unreadCount.value = response.data.unreadCount;
};

const markAsRead = async (notificationId) => {
  await axios.post(`/notifications/${notificationId}/read`);
  fetchNotifications();
};

const toggleDropdown = () => {
  dropdownOpen.value = !dropdownOpen.value;
};

onMounted(() => {
  fetchNotifications();
});
</script>

<style scoped>
/* Add any required styles */
</style>
