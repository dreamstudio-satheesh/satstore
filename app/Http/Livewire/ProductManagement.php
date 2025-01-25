<?php

namespace App\Http\Livewire;

use App\Models\Product;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class ProductManagement extends Component
{
    use WithPagination;

    public $productId, $name_tamil, $name_english, $category_id=1, $hsn_code, $price, $gst_slab = '12', $barcode, $search = '';

    protected $rules = [
        'name_tamil' => 'required|string|max:255',
        'name_english' => 'nullable|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'hsn_code' => 'nullable|string|max:255',
        'price' => 'required|numeric|min:0',
        'gst_slab' => 'required|in:5,12,18',
        'barcode' => 'required|string|unique:products,barcode',
    ];

    public function mount()
    {
        $this->category_id = Category::first()?->id ?? null;
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function resetInputFields()
    {
        $this->productId = null;
        $this->name_tamil = '';
        $this->name_english = '';
        $this->category_id = Category::first()?->id ?? null;
        $this->hsn_code = '';
        $this->price = null;
        $this->gst_slab = '18';
        $this->barcode = '';
    }

    public function store()
    {
        $this->validate([
            'barcode' => 'required|string|unique:products,barcode,' . $this->productId,
        ] + $this->rules);

        Product::updateOrCreate(['id' => $this->productId], [
            'name_tamil' => $this->name_tamil,
            'name_english' => $this->name_english,
            'category_id' => $this->category_id,
            'hsn_code' => $this->hsn_code,
            'price' => $this->price,
            'gst_slab' => $this->gst_slab,
            'barcode' => $this->barcode,
        ]);

        session()->flash('message', 'Product ' . ($this->productId ? 'updated' : 'created') . ' successfully!');
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $this->productId = $product->id;
        $this->name_tamil = $product->name_tamil;
        $this->name_english = $product->name_english;
        $this->category_id = $product->category_id;
        $this->hsn_code = $product->hsn_code;
        $this->price = $product->price;
        $this->gst_slab = $product->gst_slab;
        $this->barcode = $product->barcode;
    }

    public function delete($id)
    {
       // Product::findOrFail($id)->delete();
        session()->flash('message', 'Product deleted successfully!');
    }

    public function render()
    {
        $products = Product::where('name_tamil', 'like', '%' . $this->search . '%')
            ->orWhere('name_english', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'asc')
            ->paginate(10);

        $categories = Category::orderBy('name')->get();

        return view('livewire.product-management', compact('products', 'categories'));
    }
}
