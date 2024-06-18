<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="Brewbox" />
    <div class="bg-orange-100/10 text-black/50 dark:text-white/50">
        <img
            id="background"
            class="absolute -left-20 top-0 max-w-[877px]"
            
        />
        <div
            class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white"
        >
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <header class="grid grid-cols-4 items-center gap-2 py-10 lg:grid-cols-6">
                  <div class="lg:flex lg:items-center lg:col-span-2">
                    <img
                        id="logo"
                        class="h-12 w-auto text-white lg:h-16 lg:text-[#FF2D20] cursor-pointer"
                        src="icon.png"
                        alt="Logo"
                        @click="navigateToHome"
                    />
                        
                        <h2 class="text-black text-lg font-serif ml-1 lg:ml-1">BrewBox</h2>
                    </div>
                 
                    <div class="flex lg:col-2 items-center">
                       
                        <Link
                                :href="route('products.index')"
                                class="rounded-md px-3 py-2 mr-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-yellow-950 dark:hover:text-yellow-700/80 dark:focus-visible:ring-white"
                            >
                                Shop
                            </Link>
                        <Link
                                :href="route('register')"
                                class="rounded-md px-3 py-2 mr-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-yellow-950 dark:hover:text-yellow-700/80 dark:focus-visible:ring-white"
                            >
                                Subscription
                            </Link>
                        <Link
                                :href="route('register')"
                                class="rounded-md px-3 py-2 mr-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-yellow-950 dark:hover:text-yellow-700/80 dark:focus-visible:ring-white"
                            >
                                Discover
                            </Link>
                        
                        <Link
                                :href="route('register')"
                                class="rounded-md px-3 py-2 mr-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-yellow-950 dark:hover:text-yellow-700/80 dark:focus-visible:ring-white"
                            >
                                About
                         </Link>
                       
                        <Link
                                :href="route('register')"
                                class="rounded-md px-3 py-2 mr-2 text-yellow-950 ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-yellow-950 dark:hover:text-yellow-700/80 dark:focus-visible:ring-white"
                            >
                                Contact
                            </Link>
                        <img
                            id="search"
                            class="h-6 ml-16 w-auto text-white lg:5"
                            src="home/search.png"
                            alt="search"
                        />
                        <a href="/cart">
                            <img
                                id="cart"
                                class="h-6 ml-16 w-auto text-white lg:5"
                                src="home/cart.png"
                                alt="cart"
                            />
                        </a>
                        <div class="hidden sm:flex sm:items-center sm:ms-6 "  v-if="$page.props.authenticated">
                            <!-- Settings Dropdown -->
                            <div class="ms-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class=" inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-orange-100/10 hover:text-yellow-950/50 focus:outline-none transition ease-in-out duration-150"
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
                                        <DropdownLink :href="route('logout')" method="post" as="button">
                                            Log Out
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>
                        <Link
                        v-if="!$page.props.authenticated"
                        :href="route('login')"
                        class="ml-12 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-yellow-950 dark:hover:text-yellow-700/80 dark:focus-visible:ring-white"
                    >
                        Login
                    </Link>

                    <Link
                        v-if="!$page.props.authenticated && canRegister"
                        :href="route('register')"
                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-yellow-950 dark:hover:text-yellow-700/80 dark:focus-visible:ring-white"
                    >
                        Register
                    </Link>
                    </div>
                </header>
                <main class="mt-6">
                    <div class="grid gap-6 lg:grid-cols- lg:gap-8">
                        <!-- <a class="flex items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] dark:bg-white dark:ring-white"> -->
                        <div class="flex-grow"> <!-- Flex container for the content -->
                            <div class="relative flex items-center gap-10 lg:items-end">
                                    <div id="docs-card-content" class="flex items-start gap-6 lg:flex-col">
                                        <div class="pt-3 ml-10 mr-20 sm:pt-5 lg:pt-0">
                                            <span class="text-5xl font-black ">
                                                <span class=" font-sans bg-gradient-to-r from-yellow-800 to-yellow-950 text-transparent bg-clip-text">BREWBOX</span>
                                            </span>
                                            <h2 class="mt-1 text-xl font-black font-sans text-yellow-950">Brewing dreams one cup at a time</h2>
                                            <h3 class="mt-3 text-sm font-black text-yellow-950 break-words">
                                                Your go-to destination for premium coffee experiences</h3>
                                            <h3 class="text-sm font-black text-yellow-950 break-words">Explore personalized subscriptions and elevate your daily brew</h3>
                                        </div>
                                        <div class="pt-3 mt-12 ml-10 sm:pt-5 lg:pt-0">
                                            <Link
                                                v-if="canRegister"
                                                :href="route('products.index')"
                                                class="inline-block font-light rounded-xl px-6 py-3 font-sans bg-yellow-950 text-white ring-1 ring-transparent transition hover:text-white hover:bg-yellow-900 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-yellow-950/80 dark:hover:bg-yellow-950/20 dark:focus-visible:ring-white"
                                            >
                                                Browse Product
                                            </Link>
                                            <Link
                                                v-if="canRegister"
                                                :href="route('register')"
                                                class="inline-block font-light rounded-xl ml-5 px-6 py-3 font-sans border-hidden bg-orange-950/10 text-black ring-1 ring-transparent transition hover:text-white/70 hover:bg-yellow-950 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-black dark:hover:text-white/80 dark:hover:bg-yellow-950 dark:focus-visible:ring-white"
                                            >
                                                Login / Signup
                                            </Link>
                                        </div>
                                    </div>
                                    <div class="border border-yellow-800/20 ring-4 ring-yellow-900/20 rounded-lg p-2 ml-80">
                                <img
                                    id="cart"
                                    class="h-60 w-auto rounded-lg text-white lg:5 "
                                    src="home/cup.jpg"
                                    alt="cart"
                                />
                                </div>
                            </div>
                        </div>

                        <a
                            class="flex items-start gap-4  bg-yellow-950 focus-visible:ring-[#FF2D20] lg:pb-3 dark:bg-yellow-950 dark:ring-zinc-white dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]"
                        >
                        </a>
                        <a class="flex flex-col items-center gap-4 rounded-lg">
                                <div class="pt-2">
                                    <h1 class="text-yellow-950/20 font-serif text-3xl ml-10 ">C o f f e e</h1>
                                    <div class="mt-10 font-bold text-gray-700 rounded-full bg-white/0 flex items-center border-2 border-yellow-950/10 justify-center font-mono" style="height: 200px; width: 200px; ">
                                        <img
                                            id="beans"
                                            class="h-40 w-auto text-white lg:5 "
                                            src="home/homede.png"
                                            alt="beans"
                                        />
                                       
                                    </div>
                                </div>
                             
                        </a>

                        <div
                            class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 lg:pb-10 dark:bg-white dark:ring-white"
                        >
                            <div
                                class="flex size-12 shrink-0 items-center justify-center rounded-full bg-[#FF2D20]/10 sm:size-16"
                            >
                                
                            </div>

                            <div class="pt-3 sm:pt-5">
                                
                            </div>
                        </div>
                    </div>
                </main>

                <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                    Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
                </footer>
            </div>
        </div>
    </div>
</template>


