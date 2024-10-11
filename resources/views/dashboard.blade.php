<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>

            <!-- اضافه کردن منوهای جدید در کنار Dashboard -->
            <nav class="flex space-x-4">
                <a href="#" class="text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium">
                    درصد شرکا
                </a>
                <a href="#" class="text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium">
                    گزارشات
                </a>
            </nav>
        </div>
    </x-slot>

    <!-- محتوای اصلی صفحه -->
    <div class="min-h-screen bg-white">
        <!-- محتوای دلخواه شما -->
    </div>

</x-app-layout>
