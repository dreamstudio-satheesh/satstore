<div class="content">
    <div class="row">
        <!-- Categories List -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Categories</h5>
                    <input id="searchInput" wire:model.live.debounce.300ms="search" type="text" class="form-control"
                        placeholder="Search Categories..." accesskey="s">
                </div>
                <div class="card-body">
                    @if (session()->has('message'))
                        <div id="alert-message" class="alert alert-success alert-dismissible fade show" role="alert">
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
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                                <tr>
                                    <td>{{ ($categories->currentPage() - 1) * $categories->perPage() + $loop->index + 1 }}
                                    </td>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        <button wire:click="edit({{ $category->id }})"
                                            class="btn btn-primary btn-sm"  accesskey="{{ $loop->index < 9 ? $loop->index + 1 : 0 }}">Edit</button>
                                        <button wire:click="delete({{ $category->id }})"
                                            class="btn btn-danger btn-sm">Delete</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">No Categories Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $categories->links() }}
                </div>
            </div>
        </div>

        <!-- Create/Update Category Form -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>{{ $categoryId ? 'Edit Category' : 'Create Category' }}</h5>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="store">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" wire:model="name" autofocus accesskey="n">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="pt-3">
                            <button type="submit" class="btn btn-rounded btn-secondary">Save</button>
                            <button type="button" wire:click="resetInputFields"
                                class="btn  btn-rounded btn-warning">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    @push('scripts')
       
    @endpush
</div>
