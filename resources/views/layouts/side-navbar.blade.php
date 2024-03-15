<?php $cur_route = Route::current()->getName(); ?>
<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-5 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800 mt-14">
        <ul class="space-y-2 font-medium">
            <li>
                <a href="{{route('stock-receipt.index')}}" type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                    <span class="material-symbols-outlined">receipt_long</span>
                    <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Stock Receipt</span>
                </a>
            </li>
            <li>
                <a href="{{route('stock-out.index')}}" type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                    <span class="material-symbols-outlined">receipt_long</span>
                    <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Stock Out</span>
                </a>
            </li>
            @if(auth()->user()->role === "superadmin")
            <li>
                <a href="{{route('user.index')}}" type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                    <span class="material-symbols-outlined">manage_accounts</span>
                    <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">User</span>
                </a>
            </li>
            @endif
        </ul>
    </div>
</aside>

<div class="p-4 sm:ml-64">
    <div class="border-gray-200 rounded-lg dark:border-gray-700">
        <main class="mt-20">
            {{ $slot }}
        </main>
    </div>
</div>
