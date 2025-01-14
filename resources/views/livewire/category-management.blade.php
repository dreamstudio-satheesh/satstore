<div>
    <div>
        <h2>Category Management</h2>
    
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    
        <!-- Category Form -->
        <form wire:submit.prevent="{{ $isEditing ? 'updateCategory' : 'createCategory' }}">
            <div class="form-group">
                <label for="name">Category Name</label>
                <input type="text" id="name" wire:model="name" class="form-control">
                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <button type="submit" class="btn btn-primary">
                {{ $isEditing ? 'Update Category' : 'Add Category' }}
            </button>
        </form>
    
        <!-- Category List -->
        <h3 class="mt-4">Categories</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" wire:click="editCategory({{ $category->id }})">Edit</button>
                            <button class="btn btn-danger btn-sm" wire:click="deleteCategory({{ $category->id }})">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
</div>
