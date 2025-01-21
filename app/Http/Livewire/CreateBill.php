<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Bill;
use App\Models\BillItem;

class CreateBill extends Component
{
    // Customer properties
    public $customer_id;

    // Bill properties
    public $bill_date;
    public $discount = 0;
    public $total_amount = 0;
    public $final_amount = 0;

    // Search & cart
    public $searchTerm = '';
    public $cart = []; // e.g. [ ['product_id'=>..., 'product_name'=>..., 'quantity'=>1, 'price'=>..., 'gst_slab'=>...] ]

    // Lifecycle hook
    public function mount()
    {
        // Default bill date to today
        $this->bill_date = now()->format('Y-m-d');
    }

    // Search products by name/barcode
    public function updatedSearchTerm()
    {
        // optionally handle search in real-time or in the render() method
    }

    public function addProduct($productId)
    {
        $product = Product::find($productId);

        if (!$product) {
            session()->flash('error', 'Product not found!');
            return;
        }

        // Add item to cart
        $this->cart[] = [
            'product_id'   => $product->id,
            'product_name' => $product->name_english ?? $product->name_tamil,
            'quantity'     => 1,
            'price'        => $product->price,
            'gst_slab'     => $product->gst_slab,
        ];

        $this->calculateTotals();
    }

    public function removeProduct($index)
    {
        unset($this->cart[$index]);
        $this->cart = array_values($this->cart); // reindex
        $this->calculateTotals();
    }

    public function updatedCart()
    {
        // Anytime the cart array changes (qty/price edits), recalc
        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        $sum = 0;
        foreach ($this->cart as $item) {
            $sum += ($item['price'] * $item['quantity']);
        }
        $this->total_amount = $sum;
        $this->final_amount = $sum - $this->discount;
    }

    public function updatedDiscount()
    {
        $this->calculateTotals();
    }



    public function storeBill()
    {
        if (empty($this->cart)) {
            session()->flash('error', 'No items in the cart!');
            return;
        }

        // Create Bill
        $bill = Bill::create([
            'user_id'      => auth()->id(),
            'customer_id'  => $this->customer_id,
            'total_amount' => $this->total_amount,
            'discount'     => $this->discount,
            'final_amount' => $this->final_amount,
        ]);

        // Insert Bill Items
        foreach ($this->cart as $item) {
            BillItem::create([
                'bill_id'    => $bill->id,
                'product_id' => $item['product_id'],
                'quantity'   => $item['quantity'],
                'price'      => $item['price'],
                'gst_slab'   => $item['gst_slab'],
            ]);
        }

        session()->flash('success', 'Bill created successfully!');
        return redirect()->route('bill.create');
    }

    public function render()
    {
        // Optional: If searchTerm is not empty, fetch matching products
        $products = [];
        if ($this->searchTerm) {
            $products = Product::where('name_english', 'LIKE', "%{$this->searchTerm}%")
                ->orWhere('name_tamil', 'LIKE', "%{$this->searchTerm}%")
                ->orWhere('barcode', 'LIKE', "%{$this->searchTerm}%")
                ->get();
        }

        // List existing customers if needed (or do it via separate dropdown)
        // $customers = Customer::all();

        return view('livewire.create-bill', [
            'products' => $products,
        ]);
    }
}
