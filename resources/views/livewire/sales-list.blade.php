<div>
    <div class="flex justify-between mb-4">
        <input type="text" wire:model.live.debounce.500ms="search" class="border p-2 rounded"
            placeholder="Search by ID or Customer Name">
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
            @foreach ($bills as $bill)
                <tr class="border">
                    <td class="border p-2">{{ $bill->id }}</td>
                    <td class="border p-2">{{ $bill->customer?->name ?? 'N/A' }}</td>
                    <td class="border p-2">{{ number_format($bill->total_amount, 2) }}</td>
                    {{--   <td class="border p-2">{{ number_format($bill->discount, 2) }}</td> --}}
                    <td class="border p-2 font-bold">{{ number_format($bill->final_amount, 2) }}</td>
                    <td class="border p-2">{{ $bill->created_at->format('d-m-Y') }}</td>
                    <td>
                        <a href="{{ route('invoice.show', ['billId' => $bill->id]) }}"
                            onclick="openInvoice(event, '{{ route('invoice.show', ['billId' => $bill->id]) }}')">
                            <span class="badges bg-lightred">Print</span>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="card">
        <div class="row">
            <div class="mt-4 col-10">
                    {{ $bills->links() }}
            </div>
        </div>
    </div>


    @push('scripts')
        <script>
            function openInvoice(event, url) {
                event.preventDefault(); // Prevent default link behavior
                window.open(url, '_blank',
                    'toolbar=no, location=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=800, height=600');
            }
        </script>
    @endpush
</div>
