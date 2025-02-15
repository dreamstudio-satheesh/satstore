@extends('layouts.admin')


@section('content')
    <div class="content">

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="customer-select">Customer</label>
                            <div class="row">
                                <div class="col-lg-10 col-sm-10 col-10">
                                    <select id="customer-select" class="form-control" style="width:100%;">
                                    </select>
                                </div>
                                <div class="col-lg-2 col-sm-2 col-2 ps-0">
                                    <div class="add-icon">
                                        <a href="javascript:void(0);" data-bs-toggle="modal"
                                            data-bs-target="#addCustomerModal">
                                            <img src="assets/img/icons/plus1.svg" alt="img">
                                        </a>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Invoice Date </label>
                            <div class="input-groupicon">
                                <input id="invoice-date" type="text" placeholder="DD-MM-YYYY" class="datetimepicker">
                                <div class="addonset">
                                    <img src="assets/img/icons/calendars.svg" alt="img">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Reference No.</label>
                            <input type="text">
                        </div>
                    </div>
                    <div class="col-lg-12 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Product Name</label>
                            <div class="input-groupicon">
                                <input type="text" placeholder="Scan/Search Product by code and select...">
                                <div class="addonset">
                                    <img src="assets/img/icons/scanners.svg" alt="img">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-10 offset-lg-2">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>QTY</th>
                                        <th>Unit Cost($)</th>
                                        <th>Total Cost ($) </th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Apple Earpods</td>
                                        <td>10.00</td>
                                        <td>2000.00</td>
                                        <td>2000.00</td>
                                        <td>
                                            <a class="delete-set"><img src="assets/img/icons/delete.svg" alt="svg"></a>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 float-md-right">
                        <div class="total-order">
                            <ul>
                                <li>
                                    <h4>Order Tax</h4>
                                    <h5>$ 0.00 (0.00%)</h5>
                                </li>
                                <li>
                                    <h4>Discount </h4>
                                    <h5>$ 0.00</h5>
                                </li>
                                <li>
                                    <h4>Shipping</h4>
                                    <h5>$ 0.00</h5>
                                </li>
                                <li class="total">
                                    <h4>Grand Total</h4>
                                    <h5>$ 0.00</h5>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>



        {{-- BOOTSTRAP MODAL FOR ADDING A NEW CUSTOMER --}}
        <div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="create" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <form id="newCustomerForm">
                        @csrf

                        <div class="modal-body">
                            <div class="form-group">
                                <label>Name *</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Mobile *</label>
                                <input type="text" name="mobile" class="form-control" required>
                            </div>
                            {{-- Optionally: address, etc. --}}
                        </div>
                        <div class="modal-footer">

                            <a class="btn btn-cancel" data-bs-dismiss="modal">Cancel</a>
                            <button type="submit" class="btn btn-submit me-2"> Save Customer
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>



    </div>
@endsection




@push('scripts')
    <script>
        // We store cart data in localStorage under this key
        const CART_KEY = 'myCartData';

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $(document).ready(function() {

            // Set current date in DD-MM-YYYY format
            const currentDate = new Date();
            const formattedDate = currentDate.toLocaleDateString('en-GB').replace(/\//g,
                '-'); // Formats as DD-MM-YYYY

            // Set the value of the invoice date input
            $('#invoice-date').val(formattedDate);

            // Product Select2
            $('#product-select').select2({
                placeholder: 'Type to search products...',
                ajax: {
                    url: '{{ route('products.search') }}', // /api/products/search
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            term: params.term
                        };
                    },
                    processResults: function(data) {
                        // data => { results: [ {id, text, price, gst_slab}, ... ] }
                        return data;
                    },
                    cache: true
                }
            });

            // Customer Select2
            $('#customer-select').select2({
                placeholder: 'Type name or mobile...',
                ajax: {
                    url: '{{ route('customers.search') }}', // /api/customers/search
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            term: params.term
                        };
                    },
                    processResults: function(data) {
                        // data => { results: [ {id, text}, ... ] }
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            });

            // Load and render cart from localStorage on page load
            renderCart();
        });

        // 9. ADD NEW CUSTOMER MODAL//

        $('#newCustomerForm').on('submit', function(e) {
            e.preventDefault();

            // Collect form data: name, mobile, etc.
            let formData = $(this).serialize();

            // POST to your existing route: /api/customers
            $.ajax({
                url: '{{ route('customers.store') }}', // /api/customers
                type: 'POST',
                data: formData,
                success: function(response) {
                    // response => { id, text } (you can define how you return it)
                    let newOption = new Option(response.text, response.id, false, true);
                    $('#customer-select').append(newOption).trigger('change');

                    // Close modal
                    $('#addCustomerModal').modal('hide');
                    // Reset form
                    $('#newCustomerForm')[0].reset();
                },
                error: function(err) {
                    alert('Failed to create customer. ' + err.responseText);
                }
            });
        });
    </script>
@endpush
