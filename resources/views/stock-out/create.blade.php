<x-app-layout>
    
    <div>
        <h1 class="text-2xl font-semibold m-4 text-center uppercase">Product Consumption Form</h1>
        <form action="{{ route('stock-out.store') }}" method="POST" class="mt-10 max-w-7xl mx-auto">
            @csrf

            <input type="hidden" id="listItems" name="listItems" value="">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 ">
                <div>
                    <label for="item_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Item Name</label>
                    <select id="item_name_val" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="" disabled selected>Select Item Name</option>
                        @foreach ($items as $item)
                            <option value="{{ $item->item_name }}">{{ $item->item_code.' - '.$item->item_name.' - '.$item->category }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="batche_no" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Batch No.</label>
                    <select id="batche_no_val" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="" disabled selected>select Batch No</option>
                    </select>
                </div>
                <div>
                    <label for="mfg_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">MFG Date</label>
                    <select id="mfg_date_val" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="" disabled selected>select MFG Date</option>
                    </select>
                </div>
                <div>
                    <label for="quantity" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Stock Out Quantity</label>
                    <input type="number" id="quantity_val" placeholder="Type Stock Out Quantity" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
                <div>
                    <label for="quantity" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Stock Quantity</label>
                    <input type="number" id="quantity_2_val" placeholder="Total Stock Quantity" readonly class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
                <div class="lg:pt-7">
                    <button type="button" id="addToList" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        + Add to list
                     </button>
                </div>
            </div>

            <div class="relative overflow-x-auto py-6" id="listContainer">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="p-3">Action</th>
                            <th scope="col" class="p-3">Iten Name</th>
                            <th scope="col" class="p-3">Batch Number</th>
                            <th scope="col" class="p-3">MFG Date</th>
                            <th scope="col" class="p-3">Quantity</th>
                            <th scope="col" class="p-3">Qty</th>
                        </tr>
                    </thead>
                    <tbody id="listBody">

                    </tbody>
                </table>
            </div>

            <div class="flex justify-center py-4">
                <button type="submit" class="bg-teal-500 hover:bg-green-500 text-white px-4 py-2 rounded w-64">Submit</button>
            </div>
        </form>
    </div>
    
    <script src="{{ asset('assets/js/stock-out-form.js') }}"></script>

</x-app-layout>