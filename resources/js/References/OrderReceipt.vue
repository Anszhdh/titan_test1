<template>
    <div v-if="visible" class="fixed inset-0 z-50 overflow-auto bg-smoke-light flex">
      <div class="relative p-8 bg-white w-full max-w-md m-auto flex-col flex rounded-lg">
        <span @click="close" class="absolute top-0 right-0 p-4 cursor-pointer">✖</span>
        <img :src="imageSrc" alt="Payment Proof" class="w-full h-auto rounded-md">
      </div>
    </div>
  </template>
  
  <script setup>
  import { defineProps, defineEmits } from 'vue';
  
  const props = defineProps({
    visible: Boolean,
    imageSrc: String,
  });
  
  const emit = defineEmits(['close']);
  
  const close = () => {
    emit('close');
  };
  </script>
  
  <style scoped>
  .bg-smoke-light {
    background: rgba(0, 0, 0, 0.5);
  }
  </style>
  