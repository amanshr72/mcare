<x-app-layout>
    <?php $count = App\Models\StockReceiptListItem::where('Status', 0)->orWhere('Status', Null)->count(); ?>
    
    <div class="mx-auto max-w-screen-xl">
        
        <div class="text-left">
            @if(session('success'))
                <x-alert type="success" :message="session('success')" />            
            @elseif(session('danger'))
                <x-alert type="danger" :message="$message" />
            @elseif(session('pushAllStockError'))
                <ul class="alert alert-danger py-2 px-2 bg-red-50 dark:bg-gray-800 text-red-800 dark:text-red-400 list-decimal">
                    @foreach (session('pushAllStockError') as $msg)
                        <li>{!! $msg !!}</li>    
                    @endforeach
                </ul>    
            @endif
        </div>

        <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
            <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-2">
                <div class="w-full md:w-1/2">
                    <form class="flex items-center">
                        <label for="simple-search" class="sr-only">Search</label>
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" 
                                id="search" 
                                placeholder="Search By Item Name and Item Code" 
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" 
                            />
                        </div>
                    </form>
                </div>
                <select id="batchNumber" class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                    <option disabled selected>Select Batch Number</option>
                    @foreach ($stockReceipts as $val)
                        @if($val->batch_number !== null && $val->batch_number !== '')
                            <option value="{{ $val->batch_number }}">{{ $val->batch_number }}</option>
                        @endif
                    @endforeach
                </select>
                <select id="vendorName" class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                    <option disabled selected>Select vendor Name</option>
                    @foreach ($stockReceipts as $val)
                        @if($val->vendor_name !== null && $val->vendor_name !== '')
                            <option value="{{ $val->vendor_name }}">{{ $val->vendor_name }}</option>
                        @endif
                    @endforeach
                </select>
                <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                    <a href="{{ route('stock-receipt.create') }}" type="button" class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 focus:outline-none">
                        <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                        </svg>
                        Add Stock
                    </a>
                    <button id="resstFilterBtn" data-tooltip-target="reset-filter" class="focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                        <span class="material-symbols-outlined">filter_alt_off</span>
                        <div id="reset-filter" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                            Reset Filter
                        </div>
                    </button>
                    <div class="inline-flex rounded-md shadow-sm" role="group">
                        <a href="{{ route('push.allStock') }}" type="button" @if($count == 0) onclick="return false;" style="pointer-events: none" @endif class="px-4 py-2 text-sm font-medium text-white bg-gray-600 border border-gray-200 rounded-s-lg hover:bg-gray-800">
                            Push All Stock
                        </a>
                        <a href="{{ route('view.pushList') }}" type="button" @if($count == 0) onclick="return false;" style="pointer-events: none" @endif class="px-4 py-2 text-sm font-medium text-white bg-gray-600 border border-gray-200 rounded-e-lg hover:bg-gray-800">
                            Stock List
                        </a>
                    </div>
                </div>
            </div>
            
            <section id="stock-receipt-list">
                @include('stock-receipt.list')
            </section>

        </div>
    </div>

    <script>
        $(document).ready(function () {
            /* Filter */
            $('#batchNumber, #vendorName').change(function () {
                var batchNumber = $('#batchNumber').val();
                var vendorName = $('#vendorName').val();

                $('#resstFilterBtn').click(function () {
                    window.location.href = '{{ route("stock-receipt.index") }}';
                });

                $.ajax({
                    url: "{{ route('stockReceiptFilter') }}",
                    type: 'GET',
                    data: { batchNumber: batchNumber, vendorName: vendorName },
                    success: function (resp) {
                        $('#stock-receipt-list').empty();
                        $('#stock-receipt-list').html(resp);
                    },
                    error: function (resp) {
                        console.log('Error:', resp);
                    }
                });
            });
            /* Search */
            $('#search').on('keyup', function () {
                var search = $('#search').val();
                
                if(search == ''){
                    window.location.href = '{{ route("stock-receipt.index") }}';
                }

                $.ajax({
                    url: "{{ route('stockReceiptSearch') }}",
                    type: 'GET',
                    data: { search: search },
                    success: function (resp) {
                        $('#stock-receipt-list').empty();
                        $('#stock-receipt-list').html(resp);
                    },
                    error: function (resp) {
                        console.log('Error:', resp);
                    }
                });
            });
        });
    </script>

</x-app-layout>