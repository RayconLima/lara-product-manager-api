<template>
    <div class="bg-gray-100 text-gray-900">
        <div class="w-full h-screen bg-white dark:bg-gray-900 shadow  flex justify-center flex-1">
            <div class="flex-1 bg-indigo-100 text-center hidden lg:flex">
                <div class="m-12 xl:m-16 w-full bg-contain bg-center bg-no-repeat backgroundImage">
                </div>
            </div>
            <div class="lg:w-1/2 xl:w-5/12 p-6 sm:p-12">
                <RouterView />
            </div>
        </div>
    </div>
    </template>
    <style scoped>
        .backgroundImage {
            background-image: url('@/ui/assets/images/site/barber.svg')
        }
    </style>