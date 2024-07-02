<template>
    <div>
      <slot></slot>
      <Footer />
    </div>
  </template>
  
  <script>
  import Footer from './Footer.vue';
  
  export default {
    name: 'FooterLayout',
    components: {
      Footer
    }
  };
  </script>
  
  <style scoped>
  /* Add any custom styles here */
  </style>
  