<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;

class CategoryManagement extends Component
{
    public $categories = [];
    public $name;
    public $categoryId;
    public $isEditing = false;

    protected $rules = [
        'name' => 'required|string|max:255',
    ];

    public function mount()
    {
        $this->loadCategories();
    }

    public function loadCategories()
    {
        $this->categories = Category::all();
    }

    public function createCategory()
    {
        $this->validate();

        Category::create(['name' => $this->name]);

        $this->reset('name');
        $this->loadCategories();
        session()->flash('message', 'Category created successfully!');
    }

    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        $this->categoryId = $category->id;
        $this->name = $category->name;
        $this->isEditing = true;
    }

    public function updateCategory()
    {
        $this->validate();

        $category = Category::findOrFail($this->categoryId);
        $category->update(['name' => $this->name]);

        $this->reset('name', 'categoryId', 'isEditing');
        $this->loadCategories();
        session()->flash('message', 'Category updated successfully!');
    }

    public function deleteCategory($id)
    {
        Category::findOrFail($id)->delete();
        $this->loadCategories();
        session()->flash('message', 'Category deleted successfully!');
    }

    public function render()
    {
        return view('livewire.category-management');
    }
}
