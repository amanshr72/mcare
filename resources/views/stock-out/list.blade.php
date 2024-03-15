<div class="overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-4 py-3">Sno</th>
                <th scope="col" class="px-4 py-3">Item Name</th>
                <th scope="col" class="px-4 py-3">Item Code</th>
                <th scope="col" class="px-4 py-3">Vendor Name</th>
                <th scope="col" class="px-4 py-3">Batch Number</th>
                <th scope="col" class="px-4 py-3">Stock Out Quantity</th>
                <th scope="col" class="px-4 py-3">Stock Quantity</th>
                <th scope="col" class="px-4 py-3">Manufacturing Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stockOuts as $stock)
                <tr class="border-b dark:border-gray-700">
                    <td class="px-4 py-3">{{ ($stockOuts->currentPage() - 1) * $stockOuts->perPage() + $loop->iteration }}</td>
                    <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $stock->item_name }}</th>
                    <td class="px-4 py-3">{{ $stock->item_code }}</td>
                    <td class="px-4 py-3">{{ $stock->stockReceiptListItem->vendor_name }}</td>
                    <td class="px-4 py-3">{{ $stock->batch_number }}</td>
                    <td class="px-4 py-3">{{ $stock->quantity }}</td>
                    <td class="px-4 py-3">{{ $stock->quantity_2 }}</td>
                    <td class="px-4 py-3">{{ $stock->manufacturing_date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="justify-between items-start md:items-center space-y-3 md:space-y-0 p-4">
    {{ $stockOuts->links() }}
</div>