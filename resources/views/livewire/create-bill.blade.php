<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>Add Sale</h4>
            <h6>Add your new sale</h6>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="form-group">
                        <label>Customer</label>
                        <div class="row">
                            <div class="col-lg-10 col-sm-10 col-10">
                                <select class="form-control">
                                    <option>Choose</option>
                                    <option>Customer Name</option>
                                </select>
                            </div>
                            <div class="col-lg-2 col-sm-2 col-2 ps-0">
                                <div class="add-icon">
                                    <span><img src="{{ url('assets') }}/img/icons/plus1.svg" alt="img"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="form-group">
                        <label>Bill Date</label>
                        <input type="date" placeholder="Choose Date" class="form-control">
                    </div>
                </div>

                <div class="col-lg-10 col-sm-6 col-12">
                    <div class="form-group">
                        <label>Product Name</label>
                        <div class="input-groupicon">

                            <input type="text" placeholder="Please type product code and select...">
                            <div class="addonset">
                                <img src="{{ url('assets') }}/img/icons/scanners.svg" alt="img">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-10 col-sm-6 col-12">
                    <div class="table-responsive mb-3">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>QTY</th>
                                    <th>Price</th>
                                    <th>Tax</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td >Apple Earpods</td>
                                    <td>1.00</td>
                                    <td>15000.00</td>
                                    <td>0.00</td>
                                    <td>1500.00</td>
                                    <td>
                                        <a href="javascript:void(0);" class="delete-set"><img
                                                src="{{ url('assets') }}/img/icons/delete.svg" alt="svg"></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>iPhone 11</td>
                                    <td>1.00</td>
                                    <td>1500.00</td>

                                    <td>0.00</td>
                                    <td>1500.00</td>
                                    <td>
                                        <a href="javascript:void(0);" class="delete-set"><img
                                                src="{{ url('assets') }}/img/icons/delete.svg" alt="svg"></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Macbook pro</td>
                                    <td>1.00</td>
                                    <td>1500.00</td>

                                    <td>0.00</td>
                                    <td>1500.00</td>
                                    <td>
                                        <a href="javascript:void(0);" class="delete-set"><img
                                                src="{{ url('assets') }}/img/icons/delete.svg" alt="svg"></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>



            <div class="col-lg-12">
                <a href="javascript:void(0);" class="btn btn-submit me-2">Submit</a>
                <a href="javascript:void(0);" class="btn btn-cancel">Cancel</a>
            </div>
        </div>
    </div>
</div>
</div>
