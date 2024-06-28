<script setup>
import { ref } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';
import { Link } from '@inertiajs/inertia-vue3';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';

const showingNavigationDropdown = ref(false);
const sidebarOpen = ref(false);

const { url } = usePage();
const currentRoute = ref(url);
</script>

<template>
    <div class="flex h-screen bg-yellow-950/50">
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'block' : 'hidden lg:block'" class="bg-white w-64 h-full shadow-md lg:block">
            <div class="flex items-center mb-6">
                <div class="p-3">
                    <img id="logo" class="h-12 w-auto text-white lg:h-14 lg:text-[#FF2D20] cursor-pointer" src="/icon.png" alt="Logo" />
                </div>
                <a href="/" class="text-black text-2xl font-semibold uppercase hover:text-gray-300 ml-2">BrewBox</a>
            </div>
            <nav>
                <Link :href="route('dashboard')" class="block py-2.5 px-4 rounded transition duration-200"
                      :class="{'bg-yellow-950/10 text-yellow-900': currentRoute.value === route('dashboard').url, 'hover:bg-yellow-950/10 hover:text-gray-700': currentRoute.value !== route('dashboard').url}">
                    <i class="fas fa-chart-line"></i> Dashboard
                </Link>
                <a :href="route('notifications')" 
                   :class="{'bg-yellow-950/10 text-yellow-900': currentRoute === route('notifications'), 'hover:bg-yellow-950/10 hover:text-gray-700': currentRoute !== route('notifications')}"
                   class="block py-2.5 px-4 rounded transition duration-200">
                    <i class="fas fa-bell"></i> Notifications
                </a>
                <a :href="route('order-centre')" 
                   :class="{'bg-yellow-950/10 text-yellow-900': currentRoute === route('order-centre'), 'hover:bg-yellow-950/10 hover:text-gray-700': currentRoute !== route('order-centre')}"
                   class="block py-2.5 px-4 rounded transition duration-200">
                    <i class="fas fa-shopping-cart"></i> Order Centre
                </a>
               <a :href="route('product-centre')" 
                   :class="{'bg-yellow-950/10 text-yellow-900': currentRoute === route('product-centre'), 'hover:bg-yellow-950/10 hover:text-gray-700': currentRoute !== route('product-centre')}"
                   class="block py-2.5 px-4 rounded transition duration-200">
                    <i class="fas fa-box-open"></i> Product Centre
                </a>
                
               <a :href="route('subscription-centre')" 
                   :class="{'bg-yellow-950/10 text-yellow-900': currentRoute === route('subscription-centre'), 'hover:bg-yellow-950/10 hover:text-gray-700': currentRoute !== route('subscription-centre')}"
                   class="block py-2.5 px-4 rounded transition duration-200">
                    <i class="fas fa-calendar-check"></i> Subscription Centre
                </a> 
             
              
                <a :href="route('sales-report')" 
                   :class="{'bg-yellow-950/10 text-yellow-900': currentRoute === route('sales-report'), 'hover:bg-yellow-950/10 hover:text-gray-700': currentRoute !== route('sales-report')}"
                   class="block py-2.5 px-4 rounded transition duration-200">
                    <i class="fas fa-chart-bar"></i> Sales Performance
                </a>
                <a :href="route('billings-report')" 
                   :class="{'bg-yellow-950/10 text-yellow-900': currentRoute === route('billings-report'), 'hover:bg-yellow-950/10 hover:text-gray-700': currentRoute !== route('billings-report')}"
                   class="block py-2.5 px-4 rounded transition duration-200">
                    <i class="fas fa-file-invoice-dollar"></i> Billings
                </a>
            </nav>

           <!-- Settings Link and Admin Profile Section at the Bottom -->
           <div class="flex flex-col justify-end mt-14 p-4 bg-white border-t border-gray-200">
                <a :href="route('settings')" 
                   :class="{'bg-gray-200 text-gray-700': currentRoute === route('settings'), 'hover:bg-gray-200 hover:text-gray-700': currentRoute !== route('settings')}"
                   class="flex items-center py-2.5 px-4 rounded transition duration-200 mb-4">
                    <i class="fas fa-cog mr-3"></i> Settings
                </a>

                <div class="flex items-center">
                    <img src="/storage/admin.jpg" alt="Admin Profile" class="w-10 h-10 rounded-full mr-3">
                    <div>
                        <div class="text-white-800 font-medium">{{ $page.props.auth.user.name }}</div>
                        <div class="text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                    </div>
                    <Dropdown align="right" width="48" class="ml-auto">
                        <template #trigger>
                            <button class="text-gray-500 hover:text-gray-700 focus:outline-none">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </template>
                        <template #content>
                            <DropdownLink :href="route('profile.edit')">Profile</DropdownLink>
                            <DropdownLink :href="route('logout')" method="post" as="button">Log Out</DropdownLink>
                        </template>
                    </Dropdown>
                </div>
            </div>
        </aside>

        <!-- Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="flex justify-between items-center bg-[#614d3b] py-4 px-6">
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
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white  hover:text-stone-200 focus:outline-none transition ease-in-out duration-150"
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

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-[#fdfdfd]">
                <div class="py-6 px-6">
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>
