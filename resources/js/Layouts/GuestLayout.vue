<script setup>
import { usePage } from '@inertiajs/inertia-vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/inertia-vue3';

// Access the shared page props
const { props } = usePage();
const isLoggedIn = !!props?.auth?.user;


</script>


<template>
    <div class="bg-black">
                     <div class="relative w-full max-w-2xl px-6 lg:max-w-3xl">
                        <header class="grid grid-cols-4 items-center gap-2 py-10 lg:grid-cols-6">
                            <div class="lg:flex lg:items-center lg:col-span-5">
                                <a href="/" class="flex items-center ml-16">
                                    <img
                                    id="logo"
                                    class="h-12 w-auto text-white lg:h-16 lg:text-[#FF2D20] cursor-pointer"
                                    src="/icon.png"
                                    alt="Logo"
                                    />
                                </a>
                                </div>
                                <div class="flex lg:col-2 items-center">
                                
                                    <Link
                                            :href="isLoggedIn ? route('products.index') : route('login')"
                                            class="rounded-md px-3 py-2 mr-2 text-white ring-1 ring-transparent transition hover:text-gray-600  focus:outline-none focus-visible:ring-[#FF2D20] dark:text-yellow-950 dark:hover:text-yellow-700/80 dark:focus-visible:ring-white"
                                        >
                                            Shop
                                    </Link>
                                    <!-- <Link
                                            :href="isLoggedIn ? route('subscription.main') : route('login')"
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
                                            class="rounded-md px-3 py-2 mr-2 text-white ring-1 ring-transparent transition hover:text-gray-600  focus:outline-none focus-visible:ring-[#FF2D20] dark:text-yellow-950 dark:hover:text-yellow-700/80 dark:focus-visible:ring-white"
                                        >
                                            About
                                    </Link>
                                
                                    <Link
                                              :href="isLoggedIn ? route('contact') : route('login')"
                                            class="rounded-md px-3 py-2 mr-2 text-white ring-1 ring-transparent transition hover:text-gray-600 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-yellow-950 dark:hover:text-yellow-700/80 dark:focus-visible:ring-white"
                                        >
                                            Contact
                                        </Link>
                                    <!-- <img
                                        id="search"
                                        class="h-6 ml-16 w-auto text-white lg:5"
                                        src="home/search.png"
                                        alt="search"
                                    />
                                     -->
                                     <!-- <a :href="isLoggedIn ? '/cart' : route('login')">
                                        <img
                                        id="cart"
                                        class="h-6 ml-16 w-auto text-white lg:5"
                                        src="/home/cart.png"
                                        alt="cart"
                                        />
                                    </a> -->
                                    <Link
                                            :href="route('login')"
                                            class=" ml-12 text-white ring-1 ring-transparent transition hover:text-gray-600 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-yellow-950 dark:hover:text-yellow-700/80 dark:focus-visible:ring-white"
                                        >
                                            Login
                                        </Link>

                                        <Link
                                            
                                            :href="route('register')"
                                            class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-gray-600 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-yellow-950 dark:hover:text-yellow-700/80 dark:focus-visible:ring-white"
                                        >
                                            Register
                                        </Link>
                            </div>
                        </header>
                     </div>
                    <div class="min-h-screen  flex-col sm:justify-center items-center bg-orange-100/10 ">
                        <div
                            class="w-full sm:max  bg-orange-100/10 shadow-md overflow-hidden sm:rounded-lg "
                        >
                            <slot />
                        </div>
                    </div>
</div>
</template>
