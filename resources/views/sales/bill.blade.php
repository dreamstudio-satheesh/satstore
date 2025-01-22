@extends('layouts.admin')


@section('content')
    <div class="content">

        @include('sales.bill-customer')

        <div class="container mt-4 sales-page">
            <!-- Input Section -->
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Add Item to Sale</h5>

                    <div class="row">
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <div class="input-groupicon">
                                    <input type="text" id="product-search" placeholder="Scan/Search Product ..."
                                        autofocus>
                                    <div class="addonset">
                                        <img src="assets/img/icons/scanners.svg" alt="img">
                                    </div>
                                </div>
                                <ul id="search-results" class="dropdown-menu" style="display: none;"></ul>
                            </div>

                        </div>

                        <div class="col-lg-3 col-sm-12 col-12">
                            <div class="form-group">
                                <input type="number" id="item-quantity" class="form-control" placeholder="Enter quantity">
                            </div>
                        </div>

                       
                    </div>
                </div>

            </div>
        </div>

        <!-- Sales List -->
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Sales List</h5>
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

        <!-- Summary Section -->
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Summary</h5>
                <div class="row">
                    <div class="col-md-4">
                        <p>Subtotal: <span id="subtotal" class="font-weight-bold">0.00</span></p>
                    </div>
                    <div class="col-md-4">
                        <p>Tax: <span id="tax" class="font-weight-bold">0.00</span></p>
                    </div>
                    <div class="col-md-4">
                        <p>Total: <span id="total" class="font-weight-bold">0.00</span></p>
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


@push('styles')
    <style>
        .sales-page {
            max-width: 1400px;
            margin: auto;
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
            width: 100%;
            max-height: 200px;
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
            }

            handleSearchInput(event) {
                const query = event.target.value.trim();
                if (query.length < 2) {
                    this.searchResults.style.display = "none";
                    return;
                }

                this.filteredProducts = this.products.filter(product =>
                    product.name_tamil.includes(query) ||
                    (product.name_english && product.name_english.includes(query)) ||
                    product.barcode.includes(query)
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
                if (results.length > 0) {
                    results.forEach((product, index) => {
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
                <td>${item.price.toFixed(2)}</td>
                <td>${item.quantity}</td>
                <td>${item.total.toFixed(2)}</td>
                <td><button data-index="${index}" class="btn btn-danger btn-sm remove-item-btn">Remove</button></td>
            `;
                    this.salesTableBody.appendChild(row);
                });
                this.calculateTotals();
            }

            calculateTotals() {
                const subtotal = this.salesList.reduce((sum, item) => sum + item.total, 0);
                document.getElementById("subtotal").textContent = subtotal.toFixed(2);
                document.getElementById("tax").textContent = (subtotal * 0.1).toFixed(2);
                document.getElementById("total").textContent = (subtotal * 1.1).toFixed(2);
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
            const salesManager = new SalesManager();
            salesManager.products = products; // Set products for the manager
        });
    </script>
@endpush
