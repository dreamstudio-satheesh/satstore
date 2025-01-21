@extends('layouts.admin')

@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Add Sale</h4>
                <h6>Add your new sale</h6>
            </div>
        </div>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body">
                {{-- PRODUCT SEARCH + ADD BUTTON --}}
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="product-select">Search Products</label>
                        <select id="product-select" class="form-control" style="width:100%;">
                            <option value="">--Type to search--</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-primary" id="btnAddToCart" style="margin-top: 28px;">
                            Add to Cart
                        </button>
                    </div>
               

                {{-- CUSTOMER SELECT2 + "ADD NEW" BUTTON --}}
                    <div class="col-md-4">
                        <label for="customer-select">Customer</label>
                        <select id="customer-select" class="form-control" style="width:100%;">
                            <option value="">--Type name or mobile--</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-secondary" data-toggle="modal" data-target="#addCustomerModal"
                            style="margin-top: 28px;">
                            Add New Customer
                        </button>
                    </div>
                </div>


            </div>
        </div>


        <div class="card">
            <div class="card-body">
                {{-- CART TABLE --}}
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>QTY</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="cart-body">
                        {{-- Populated dynamically by JS from localStorage --}}
                    </tbody>
                </table>

                {{-- DISCOUNT, TOTAL, FINAL AMOUNT --}}
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="discount">Discount</label>
                        <input type="number" class="form-control" id="discount" value="0">
                    </div>
                    <div class="col-md-3">
                        <label>Total Amount</label>
                        <div class="form-control" id="total-amount" readonly>0.00</div>
                    </div>
                    <div class="col-md-3">
                        <label>Final Amount</label>
                        <div class="form-control" id="final-amount" readonly>0.00</div>
                    </div>
                </div>
            </div>
        </div>



        {{-- FINAL SUBMIT FORM --}}
        <form method="POST" action="{{ route('bill.store') }}" onsubmit="return submitBill()">
            @csrf
            <input type="hidden" name="cart_data" id="cart-data-input">
            <input type="hidden" name="discount" id="discount-input">
            <input type="hidden" name="customer_id" id="customer-id-input">

            <button type="submit" class="btn btn-success">Save Bill</button>
        </form>
    </div>

    {{-- BOOTSTRAP MODAL FOR ADDING A NEW CUSTOMER --}}
    <div class="modal fade" id="addCustomerModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="newCustomerForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Customer</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Save Customer
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            //////////////////////
            // 0. GLOBAL CONFIG  //
            //////////////////////

            // We store cart data in localStorage under this key
            const CART_KEY = 'myCartData';

            //////////////////////
            // 1. INIT SELECT2s  //
            //////////////////////
            $(document).ready(function() {
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
                            return data;
                        },
                        cache: true
                    }
                });

                // Load and render cart from localStorage on page load
                renderCart();
            });

            ////////////////////////////
            // 2. CART LOCALSTORAGE   //
            ////////////////////////////
            function getCart() {
                let cartJson = localStorage.getItem(CART_KEY);
                return cartJson ? JSON.parse(cartJson) : [];
            }

            function saveCart(cart) {
                localStorage.setItem(CART_KEY, JSON.stringify(cart));
            }

            ///////////////////////
            // 3. ADD TO CART     //
            ///////////////////////
            document.getElementById('btnAddToCart').addEventListener('click', function(e) {
                e.preventDefault();

                // Get selected product from Select2
                let selectedData = $('#product-select').select2('data');
                if (!selectedData || !selectedData.length) {
                    return; // no product selected
                }

                let item = selectedData[0]; // single select
                // item = {id, text, price, gst_slab}

                let cart = getCart();

                // Check if product already in cart
                let existingIndex = cart.findIndex(c => c.product_id == item.id);
                if (existingIndex > -1) {
                    cart[existingIndex].quantity++;
                } else {
                    cart.push({
                        product_id: item.id,
                        product_name: item.text,
                        price: parseFloat(item.price || 0),
                        gst_slab: item.gst_slab || null,
                        quantity: 1
                    });
                }

                saveCart(cart);
                renderCart();
            });

            ///////////////////////
            // 4. RENDER THE CART //
            ///////////////////////
            function renderCart() {
                let cart = getCart();
                let tbody = document.getElementById('cart-body');
                tbody.innerHTML = '';

                let total = 0;

                cart.forEach((item, idx) => {
                    let subtotal = item.price * item.quantity;
                    total += subtotal;

                    let row = document.createElement('tr');
                    row.innerHTML = `
      <td>${idx + 1}</td>
      <td>${item.product_name}</td>
      <td>
        <input type="number" min="1" value="${item.quantity}" 
               style="width:60px;"
               onchange="updateQty(${idx}, this.value)">
      </td>
      <td>${item.price.toFixed(2)}</td>
      <td>${subtotal.toFixed(2)}</td>
      <td>
        <button class="btn btn-danger btn-sm" onclick="removeItem(${idx})">Remove</button>
      </td>
    `;

                    tbody.appendChild(row);
                });

                let discountVal = parseFloat(document.getElementById('discount').value) || 0;
                document.getElementById('total-amount').textContent = total.toFixed(2);
                document.getElementById('final-amount').textContent = (total - discountVal).toFixed(2);
            }

            ///////////////////////
            // 5. UPDATE QTY      //
            ///////////////////////
            function updateQty(index, newQty) {
                let cart = getCart();
                cart[index].quantity = parseInt(newQty) || 1;
                saveCart(cart);
                renderCart();
            }

            ///////////////////////
            // 6. REMOVE ITEM     //
            ///////////////////////
            function removeItem(index) {
                let cart = getCart();
                cart.splice(index, 1);
                saveCart(cart);
                renderCart();
            }

            ////////////////////////
            // 7. DISCOUNT CHANGE  //
            ////////////////////////
            document.getElementById('discount').addEventListener('input', function() {
                renderCart();
            });

            ////////////////////////
            // 8. FINAL SUBMIT     //
            ////////////////////////
            function submitBill() {
                let cart = getCart();
                if (cart.length === 0) {
                    alert('Cart is empty!');
                    return false;
                }

                // Put cart + discount + customer in hidden inputs
                document.getElementById('cart-data-input').value = JSON.stringify(cart);
                document.getElementById('discount-input').value = document.getElementById('discount').value;
                document.getElementById('customer-id-input').value = $('#customer-select').val();

                // Clear localStorage AFTER submission so the cart is gone
                localStorage.removeItem(CART_KEY);

                return true; // allow form to proceed
            }

            //////////////////////////////
            // 9. ADD NEW CUSTOMER MODAL//
            //////////////////////////////
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
@endsection
