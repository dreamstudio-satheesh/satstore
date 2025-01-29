<div>
    <div class="flex justify-between mb-4">
        <input type="text" wire:model.live.debounce.500ms="search" class="border p-2 rounded" placeholder="Search by ID or Customer Name">
        <select wire:model="perPage" class="border p-2 rounded">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
        </select>
    </div>

    <table class="table table-responsive table-border">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">#</th>
                <th class="border p-2">Customer</th>
                <th class="border p-2">Total</th>
                <th class="border p-2">Final Amount</th>
                <th class="border p-2">Date</th>
                <th class="border p-2">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bills as $bill)
                <tr class="border">
                    <td class="border p-2">{{ $bill->id }}</td>
                    <td class="border p-2">{{ $bill->customer?->name ?? 'N/A' }}</td>
                    <td class="border p-2">{{ number_format($bill->total_amount, 2) }}</td>
                  {{--   <td class="border p-2">{{ number_format($bill->discount, 2) }}</td> --}}
                    <td class="border p-2 font-bold">{{ number_format($bill->final_amount, 2) }}</td>
                    <td class="border p-2">{{ $bill->created_at->format('d-m-Y') }}</td>
                    <td><a class="btn btn-sm btn-primary" href="{{ route('invoice.show', ['id' => $bill->id]) }}">Print</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $bills->links() }}
    </div>
</div>
