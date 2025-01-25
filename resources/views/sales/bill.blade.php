@extends('layouts.admin')


@section('content')
    <div class="content">


        <!-- Sales  -->
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Add Item to Sale</h5>

                <div class="row">

                    @include('sales.bill-customer')
                    <div class="col-lg-1 col-sm-1 col-1"></div>

                    <div class="col-lg-2 col-sm-6 col-12">
                        <div class="form-group">
                            <div class="input-groupicon">
                                <input type="text" id="product-search" placeholder="Scan/Search Product ..." accesskey="s"
                                    autofocus>
                                <div class="addonset">
                                    <img src="assets/img/icons/scanners.svg" alt="img">
                                </div>
                            </div>
                            <ul id="search-results" class="dropdown-menu" style="display: none;"></ul>
                        </div>

                    </div>

                    <div class="col-lg-2 col-sm-12 col-12">
                        <div class="form-group">
                            <input type="number" id="item-quantity" class="form-control" style="max-width: 140px"
                                placeholder="Enter quantity">
                        </div>
                    </div>

                </div>

                <div class="sales-page">
                    <div id="scrollable-container">
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Item Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="sales-items">
                                <!-- Dynamically added rows -->
                            </tbody>
                        </table>

                    </div>
                </div>


            </div>
        </div>

        <!-- Summary Section -->
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <h5 class="card-title">Summary</h5>
                    </div>
                    <div class="col-3">
                        <span>Total Products in Cart: </span>
                        <span id="cart-product-count">0</span>
                    </div>
                    <div class="col-3">
                        <span>Total Items in Cart: </span>
                        <span id="cart-item-count">0</span>
                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>GST Rate</th>
                            <th>Taxable Value</th>
                            <th>CGST</th>
                            <th>SGST</th>
                            <th>Total Tax</th>
                        </tr>
                    </thead>
                    <tbody id="tax-breakup">
                        <!-- Tax breakup rows will be dynamically inserted here -->
                    </tbody>
                </table>

                <div class="row py-3 my-3 mx-1  bg-light">
                    <div class="col text-center">
                        <span class="text-muted">Subtotal:</span>
                        <span class="text-primary font-weight-bold" id="subtotal">₹0.00</span>

                        <span class="mx-4"></span> <!-- Spacer between Subtotal and Tax -->

                        <span class="text-muted">Tax:</span>
                        <span class="text-danger font-weight-bold" id="tax">₹0.00</span>

                        <span class="mx-4"></span> <!-- Spacer between Tax and Total -->

                        <span class="text-muted">Total:</span>
                        <span class="text-success font-weight-bold" id="total">₹0.00</span>
                    </div>
                </div>

            </div>
        </div>




        <!-- Action Buttons -->
        <div class="text-right">
            <button id="finalize-sale-btn" class="btn btn-success mr-2" accesskey="f">Finalize Sale (F3)</button>
            <button id="clear-sale-btn" class="btn btn-danger" accesskey="e">Clear Sale (F2)</button>
        </div>
    </div>



    </div>
@endsection


@push('styles')
    <style>
        .sales-page {
            max-width: 900px;
        }

        .table tbody tr td {
            vertical-align: middle;
        }

        .btn {
            white-space: nowrap;
        }

        #search-results {
            position: absolute;
            z-index: 1000;
            background-color: white;
            border: 1px solid #ccc;
            list-style: none;
            margin: 0;
            padding: 0;
            width: 240px;
            max-height: 160px;
            overflow-y: auto;
        }

        #search-results .dropdown-item {
            padding: 10px;
            cursor: pointer;
        }

        #search-results .dropdown-item:hover,
        #search-results .dropdown-item.active {
            background-color: #007bff;
            color: white;
        }
    </style>
@endpush

@push('scripts')
    <script>
        class SalesManager {
            constructor() {
                this.products = []; // List of products (should be passed in during initialization)
                this.salesList = []; // Tracks items added to the sales cart
                this.searchField = document.getElementById("product-search");
                this.quantityField = document.getElementById("item-quantity");
                this.salesTableBody = document.getElementById("sales-items");
                this.searchResults = document.getElementById("search-results");

                this.currentSelectionIndex = -1;
                this.filteredProducts = [];

                this.initializeEventListeners();
            }

            initializeEventListeners() {
                this.searchField.addEventListener("input", (e) => this.handleSearchInput(e));
                this.searchField.addEventListener("keydown", (e) => this.handleSearchNavigation(e));
                this.quantityField.addEventListener("keypress", (e) => this.handleQuantityEnter(e));
                this.searchResults.addEventListener("click", (e) => this.handleSearchResultClick(e));
                this.salesTableBody.addEventListener("click", (e) => this.handleRemoveItemClick(e));

                // Hide search results when search field loses focus
                this.searchField.addEventListener("blur", () => {
                    // Add a delay to allow click events on results to process
                    setTimeout(() => {
                        this.searchResults.style.display = "none";
                    }, 150);
                });

                // Ensure search results remain visible when focused again
                this.searchField.addEventListener("focus", () => {
                    if (this.filteredProducts.length > 0) {
                        this.searchResults.style.display = "block";
                    }
                });
            }

            handleSearchInput(event) {
                const query = event.target.value.trim();
                if (query.length < 2) {
                    this.searchResults.style.display = "none";
                    return;
                }

                // Check if the query is numeric and matches a barcode
                const matchingProduct = this.products.find(product => product.barcode === query);

                if (matchingProduct) {
                    // If a matching product is found, auto-add it to sales
                    this.addItem(matchingProduct, 1); // Default quantity is 1
                    this.resetFields();
                    return;
                }

                // If no exact barcode match, filter products for search
                this.filteredProducts = this.products.filter(product =>
                    product.name_tamil.toLowerCase().includes(query.toLowerCase()) ||
                    (product.name_english && product.name_english.toLowerCase().includes(query.toLowerCase())) ||
                    product.barcode.toLowerCase().includes(query.toLowerCase())
                );
                this.displayResults(this.filteredProducts);

                this.currentSelectionIndex = -1;
            }

            handleSearchNavigation(event) {
                if (this.searchResults.style.display === "none" || this.filteredProducts.length === 0) return;

                if (event.key === "ArrowDown") {
                    this.currentSelectionIndex = (this.currentSelectionIndex + 1) % this.filteredProducts.length;
                    this.updateSelection();
                } else if (event.key === "ArrowUp") {
                    this.currentSelectionIndex =
                        (this.currentSelectionIndex - 1 + this.filteredProducts.length) % this.filteredProducts.length;
                    this.updateSelection();
                } else if (event.key === "Enter" && this.currentSelectionIndex >= 0) {
                    this.selectProduct(this.filteredProducts[this.currentSelectionIndex]);
                }
            }

            handleSearchResultClick(event) {
                if (event.target.classList.contains("dropdown-item")) {
                    const product = JSON.parse(event.target.dataset.product);
                    this.selectProduct(product);
                }
            }

            handleQuantityEnter(event) {
                if (event.key === "Enter") {
                    const product = JSON.parse(this.quantityField.dataset.product || "{}");
                    const quantity = parseInt(this.quantityField.value);
                    if (product.id && quantity > 0) {
                        this.addItem(product, quantity);
                        this.resetFields();
                    }
                }
            }

            handleRemoveItemClick(event) {
                if (event.target.classList.contains("remove-item-btn")) {
                    const index = event.target.dataset.index;
                    this.salesList.splice(index, 1);
                    this.updateSalesList();
                }
            }


            displayResults(results) {
                this.searchResults.innerHTML = "";
                // Limit results to a maximum of 6
                const limitedResults = results.slice(0, 6);

                if (limitedResults.length > 0) {
                    limitedResults.forEach((product, index) => {
                        const li = document.createElement("li");
                        li.textContent = product.name_tamil || product.name_english;
                        li.className = "dropdown-item";
                        li.dataset.index = index;
                        li.dataset.product = JSON.stringify(product);
                        this.searchResults.appendChild(li);
                    });
                    this.searchResults.style.display = "block";
                } else {
                    this.searchResults.style.display = "none";
                }
            }

            updateSelection() {
                const items = this.searchResults.querySelectorAll(".dropdown-item");
                items.forEach((item, index) => {
                    if (index === this.currentSelectionIndex) {
                        item.classList.add("active");
                        item.scrollIntoView({
                            block: "nearest"
                        });
                    } else {
                        item.classList.remove("active");
                    }
                });
            }

            selectProduct(product) {
                this.searchField.value = product.name_tamil || product.name_english;
                this.quantityField.dataset.product = JSON.stringify(product);
                this.searchResults.style.display = "none";
                this.quantityField.focus();
                this.currentSelectionIndex = -1;
            }

            addItem(product, quantity) {
                const existingIndex = this.salesList.findIndex(item => item.id === product.id);
                if (existingIndex > -1) {
                    this.salesList[existingIndex].quantity += quantity;
                    this.salesList[existingIndex].total += product.price * quantity;
                } else {
                    this.salesList.push({
                        id: product.id,
                        name: product.name_tamil || product.name_english,
                        price: product.price,
                        gst_slab: product.gst_slab,
                        quantity: quantity,
                        total: product.price * quantity,
                    });
                }
                this.updateSalesList();
            }

            updateSalesList() {
                this.salesTableBody.innerHTML = "";
                this.salesList.forEach((item, index) => {
                    const row = document.createElement("tr");
                    row.innerHTML = `
                        <td>${item.name}</td>
                        <td>${parseFloat(item.price).toFixed(2)}</td>
                        <td>
                            <input 
                                type="number" 
                                class="form-control quantity-input" 
                                style="max-width:100px"
                                data-index="${index}" 
                                value="${item.quantity}" 
                                min="1"
                            />
                        </td>
                        <td class="total-cell">${item.total.toFixed(2)}</td>
                        <td><button data-index="${index}" class="btn btn-danger btn-sm remove-item-btn">Remove</button></td>
                    `;
                    this.salesTableBody.appendChild(row);
                });

                // Attach event listeners to quantity inputs
                this.salesTableBody.querySelectorAll(".quantity-input").forEach(input => {
                    input.addEventListener("change", (e) => this.handleQuantityChange(e));
                });

                this.calculateTotals();

                // Update total cart items count
                const totalItems = this.calculateTotalItems();
                document.getElementById("cart-item-count").textContent = totalItems;

                // Update total products count
                const totalProducts = this.salesList.length;
                document.getElementById("cart-product-count").textContent = totalProducts;
            }

            handleQuantityChange(event) {
                const index = event.target.dataset.index;
                const newQuantity = parseInt(event.target.value);

                if (isNaN(newQuantity) || newQuantity <= 0) {
                    alert("Please enter a valid quantity.");
                    event.target.value = this.salesList[index].quantity; // Reset to old value
                    return;
                }

                // Update the quantity and total for the selected item
                this.salesList[index].quantity = newQuantity;
                this.salesList[index].total = this.salesList[index].price * newQuantity;

                // Update the DOM and totals
                this.updateSalesList();
            }


            calculateTotals() {
                let subtotalExclTax = 0; // Subtotal excluding tax
                let totalTax = 0; // Total tax amount
                const taxBreakup = {}; // Store tax details by GST slab

                this.salesList.forEach(item => {
                    const taxRate = parseFloat(item.gst_slab) / 100; // Convert slab to decimal
                    const priceExclTax = item.price / (1 + taxRate); // Price excluding tax
                    const taxAmount = item.price - priceExclTax; // Tax amount per unit

                    // Add to running totals
                    subtotalExclTax += priceExclTax * item.quantity;
                    totalTax += taxAmount * item.quantity;

                    // Update tax breakup for the current GST slab
                    if (!taxBreakup[item.gst_slab]) {
                        taxBreakup[item.gst_slab] = {
                            taxableValue: 0,
                            taxAmount: 0
                        };
                    }
                    taxBreakup[item.gst_slab].taxableValue += priceExclTax * item.quantity;
                    taxBreakup[item.gst_slab].taxAmount += taxAmount * item.quantity;
                });

                // Display the totals in the DOM
                document.getElementById("subtotal").textContent = subtotalExclTax.toFixed(2);
                document.getElementById("tax").textContent = totalTax.toFixed(2);
                document.getElementById("total").textContent = (subtotalExclTax + totalTax).toFixed(2);

                // Render tax breakup in the DOM
                const taxBreakupContainer = document.getElementById("tax-breakup");
                taxBreakupContainer.innerHTML = ""; // Clear existing content

                Object.keys(taxBreakup).forEach(slab => {
                    const {
                        taxableValue,
                        taxAmount
                    } = taxBreakup[slab];
                    const cgst = taxAmount / 2; // Split tax equally for CGST and SGST
                    const sgst = taxAmount / 2;

                    const row = document.createElement("tr");
                    row.innerHTML = `
                        <td>${slab}%</td>
                        <td>${taxableValue.toFixed(2)}</td>
                        <td>${cgst.toFixed(2)}</td>
                        <td>${sgst.toFixed(2)}</td>
                        <td>${taxAmount.toFixed(2)}</td>
                    `;
                    taxBreakupContainer.appendChild(row);
                });
            }

            calculateTotalItems() {
                let totalItems = 0;
                this.salesList.forEach(item => {
                    totalItems += item.quantity;
                });
                return totalItems;
            }


            resetFields() {
                this.searchField.value = "";
                this.quantityField.value = "";
                this.searchField.focus();
            }
        }

        // Initialize the Sales Manager
        document.addEventListener("DOMContentLoaded", () => {
            const products = @json($products); // Pass your product data from the server
            window.salesManager = new SalesManager();
            salesManager.products = products; // Set products for the manager
        });


        // Initialize Select2
        $('#customer-select').select2({
            placeholder: 'Type name or mobile...',
            ajax: {
                url: '{{ route('customers.search') }}', // API endpoint
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    if (params.term && params.term.length >= 3) {
                        return {
                            term: params.term
                        };
                    }
                    return {};
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                cache: true
            },
            minimumInputLength: 3
        });

        // Set "Cash Bill" as the default customer on page load
        document.addEventListener('DOMContentLoaded', function() {
            const defaultCustomer = {
                id: 1,
                text: 'Cash Bill'
            }; // Default customer details

            // Add the default customer as an option
            const newOption = new Option(defaultCustomer.text, defaultCustomer.id, true, true);
            $('#customer-select').append(newOption).trigger('change');
        });

        // Auto-focus the search box when dropdown opens
        $('#customer-select').on('select2:open', function() {
            const searchField = document.querySelector('.select2-search__field'); // Select the search box
            if (searchField) {
                searchField.focus(); // Focus the search box
            }
        });






        // 9. ADD NEW CUSTOMER MODAL//

        $('#newCustomerForm').on('submit', function(e) {
            e.preventDefault();

            // Collect form data
            const formData = $(this).serialize();

            // Submit data via AJAX
            $.ajax({
                url: '{{ route('customers.store') }}', // Endpoint to create a new customer
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), // CSRF protection
                },
                success: function(response) {
                    // Add new customer to the Select2 dropdown
                    const newOption = new Option(response.text, response.id, false, true);
                    $('#customer-select').append(newOption).trigger('change');

                    // Close the modal
                    $('#addCustomerModal').modal('hide');
                },
                error: function(err) {
                    alert('Failed to create customer. Please try again.');
                }
            });
        });



        // Set current date in DD-MM-YYYY format
        const currentDate = new Date();
        const formattedDate = currentDate.toLocaleDateString('en-GB').replace(/\//g, '-'); // Formats as DD-MM-YYYY

        // Set the value of the invoice date input
        $('#invoice-date').val(formattedDate);

        $(function() {
            $('#scrollable-container').slimScroll({
                height: '260px',
                color: '#000',
                size: '8px',
                alwaysVisible: true
            });
        });



        document.getElementById('finalize-sale-btn').addEventListener('click', function() {
            if (salesManager.salesList.length === 0) {
                alert('No items in the cart. Add products to proceed.');
                return;
            }

            const customerId = $('#customer-select').val(); // Selected customer ID
            const invoiceDate = $('#invoice-date').val(); // Invoice date
            const discount = parseFloat($('#discount').val()) || 0.00; // Discount input
            const subtotal = parseFloat(document.getElementById('subtotal').textContent);
            const tax = parseFloat(document.getElementById('tax').textContent);
            const total = parseFloat(document.getElementById('total').textContent);

            // Prepare data payload
            const payload = {
                customer_id: customerId || null,
                invoice_date: invoiceDate,
                discount: discount,
                subtotal: subtotal,
                tax: tax,
                total: total,
                items: salesManager.salesList, // Include items from sales list
            };

            // Send data to the backend
            $.ajax({
                url: '{{ route('bills.store') }}', // Define a route for storing bills
                type: 'POST',
                data: JSON.stringify(payload),
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    alert('Sale finalized successfully!');
                    salesManager.salesList = []; // Clear sales cart
                    salesManager.updateSalesList(); // Refresh UI
                },
                error: function(xhr) {
                    alert('Failed to finalize sale. Please try again.');
                },
            });
        });
    </script>
@endpush
