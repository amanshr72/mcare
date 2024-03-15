<x-app-layout>
    
    <section class="bg-white dark:bg-gray-900">
        <div class="max-w-2xl px-4 py-8 mx-auto">
            <div class="text-left">
                @if(session('success'))
                    <x-alert type="success" :message="session('success')" />
                @elseif(session('danger'))
                    <x-alert type="danger" :message="session('danger')" />
                @endif
            </div>
            
            <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Update Stock: <span class="text-green-600">{{ $stock->item_name }}</span></h2>
            <form action="{{ route('push.update') }}" method="POST">
                @csrf
                @method('PUT')
                
                <input type="hidden" name="fk_id" value="{{ $stock->stock_receipts_id }}">
                <input type="hidden" name="id" value="{{ $stock->id }}">
                <div class="grid gap-4 mb-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">
                    <div class="sm:col-span-2">
                        <label for="item_code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Item Code</label>
                        <input type="text" name="item_code" id="item_code" value="{{ $stock->item_code }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" >
                    </div>
                    <div class="w-full">
                        <label for="lot_no" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">LotNo</label>
                        <input type="text" name="lot_no" id="lot_no" value="{{ $stock->lot_no }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" >
                    </div>
                    <div class="w-full">
                        <label for="quantity" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Quantity</label>
                        <input type="number" name="quantity" id="quantity" value="{{ $stock->quantity }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" >
                    </div>
                    <div class="w-full">
                        <label for="rate" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Rate</label>
                        <input type="text" name="rate" id="rate" value="{{ $stock->rate }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" >
                    </div>
                    <div class="w-full">
                        <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mrp (Price)</label>
                        <input type="number" name="price" id="price" value="{{ $stock->price }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" >
                    </div>
                    <div>
                        <label for="mfg_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Manufacturing Date</label>
                        <input type="date" name="mfg_date" id="mfg_date" value="{{ $stock->mfg_date }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" >
                    </div> 
                    <div>
                        <label for="expiry_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Expiry Date</label>
                        <input type="date" name="expiry_date" id="expiry_date" value="{{ $stock->expiry_date }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" >
                    </div> 
                </div>
                <div class="flex items-center space-x-4">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Update
                    </button>
                    <button type="button" onclick="confirmDiscard()" class="text-red-600 inline-flex items-center hover:text-white border border-red-600 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                        Discard
                    </button>
                </div>
            </form>
        </div>
    </section>


    <script>
        function confirmDiscard() {
            if (confirm('Are you sure you want to discard changes?')) {
                window.location.href = "{{ route('view.pushList') }}";
            }
        }
    </script>

</x-app-layout>