<div class="col-lg-4 col-sm-6 col-12">
    <div class="form-group">
        <label for="customer-select">Customer</label>
        <div class="row">
            <div class="col-lg-10 col-sm-10 col-10">
                <select id="customer-select" class="form-control" style="width:100%;" accesskey="n">
                </select>
            </div>
            <div class="col-lg-2 col-sm-2 col-2 ps-0">
                <div class="add-icon">
                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addCustomerModal"
                        accesskey="c">
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
            <input id="invoice-date" type="text" placeholder="DD-MM-YYYY" class="form-control">
            <div class="addonset">
                <img src="assets/img/icons/calendars.svg" alt="img">
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


@push('scripts')
    <script>
        let lastSearchTerm = ''; // Track the last search term

        $('#customer-select').select2({
            placeholder: 'Type name or mobile...',
            ajax: {
                url: '{{ route('customers.search') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    lastSearchTerm = params.term; // Store the search term
                    if (params.term && params.term.length >= 3) {
                        return {
                            term: params.term
                        };
                    }
                    return {};
                },
                processResults: function(data) {
                    // Check if no results and term is a mobile number
                    if (data.length === 0 && isMobileNumber(lastSearchTerm)) {
                        openNewCustomerModal(lastSearchTerm); // Open modal with mobile number
                    }
                    return {
                        results: data
                    };
                },
                cache: true
            },
            minimumInputLength: 3
        });

        // Check if the term is a 10-digit mobile number
        function isMobileNumber(term) {
            return /^\d{10}$/.test(term);
        }

        // Open modal and set mobile number
        function openNewCustomerModal(mobile) {
            // Close Select2 dropdown explicitly
            $('#customer-select').select2('close');

            $('#addCustomerModal input[name="mobile"]').val(mobile);
            $('#addCustomerModal').modal('show');

            // Focus on name input after modal animation completes
            $('#addCustomerModal').on('shown.bs.modal', function() {
                $('#addCustomerModal input[name="name"]').focus();
            });
        }


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
    </script>
@endpush
