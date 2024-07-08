<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/inertia-vue3';



</script>

<template>
    <div class="bg-orange-100/10 ">
                     <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                        <header class="grid grid-cols-4 items-center gap-2 py-10 lg:grid-cols-6">
                            <div class="lg:flex lg:items-center lg:col-span-3">
                                <a href="/" class="flex items-center ml-16">
                                    <img
                                    id="logo"
                                    class="h-12 w-auto text-white lg:h-16 lg:text-[#FF2D20] cursor-pointer"
                                    src="icon.png"
                                    alt="Logo"
                                    />
                                    <h2 class="text-black text-lg font-serif ml-1 lg:ml-1">BrewBox</h2>
                                </a>
                                </div>
                                <div class="flex lg:col-2 items-center">
                                
                                    <Link
                                            :href="route('products.index')"
                                            class="rounded-md px-3 py-2 mr-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-yellow-950 dark:hover:text-yellow-700/80 dark:focus-visible:ring-white"
                                        >
                                            Shop
                                        </Link>
                                    <Link
                                            :href="route('subscription.main')"
                                            class="rounded-md px-3 py-2 mr-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-yellow-950 dark:hover:text-yellow-700/80 dark:focus-visible:ring-white"
                                        >
                                            Subscription
                                        </Link>
                                    <Link
                                            :href="route('discover')"
                                            class="rounded-md px-3 py-2 mr-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-yellow-950 dark:hover:text-yellow-700/80 dark:focus-visible:ring-white"
                                        >
                                            Discover
                                        </Link>
                                    
                                    <Link
                                            :href="route('about')"
                                            class="rounded-md px-3 py-2 mr-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-yellow-950 dark:hover:text-yellow-700/80 dark:focus-visible:ring-white"
                                        >
                                            About
                                    </Link>
                                
                                    <Link
                                            :href="route('contact')"
                                            class="rounded-md px-3 py-2 mr-2 text-yellow-950 ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-yellow-950 dark:hover:text-yellow-700/80 dark:focus-visible:ring-white"
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
                                    <a href="/cart">
                                    <img
                                        id="cart"
                                        class="h-6 ml-16 w-auto text-white lg:5"
                                        src="home/cart.png"
                                        alt="cart"
                                    />
                                    </a>
                                    <Link
                                            :href="route('login')"
                                            class=" ml-12 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-yellow-950 dark:hover:text-yellow-700/80 dark:focus-visible:ring-white"
                                        >
                                            Login
                                        </Link>

                                        <Link
                                            :href="route('register')"
                                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-yellow-950 dark:hover:text-yellow-700/80 dark:focus-visible:ring-white"
                                        >
                                            Register
                                        </Link>
                            </div>
                        </header>
                     </div>
                    <div class="min-h-screen flex flex-col sm:justify-center items-center bg-orange-100/10 ">
                        <div
                            class="w-full sm:max  bg-white shadow-md overflow-hidden sm:rounded-lg "
                        >
                            <slot />
                        </div>
                    </div>
</div>
</template>
