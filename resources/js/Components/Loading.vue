<template>
    <div class="fixed inset-0 flex items-center justify-center bg-white z-50">
        <div class="text-center">
            <p class="text-xl font-bold mb-4">Generating your recommendations...</p>
            <div class="spinner-border animate-spin inline-block w-8 h-8 border-4 rounded-full" role="status">
                <span class="visually-hidden"></span>
            </div>
        </div>
    </div>
</template>

<style scoped>
.spinner-border {
    border-top-color: #5a2d0d; /* Customize the color of the spinner */
    border-right-color: transparent;
    border-bottom-color: transparent;
    border-left-color: #5a2d0d;
}
</style>
