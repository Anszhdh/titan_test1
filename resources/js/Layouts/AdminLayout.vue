<script setup>
import { ref } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/inertia-vue3';

const showingNavigationDropdown = ref(false);
const sidebarOpen = ref(false);

const { url } = usePage();
const currentRoute = ref(url);
</script>


<template>
    <div class="flex h-screen bg-gray-200">
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'block' : 'hidden lg:block'" class="bg-white w-64 h-full shadow-md lg:block">
            <div class="flex items-center mb-6">
                <div class="p-3">
                    <img id="logo" class="h-12 w-auto text-white lg:h-14 lg:text-[#FF2D20] cursor-pointer" src="/icon.png" alt="Logo" />
                </div>
                <a href="/" class="text-black text-2xl font-semibold uppercase hover:text-gray-300 ml-2">BrewBox</a>
            </div>
            <nav>
                <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-200 hover:text-gray-700">
                    <i class="fas fa-chart-line"></i> Dashboard
                </a>
                <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-200 hover:text-gray-700">
                    <i class="fas fa-bell"></i> Notifications
                </a>
                <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-200 hover:text-gray-700">
                    <i class="fas fa-shopping-cart"></i> Order Centre
                </a>
                <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-200 hover:text-gray-700">
                    <i class="fas fa-box-open"></i> Product Centre
                </a>
                <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-200 hover:text-gray-700">
                    <i class="fas fa-warehouse"></i> Stock Management
                </a>
                <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-200 hover:text-gray-700">
                    <i class="fas fa-calendar-check"></i> Subscription
                </a>
                <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-200 hover:text-gray-700">
                    <i class="fas fa-users"></i> Audience
                </a>
                <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-200 hover:text-gray-700">
                    <i class="fas fa-bullhorn"></i> Campaign
                </a>
                <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-200 hover:text-gray-700">
                    <i class="fas fa-chart-bar"></i> Performance
                </a>
                <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-200 hover:text-gray-700">
                    <i class="fas fa-file-invoice-dollar"></i> Billings
                </a>
            </nav>
        </aside>

        <!-- Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="flex justify-between items-center bg-white py-4 px-6">
                <div class="flex items-center">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none lg:hidden">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                    </button>
                    <!-- <a href="/" class="flex items-center ml-4">
                      
                         <h2 class="text-black text-lg font-serif ml-1 lg:ml-1">BrewBox</h2> 
                    </a> -->
                </div>

                <div class="flex items-center">
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <span class="inline-flex rounded-md">
                                <button
                                    type="button"
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-orange-100/5 hover:text-orange-950/50 focus:outline-none transition ease-in-out duration-150"
                                >
                                    {{ $page.props.auth.user.name }}
                                    <svg
                                        class="ml-2 -mr-0.5 h-4 w-4"
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
                            <DropdownLink :href="route('profile.edit')">Profile</DropdownLink>
                            <DropdownLink :href="route('logout')" method="post" as="button">Log Out</DropdownLink>
                        </template>
                    </Dropdown>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
                <div class="py-6 px-6">
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>
