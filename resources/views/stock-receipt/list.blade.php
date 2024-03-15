<div class="overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-4 py-3">Sno</th>
                <th scope="col" class="px-4 py-3">Item Name</th>
                <th scope="col" class="px-4 py-3">Item Code</th>
                <th scope="col" class="px-4 py-3">Vendor Name</th>
                <th scope="col" class="px-4 py-3">Batch Number</th>
                <th scope="col" class="px-4 py-3">Quantity</th>
                <th scope="col" class="px-4 py-3">Manufacturing Name</th>
                <th scope="col" class="px-4 py-3">Manufacturing Date</th>
                <th scope="col" class="px-4 py-3">Tax</th>
                <th scope="col" class="px-4 py-3">Tax Amount</th>
                <th scope="col" class="px-4 py-3">Gross Amount</th>
                <th scope="col" class="px-4 py-3">Final Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stockReceipts as $stock)
                <tr class="border-b dark:border-gray-700">
                    <td class="px-4 py-3">{{ ($stockReceipts->currentPage() - 1) * $stockReceipts->perPage() + $loop->iteration }}</td>
                    <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $stock->item_name }}</th>
                    <td class="px-4 py-3">{{ $stock->item_code }}</td>
                    <td class="px-4 py-3">{{ $stock->vendor_name }}</td>
                    <td class="px-4 py-3">{{ $stock->batch_number }}</td>
                    <td class="px-4 py-3">{{ $stock->quantity }}</td>
                    <td class="px-4 py-3">{{ $stock->mfg_name }}</td>
                    <td class="px-4 py-3">{{ $stock->mfg_date }}</td>
                    <td class="px-4 py-3">{{ $stock->tax .'%' }}</td>
                    <td class="px-4 py-3">{{ '₹' . $stock->tax_amount }}</td>
                    <td class="px-4 py-3">{{ '₹' . $stock->gross_amount }}</td>
                    <td class="px-4 py-3">{{ '₹' . $stock->final_amount }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="justify-between items-start md:items-center space-y-3 md:space-y-0 p-4">
    {{ $stockReceipts->links() }}
</div>