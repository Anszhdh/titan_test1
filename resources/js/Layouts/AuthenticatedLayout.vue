<script setup>
import { ref, onMounted } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import NotificationIcon from '@/Components/NotificationIcon.vue';

const showingNavigationDropdown = ref(false);

const cartCount = ref(0);

async function fetchCartCount() {
    try {
        const response = await fetch('/cart/count');
        const data = await response.json();
        cartCount.value = data.count;
    } catch (error) {
        console.error('Error fetching cart count:', error);
    }
}

onMounted(() => {
    fetchCartCount();
});
</script>


<template>
    <div>
        <div class="min-h-screen bg-orange-100/5">
            <nav class="bg-black border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="relative w-full max-w-2xl px-6 lg:max-w-4xl">
                        <header class="grid grid-cols-4 items-center gap-2 py-10 lg:grid-cols-4">
                            <div class="lg:flex lg:items-center lg:col-span-3">
                                <a href="/" class="flex items-center ml-20">
                                    <img
                                    id="logo"
                                    class="h-12 w-auto text-white lg:h-16 lg:text-[#FF2D20] cursor-pointer"
                                    src="/icon.png"
                                    alt="Logo"
                                    />
                                </a>
                                </div>
                            
                                <div class="flex lg:col-3 items-center">
                                
                                    <Link
                                            :href="route('products.index')"
                                            class="rounded-md px-3 py-2 mr-2 text-white ring-1 ring-transparent transition hover:text-gray-600 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-yellow-950 dark:hover:text-yellow-700/80 dark:focus-visible:ring-white"
                                        >
                                            Shop
                                        </Link>
                                    <!-- <Link
                                            :href="route('subscription.main')"
                                            class="rounded-md px-3 py-2 mr-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-yellow-950 dark:hover:text-yellow-700/80 dark:focus-visible:ring-white"
                                        >
                                            Subscription
                                        </Link> -->
                                        <Link
                                        v-if="userRole !== 2"
                                        :href="route('discover')"
                                        class="rounded-md px-3 py-2 mr-2 text-white ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-yellow-950 dark:hover:text-yellow-700/80 dark:focus-visible:ring-white"
                                        >
                                        Dealer
                                        </Link>
                                    
                                    <Link
                                            :href="route('about')"
                                            class="rounded-md px-3 py-2 mr-2 text-white ring-1 ring-transparent transition hover:text-gray-600 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-yellow-950 dark:hover:text-yellow-700/80 dark:focus-visible:ring-white"
                                        >
                                            About
                                    </Link>
                                
                                    <Link
                                            :href="route('contact')"
                                            class="rounded-md px-3 py-2 mr-2 text-white ring-1 ring-transparent transition hover:text-gray-600 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-yellow-950 dark:hover:text-yellow-700/80 dark:focus-visible:ring-white"
                                        >
                                            Contact
                                        </Link>
                                        <div class="flex items-center ml-40 mt-2" title="Notifications">
                                            <div class="space-x-4">
                                                <NotificationIcon iconColor="text-orange-600" />
                                            </div>
                                            <div class="relative ml-4 mb-1 flex items-center"> <!-- Ensure the container is a flexbox -->
                                                <a href="/cart ">
                                                <img
                                                    id="cart"
                                                    class="h-6 ml-6 w-auto text-white lg:5"
                                                    title="Cart"
                                                    src="/home/cart.png"
                                                    alt="cart"
                                                />
                                                <span v-if="cartCount > 0" class="absolute top-0 right-0 left-1  inline-flex  justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full">
                                                    {{ cartCount }}
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="hidden sm:flex sm:items-center sm:ms-6" >
                            <!-- Settings Dropdown -->
                            <div class="ms-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-orange-600 hover:text-gray-600 focus:outline-none transition ease-in-out duration-150"
                                            >
                                                {{ $page.props.auth.user.name }}

                                                <svg
                                                    class="ms-2 -me-0.5 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink :href="route('profile.edit')"> Profile </DropdownLink>
                                        <DropdownLink :href="route('user.orders')">Orders</DropdownLink>
                                        <!-- <DropdownLink :href="route('user.subscriptions')">Subscriptions</DropdownLink> -->
                                        <DropdownLink :href="route('logout')" method="post" as="button">
                                            Log Out
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>
                            </div>
                        </header>
                     </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                    class="sm:hidden"
                >
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Dashboard
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')"> My Account </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-yellow-950/90 shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-4 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
