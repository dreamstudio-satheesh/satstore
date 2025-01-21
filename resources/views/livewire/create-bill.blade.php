<div>
    {{-- Top heading --}}
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Add Sale</h4>
                <h6>Add your new sale</h6>
            </div>
        </div>

        @if (session()->has('success'))
            <div class="alert alert-success mb-2">
                {{ session('success') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger mb-2">
                {{ session('error') }}
            </div>
        @endif

        {{-- Invoice / Sales Form --}}
        <div class="card">
            <div class="card-body">
                <div class="row">

                    {{-- Product Search --}}
                    <div class="col-lg-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Product Name / Barcode</label>
                            <div class="input-groupicon">
                                <input type="text" wire:model="searchTerm" placeholder="Type name or barcode..."
                                    class="form-control"  autofocus />
                                <div class="addonset">
                                    <img src="{{ url('assets/img/icons/scanners.svg') }}" alt="Scan" />
                                </div>
                            </div>
                            {{-- Display search results in a small list/dropdown --}}
                            @if (!empty($searchTerm) && $products->count() > 0)
                                <div class="bg-white border mt-1" style="position: absolute; z-index: 10;">
                                    @foreach ($products as $prod)
                                        <div class="p-2 border-bottom" style="cursor: pointer;"
                                            wire:click="addProduct({{ $prod->id }})">
                                            {{ $prod->barcode }} - {{ $prod->name_english ?? $prod->name_tamil }}
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                   

                    {{-- Bill Date --}}
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Bill Date</label>
                            <input type="date" wire:model="bill_date" class="form-control" />
                        </div>
                    </div>

                     {{-- Customer --}}
                     <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Customer</label>
                            <!-- The select that will be powered by Select2 -->
                            <select id="customer-select" name="customer_id" class="select2">
                                <!-- If you want to pre-load a selected option, do so here -->
                            </select>

                        </div>
                    </div>

                    
                </div>

                {{-- Cart Table --}}
                <div class="row mt-3">
                    <div class="col-lg-12">
                        <div class="table-responsive mb-3">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th>QTY</th>
                                        <th>Price</th>
                                        <th>Subtotal</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($cart as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item['product_name'] }}</td>
                                            <td>
                                                <input type="number" min="1"
                                                    wire:model="cart.{{ $index }}.quantity"
                                                    style="width: 70px;" />
                                            </td>
                                            <td>{{ number_format($item['price'], 2) }}</td>
                                            <td>
                                                {{ number_format($item['price'] * $item['quantity'], 2) }}
                                            </td>
                                            <td>
                                                <a href="javascript:void(0);"
                                                    wire:click="removeProduct({{ $index }})" class="delete-set">
                                                    <img src="{{ url('assets/img/icons/delete.svg') }}"
                                                        alt="Delete" />
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6">No products added yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Summary & Actions --}}
                <div class="row g-3 align-items-center mb-4">
                    <div class="col-auto">
                        <label>Discount:</label>
                        <input type="number" class="form-control" wire:model="discount" placeholder="Flat Discount" />
                    </div>
                    <div class="col-auto">
                        <label>Total Amount: </label>
                        <div>
                            <span class="fw-bold">{{ number_format($total_amount, 2) }}</span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <label>Final Amount: </label>
                        <div>
                            <span class="fw-bold">{{ number_format($final_amount, 2) }}</span>
                        </div>
                    </div>
                </div>

                {{-- Submit / Cancel --}}
                <div class="col-lg-12">
                    <button type="button" class="btn btn-submit me-2" wire:click="storeBill">
                        Submit
                    </button>
                    <a href="javascript:void(0);" class="btn btn-cancel">Cancel</a>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                // Initialize Select2
                $('#customer-select').select2({
                    placeholder: 'Search or create customer...',
                    width: '100%',
                    tags: true, // allows creation of new tags
                    ajax: {
                        url: '{{ route('customers.search') }}',
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                term: params.term, // search term
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: data
                            };
                        },
                        cache: true
                    },
                    // The createTag callback is triggered whenever user typed text is not in results
                    createTag: function(params) {
                        const term = $.trim(params.term);
                        if (term === '') {
                            return null;
                        }
                        return {
                            id: term, // temporarily store the user-typed term
                            text: term,
                            newTag: true // flag to indicate it's a new tag
                        };
                    }
                });

                // Listen for selection
                $('#customer-select').on('select2:select', function(e) {
                    const data = e.params.data;

                    // If it's a new tag (i.e., not found in the DB)
                    if (data.newTag) {
                        // We'll attempt to create it in the DB via AJAX
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('customers.store') }}',
                            data: {
                                name: data.text, // The typed text for 'name'
                                mobile: '', // Optional: if you want a second popup for mobile or pass a default
                                address: '', // Optional
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                // On success, we have the newly created customer's record:
                                // {id: 123, text: "John (9999999999)"}

                                // Replace the temporary tag with the newly created ID & text
                                const newOption = new Option(response.text, response.id, false,
                                    true);
                                $('#customer-select').append(newOption).trigger('change');
                            },
                            error: function(err) {
                                alert('Failed to create new customer: ' + err.responseJSON.message);
                                // Optionally, remove the invalid tag
                                $('#customer-select').val(null).trigger('change');
                            }
                        });
                    }
                });

            });
        </script>
    @endpush
</div>
