<div class="content">
    <div class="row">
        <!-- Customer List -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Customers</h5>
                    <input wire:model.debounce.300ms="search" type="text" class="form-control"
                        placeholder="Search Customers..." accesskey="s">
                </div>
                <div class="card-body">
                    @if (session()->has('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>Address</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($customers as $customer)
                                <tr>
                                    <td>{{ ($customers->currentPage() - 1) * $customers->perPage() + $loop->index + 1 }}
                                    </td>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->mobile }}</td>
                                    <td>{{ $customer->address }}</td>
                                    <td>
                                        <button wire:click="edit({{ $customer->id }})" class="btn btn-primary btn-sm"
                                            accesskey="{{ $loop->index < 9 ? $loop->index + 1 : 0 }}">Edit</button>
                                        <button wire:click="delete({{ $customer->id }})"
                                            class="btn btn-danger btn-sm">Delete</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">No Customers Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $customers->links() }}
                </div>
            </div>
        </div>

        <!-- Create/Update Customer Form -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>{{ $customerId ? 'Edit Customer' : 'Create Customer' }}</h5>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="store">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" wire:model="name" accesskey="n" autofocus>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Mobile</label>
                            <input type="text" class="form-control" wire:model="mobile">
                            @error('mobile')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea class="form-control" wire:model="address"></textarea>
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="pt-3">
                            <button type="submit" class="btn btn-secondary">Save</button>
                            <button type="button" wire:click="resetInputFields" class="btn btn-warning">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
