<template>
    <template v-if="isLoggedIn">
  <FooterLayout>
      <AuthenticatedLayout>
        <div class="container bg-orange-100/10 mx-auto p-8">
          <h1 class="text-4xl font-bold mb-6 text-yellow-950">TITAN PARTNER PROGRAM</h1>
          <p class="text-lg mb-4">
            Titan Partner Program is hiring dealers and workshops to handle our ranges of coilover and suspension products. Feel free to get in touch with us!
          </p>
          <!-- Button to redirect to Dealer Registration -->
          <div class="mt-6">
            <Link :href="dealerRegisterUrl"> <!-- Use the passed URL -->
              <button class="bg-orange-600 text-white font-bold py-2 px-4 rounded hover:bg-orange-600/80">
                Register as a Dealer
              </button>
            </Link>
          </div>
        </div>
        
      </AuthenticatedLayout>
  </FooterLayout>

    </template>
    <template v-else>
  <FooterLayout>
      <GuestLayout>
        <div class="bg-black min-h-screen">   
    <div class="container mx-auto bg-black p-8">
      <h1 class="text-4xl font-bold mb-6 text-orange-600">TITAN PARTNER PROGRAM</h1>
          <p class="text-lg text-white mb-4">
            Titan Partner Program is hiring dealers and workshops to handle our ranges of coilover and suspension products. Feel free to get in touch with us!
          </p>
          <div class="mt-6">
            <a :href="dealerRegisterUrl"> <!-- Use the passed URL -->
              <button class="bg-orange-600 text-white font-bold py-2 px-4 rounded hover:bg-orange-600/80">
                Register as a Dealer
              </button>
            </a>
          </div>

        </div>
        </div>
      </GuestLayout>
  </FooterLayout>
    </template>
</template>

<script setup>
import { defineProps } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import FooterLayout from '@/Layouts/FooterLayout.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps(['isLoggedIn', 'dealerRegisterUrl']); // Add dealerRegisterUrl
</script>

<style scoped>
.container {
  max-width: 1200px;
}
</style>
