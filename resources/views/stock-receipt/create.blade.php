<x-app-layout>

    <div id="multistepForm">

        <div class="text-left">
            @if(session('danger'))
                <x-alert type="danger" :message="session('danger')" />
            @endif
        </div>
        
        <!-- Step 1 -->
        <div id="step1" style="display: block;">
            <h1 class="text-2xl font-semibold m-4 text-center uppercase">Stock Receipt Form</h1>
            <form class="mt-10 max-w-7xl mx-auto" id="formStep1">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <label for="vendor_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Vendor Name</label>
                        <select id="vendor_name" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light">
                            <option value="" disabled selected>Select Vendor</option>
                            @foreach ($vendors as $vendor)
                                <option value="{{ $vendor->companyName }}">{{ $vendor->companyName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="location" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Location</label>
                        <select id="location" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light">
                            <option value="" disabled selected>Select Location</option>
                            <option value="Delhi">Delhi</option>
                            <option value="Mumbai">Mumbai</option>
                            <option value="Kolkata">Kolkata</option>
                        </select>
                    </div>
                    <div>
                        <label for="refrence_document_no" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Refrence Document No.</label>
                        <input type="text" id="refrence_document_no" placeholder="Type Refrence Document No." class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    </div>
                    <div>
                        <label for="refrence_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Refrence Date</label>
                        <input type="date" id="refrence_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    </div>
                    <div>
                        <label for="current_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Current Date</label>
                        <input type="date" id="current_date" value="{{ now()->format('Y-m-d') }}" disabled class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    </div>
                    <div>
                        <label for="user_prefix" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">User Prefix</label>
                        <input type="text" id="user_prefix" placeholder="Type user Prefix" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    </div>
                </div>
                <div class="flex justify-center pt-8">
                    <button type="button" onclick="captureFormValuesAndNext(2)" class="bg-teal-500 hover:bg-green-500 text-white px-4 py-2 rounded w-64">Next</button>
                </div>
            </form>
        </div>

        <!-- Step 2 -->
        <div id="step2" style="display: none;">
            <h1 class="text-2xl font-semibold m-4 text-center uppercase">Step 2: Stock Receipt Form</h1>
            <form action="{{ route('stock-receipt.store') }}" method="POST" class="mt-10 max-w-7xl mx-auto" id="formStep2">
                @csrf

                <input type="hidden" id="listItems" name="listItems" value="">
                <input type="hidden" id="locationVal" name="location" value="">
                <input type="hidden" id="refrenceDocumentNo" name="refrence_document_no" value="">
                <input type="hidden" id="refrenceDate" name="refrence_date" value="">
                <input type="hidden" id="userPrefix" name="user_prefix" value="">

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
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
                        <label for="vendorName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Vendor Name</label>
                        <input type="text" id="vendorName" name="vendor_name" value="" readonly placeholder="Vendor Name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    </div>
                    <div>
                        <label for="item_code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Item Code</label>
                        <input type="text" id="item_code_val" placeholder="Item Code" readonly class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    </div>
                    <div>
                        <label for="available_stock" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Available Stock</label>
                        <input type="text" id="available_stock_val" placeholder="Available Stock" readonly class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    </div>
                    <div>
                        <label for="quantity" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Quantity</label>
                        <input type="number" id="quantity_val" placeholder="Type Quantity" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    </div>
                    <div>
                        <label for="batche_no" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Batch No.</label>
                        <input type="text" id="batche_no_val" list="batchSuggestions" placeholder="Type or select a batch number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <datalist id="batchSuggestions"></datalist>
                    </div>
                    <div>
                        <label for="mfg_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">MFG Date</label>
                        <input type="date" id="mfg_date_val" placeholder="Type MFG Date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    </div>
                    <div>
                        <label for="mfg_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">MFG Name</label>
                        <input type="text" id="mfg_name_val" placeholder="Type MFG Name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    </div>
                    <div>
                        <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price</label>
                        <input type="text" id="price_val" readonly class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

                    </div>
                    <div>
                        <label for="tax" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tax</label>
                        <input type="text" id="tax_val" readonly class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />

                    </div>
                    <div class="lg:pt-7">
                        <button type="button" id="addToList" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                           + Add to list
                        </button>
                    </div>
                </div>

                <div class="relative overflow-x-auto my-4" id="listContainer">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="p-3">Action</th>
                                <th scope="col" class="p-3">Item Name</th>
                                <th scope="col" class="p-3">Vendor Name</th>
                                <th scope="col" class="p-3">Item Code</th>
                                <th scope="col" class="p-3">Available Stock</th>
                                <th scope="col" class="p-3">Quantity</th>
                                <th scope="col" class="p-3">Batch No.</th>
                                <th scope="col" class="p-3">MFG Date</th>
                                <th scope="col" class="p-3">MFG Name</th>
                                <th scope="col" class="p-3">Price</th>
                                <th scope="col" class="p-3">Tax</th>
                                <th scope="col" class="p-3">tax Amount</th>
                                <th scope="col" class="p-3">Gross Amount</th>
                                <th scope="col" class="p-3">Final Amount</th>
                            </tr>
                        </thead>
                        <tbody id="listBody">
                            {{-- <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"><td class="p-3"></tr> --}}
                            
                        </tbody>
                    </table>
                </div>

                <!-- Your form fields for Step 3 go here -->
                <div class="flex justify-between my-10">
                    <button type="button" onclick="previousStep(1)" class="bg-gray-500 text-white px-4 py-2 rounded">Previous</button>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('assets/js/stock-receipt-form.js') }}"></script>

</x-app-layout>