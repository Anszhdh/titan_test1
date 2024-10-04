<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
// import NavLink from '@/Components/NavLink.vue';
// import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import NotificationIcon from '@/Components/NotificationIcon.vue';

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
    products: { // Define the products prop
        type: Array,
        required: true,
    },
       isLoggedIn: { // Make sure to define the isLoggedIn prop
        type: Boolean,
    }
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="Regal Valet" />
    <div class="bg-black text-black/50 dark:text-white/50">
        <img
            id="background"
            class="absolute -left-20 top-0 max-w-[877px]"
            
        />
        <div
            class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white"
        >
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <header class="grid grid-cols-4 items-center gap-2 py-10 lg:grid-cols-6">
                  <div class="lg:flex lg:items-center lg:col-span-3">
                    <img
                        id="logo"
                        class="h-12 w-auto text-white lg:h-16 lg:text-[#FF2D20] cursor-pointer"
                        src="icon.png"
                        alt="Logo"
                        @click="navigateToHome"
                    />
                        
                    </div>
                 
                    <div class="flex lg:col-3 items-center">
                       
                        <Link
                                  :href="isLoggedIn ? route('products.index') : route('login')"
                                class="rounded-md px-3 py-2 mr-2 text-white ring-1 ring-transparent transition hover:text-gray-600 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-yellow-950 dark:hover:text-yellow-700/80 dark:focus-visible:ring-white"
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
                                :href="route('discover')"
                                class="rounded-md px-3 py-2 mr-2 text-white ring-1 ring-transparent transition hover:text-gray-600 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-yellow-950 dark:hover:text-yellow-700/80 dark:focus-visible:ring-white"
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
                            :href="isLoggedIn ? route('contact') : route('login')"
                            class="rounded-md px-3 py-2 mr-2 text-white ring-1 ring-transparent transition hover:text-gray-600 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-yellow-950 dark:hover:text-yellow-700/80 dark:focus-visible:ring-white"
                        >
                            {{ isLoggedIn ? 'Contact' : 'Contact' }}
                        </Link>
                        <!-- <img
                            id="search"
                            class="h-6 ml-16 w-auto text-white lg:5"
                            src="home/search.png"
                            alt="search"
                        /> -->
                        <div class="space-x-4 mt-2 ml-28" title="Notifications">
                             <NotificationIcon iconColor="text-orange-600" v-if="$page.props.isLoggedIn"/>
                        </div>
                        <a :href="isLoggedIn ? '/cart' : route('login')">
                            <img
                            id="cart"
                            class="h-6 ml-16 w-auto text-white lg:5 c"
                            src="/home/cart.png"
                            alt="cart"
                            />
                        </a>
                        <div class="hidden sm:flex sm:items-center sm:ms-6" v-if="$page.props.isLoggedIn">
                        <!-- Settings Dropdown -->
                        <div class="ms-3 relative">
                        <Dropdown align="right" width="48">
                            <template #trigger>
                            <span class="inline-flex rounded-md">
                                <button
                                type="button"
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-orange-600/80 hover:text-yellow-950/50 focus:outline-none transition ease-in-out duration-150"
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
                            <DropdownLink :href="route('profile.edit')">Profile</DropdownLink>
                            <DropdownLink :href="route('user.orders')">Orders</DropdownLink>
                            <DropdownLink :href="route('logout')" method="post" as="button">
                                Log Out
                            </DropdownLink>
                            </template>
                        </Dropdown>
                        </div>
                    </div>
                                            <Link
                        v-if="!$page.props.isLoggedIn"
                        :href="route('login')"
                        class="ml-12 text-white ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-yellow-950 dark:hover:text-yellow-700/80 dark:focus-visible:ring-white"
                    >
                        Login
                    </Link>

                    <Link
                        v-if="!$page.props.isLoggedIn && canRegister"
                        :href="route('register')"
                        class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-yellow-950 dark:hover:text-yellow-700/80 dark:focus-visible:ring-white"
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
                                                <span class=" font-sans bg-gradient-to-r from-orange-700 to-orange-800 text-transparent bg-clip-text">Regal Valet</span>
                                            </span>
                                            <!-- <h2 class="mt-1 text-xl font-black font-sans text-yellow-950">Brewing dreams one cup at a time</h2>
                                            <h3 class="mt-3 text-sm font-black text-yellow-950 break-words">
                                                Your go-to destination for premium coffee experiences</h3>
                                            <h3 class="text-sm font-black text-yellow-950 break-words">Explore personalized subscriptions and elevate your daily brew</h3> -->
                                        </div>
                                        <div class="pt-3 mt-12 ml-10 sm:pt-5 lg:pt-0">
                                            <Link
                                                v-if="canRegister"
                                                :href="route('products.index')"
                                                class="inline-block font-light rounded-xl px-6 py-3 font-sans bg-orange-600 text-white ring-1 ring-transparent transition hover:text-white hover:bg-orange-600/50 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-yellow-950/80 dark:hover:bg-yellow-950/20 dark:focus-visible:ring-white"
                                            >
                                                Browse Product
                                            </Link>
                                            <Link
                                                v-if="!$page.props.isLoggedIn"
                                                :href="route('register')" 
                                                class="inline-block font-light rounded-xl ml-5 px-6 py-3 font-sans border-hidden bg-white text-black ring-1 ring-transparent transition hover:text-white/70 hover:bg-yellow-950 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-black dark:hover:text-white/80 dark:hover:bg-yellow-950 dark:focus-visible:ring-white"
                                            >
                                                Login / Signup
                                            </Link>
                                        </div>
                                    </div>
                                    <div class="border rounded-lg p-2 ml-80">
                                        
                                    <img
                                        id="cart"
                                        class="h-80 w-140 rounded-lg text-white lg:5 "
                                        src="home/cup.png"
                                        alt="cart"
                                    />
                                </div>
                            </div>
                        </div>

                        <a
                            class="flex items-start gap-4  bg-black focus-visible:ring-[#FF2D20] lg:pb-3 dark:bg-yellow-950 dark:ring-zinc-white dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]"
                        >
                        </a>
                        <!-- <div class="relative flex flex-col items-center gap-4 rounded-lg"> -->
                    <!-- <div class="pt-2">
                        <h1 class="text-yellow-950/20 font-serif text-3xl ml-10 ">C o f f e e</h1>
                        <div class="mt-10 font-bold text-gray-700 rounded-full bg-white/0 flex items-center border-2 border-yellow-950/10 justify-center font-mono" style="height: 200px; width: 200px; ">
                            <img id="beans" class="h-40 w-auto text-white lg:5" src="home/homede.png" alt="beans" />
                        </div>
                    </div> -->

                    <!-- Absolute positioned features -->
                    <!-- <div class="absolute top-0 left-0 transform -translate-x-1/2 mt-10 ml-60 flex flex-col items-center gap-2">
                        <div class="bg-white/0 flex items-center justify-center border-2 border-yellow-950/10 rounded-full" style="height: 100px; width: 100px;">
                            <img class="h-14 w-auto" src="/home/convenient.png" alt="Convenient" />
                        </div>
                        <span class="font-mono font-bold text-gray-700">Convenient</span>
                    </div>
                    <div class="absolute bottom-0 right-0 transform -translate-y-1/2 mb-10 mr-40 flex flex-col items-center gap-2">
                        <div class="bg-white/0 flex items-center justify-center border-2 border-yellow-950/10 rounded-full" style="height: 100px; width: 100px;">
                            <img class="h-16 w-auto" src="/home/premium.png" alt="Premium Taste" />
                        </div>
                        <span class="font-mono font-bold text-gray-700">Premium Taste</span>
                    </div>
                    <div class="absolute top-0 left-0  transform -translate-x-1/2 mt-60 ml-60  items-center gap-2">
                        <div class="bg-white/0 flex items-center justify-center border-2 border-yellow-950/10 rounded-full" style="height: 100px; width: 100px;">
                            <img class="h-16 w-auto" src="/home/quality.png" alt="High Quality" />
                        </div>
                        <span class="font-mono font-bold text-gray-700">High Quality</span>
                    </div>
                    <div class="absolute top-0 right-0 transform -translate-y-1/2 mr-40 mt-80 flex flex-col items-center gap-2">
                        <div class="bg-white/0 flex items-center justify-center border-2 border-yellow-950/10 rounded-full" style="height: 100px; width: 100px;">
                            <img class="h-16 w-auto" src="/home/right.png" alt="Better For You" />
                        </div>
                        <span class="font-mono font-bold text-gray-700">Better For You</span>
                    </div>-->
                <!-- </div>  -->
                <div class="container mx-auto ">
                    <h2 class="text-2xl font-bold text-black mt-20  text-center ">Discover Our Products</h2>
                    <div class="flex justify-center">
                    <!-- <router-link :to="{ name: 'products.index' }">
                        <button class="bg-yellow-950 hover:bg-yellow-950/70 text-white font-bold py-3 px-4 rounded-xl">
                            Browse Products
                        </button>
                    </router-link> -->
                </div>
                    <!-- <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                    <div v-for="product in products" :key="product.id" class="bg-white shadow-lg rounded-lg p-4">
                        <img :src="product.image" alt="Product Image" class="w-full h-32 object-cover mb-4">
                        <h3 class="text-lg font-semibold mb-2">{{ product.name }}</h3>
                        <p class="text-gray-600 mb-4">RM {{ product.price }}</p>
                        <button class="bg-brown-500 text-white py-2 px-4 rounded">Add to cart</button>
                    </div>
                    </div> -->
                    <div class="mt-8 text-center">
                    <p class="mb-4">Experience greater ride handling with Malaysia’s own home-grown high performance shock absorbers.</p>
                    <!-- <div class="flex justify-center items-center">
                        <input type="email" placeholder="Enter your email" class="border py-2 px-4 rounded-l">
                        <button class="bg-brown-500 text-white py-2 px-4 rounded-r">Sign Up</button>
                    </div> -->
                    </div>
                </div>       
                    </div>
                </main>
                <footer class="bg-black py-8 border-t border-gray-200">
            <div class="container mx-auto px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row justify-between items-center">
                <!-- Left Section -->
                <div class="flex flex-col lg:flex-row lg:space-x-12">
                    <div>
                    <h4 class="text-white font-bold mb-4">SHOP</h4>
                    <ul class="text-gray-600">
                        <!-- <li><a href="#" class="hover:text-gray-900">Coffee Beans</a></li>
                        <li><a href="#" class="hover:text-gray-900">Accessories</a></li>
                        <li><a href="#" class="hover:text-gray-900">Instant Coffee</a></li>
                        <li><a href="#" class="hover:text-gray-900">Subscription</a></li> -->
                    </ul>
                    </div>
                    <div class="mt-8 lg:mt-0">
                    <h4 class="text-white font-bold mb-4">PRIVACY</h4>
                    <ul class="text-gray-600">
                        <li><a href="#" class="hover:text-gray-900">Terms of Use</a></li>
                        <li><a href="#" class="hover:text-gray-900">Privacy Policy</a></li>
                    </ul>
                    </div>
                    <div class="mt-8 lg:mt-0">
                    <h4 class="text-white font-bold mb-4">ABOUT US</h4>
                    <ul class="text-gray-600">
                        <li><a href="#" class="hover:text-gray-900">About us</a></li>
                        <li><a href="#" class="hover:text-gray-900">Contacts</a></li>
                        <li><a href="#" class="hover:text-gray-900">FAQ</a></li>
                    </ul>
                    </div>
                </div>
                <!-- Center Section -->
                <div class="my-8 lg:my-0">
                    <h4 class="text-white font-bold">Regal Valet</h4>
                </div>
                <!-- Right Section -->
                <div>
                    <div class="flex items-center justify-center lg:justify-end lg:items-start">
                    <div class="text-gray-600">
                        <p class="mb-2">60123456789</p>
                        <p class="mb-2">regalvalett@123.com</p>
                        <div class="flex space-x-4 mt-4">
                        <a href="#" class="text-gray-600 hover:text-gray-900"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-gray-600 hover:text-gray-900"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-600 hover:text-gray-900"><i class="fab fa-facebook-f"></i></a>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </footer>
            </div>
        </div>
    </div>
</template>


