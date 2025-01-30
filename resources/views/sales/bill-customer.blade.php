
            <div class="col-lg-4 col-sm-6 col-12">
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
                                    data-bs-target="#addCustomerModal" accesskey="c">
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