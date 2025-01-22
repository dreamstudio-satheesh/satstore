<div class="content">
    <div class="row">


        <!-- Create/Update Product Form -->
        <div class="col-lg-4 col-md-4  col-sm-10">
            <div class="card">
                <div class="card-header">
                    <h5>{{ $productId ? 'Edit Product' : 'Create Product' }}</h5>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="store">
                        <div class="form-group">
                            <input type="text" class="form-control" wire:model="name_tamil" placeholder="Name (Tamil)" accesskey="n" autofocus>
                            @error('name_tamil') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" wire:model="name_english" placeholder="Name (English)">
                            @error('name_english') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                       {{--  <div class="form-group">
                            <select class="form-control" wire:model="category_id">
                                <option value="">Select a Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div> --}}
                        <div class="form-group">
                            <input type="text" class="form-control" wire:model="hsn_code" placeholder="HSN Code">
                            @error('hsn_code') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input type="number" class="form-control" step="0.01" wire:model="price">
                            @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <select class="form-control" wire:model="gst_slab">
                                <option value="5">5%</option>
                                <option value="12">12%</option>
                                <option value="18">18%</option>
                            </select>
                            @error('gst_slab') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" wire:model="barcode" placeholder="Barcode">
                            @error('barcode') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="pt-3">
                            <button type="submit" class="btn btn-rounded btn-secondary">Save</button>
                            <button type="button" wire:click="resetInputFields" class="btn btn-rounded btn-warning">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Products List -->
        <div class="col-lg-8 col-md-8 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Products</h5>
                    <input id="searchInput" wire:model.live.debounce.300ms="search" type="text" class="form-control"
                        placeholder="Search Products..." accesskey="s">
                </div>
                <div class="card-body">
                    @if (session()->has('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name (Tamil)</th>
                                <th>Name (English)</th>
                                <th>Price</th>
                                <th>GST Slab</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr>
                                    <td>{{ ($products->currentPage() - 1) * $products->perPage() + $loop->index + 1 }}</td>
                                    <td>{{ $product->name_tamil }}</td>
                                    <td>{{ $product->name_english }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->gst_slab }}%</td>
                                    <td>
                                        <button wire:click="edit({{ $product->id }})" class="btn btn-primary btn-sm"  accesskey="{{ $loop->index < 9 ? $loop->index + 1 : 0 }}">Edit</button>
                                        <button wire:click="delete({{ $product->id }})" class="btn btn-danger btn-sm">Delete</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">No Products Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $products->links() }}
                </div>
            </div>
        </div>

        
    </div>
</div>
