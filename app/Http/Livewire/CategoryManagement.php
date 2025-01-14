<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;

class CategoryManagement extends Component
{
    use WithPagination;

    public $categoryId;
    public $name;
    public $search = '';

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'name' => 'required|string|max:255',
    ];

    public function render()
    {
        $categories = Category::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.category-management', compact('categories'));
    }

    public function resetInputFields()
    {
        $this->categoryId = null;
        $this->name = '';
    }

    public function store()
    {
        $this->validate();

        Category::updateOrCreate(['id' => $this->categoryId], [
            'name' => $this->name,
        ]);

        session()->flash('message', 'Category ' . ($this->categoryId ? 'updated' : 'created') . ' successfully!');
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->categoryId = $category->id;
        $this->name = $category->name;
    }

    public function delete($id)
    {
        Category::findOrFail($id)->delete();
        session()->flash('message', 'Category deleted successfully!');
    }
}
