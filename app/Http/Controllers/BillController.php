<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Bill;
use App\Models\BillItem;

class BillController extends Controller
{
    /**
     * Show the "Create Bill" page
     * (Cart logic is handled by localStorage on the client)
     */
    public function create()
    {
        // Just return the Blade view; no cart data needed server-side
        return view('bills.create');
    }

    /**
     * Search products for Select2 AJAX.
     * URL: /api/products/search
     */
    public function searchProducts(Request $request)
    {
        $term = $request->get('term', '');

        // Adjust to suit your Product model structure
        $query = Product::query();
        if ($term) {
            $query->where('name_english', 'LIKE', "%{$term}%")
                  ->orWhere('name_tamil', 'LIKE', "%{$term}%")
                  ->orWhere('barcode', 'LIKE', "%{$term}%");
        }

        $products = $query->get();

        // Return data in the format Select2 expects:
        // [{id: 1, text: "some name", price: 123, gst_slab: "foo"}, ...]
        $results = $products->map(function ($product) {
            return [
                'id'       => $product->id,
                'text'     => "({$product->barcode}) {$product->name_english}",
                'price'    => $product->price,
                'gst_slab' => $product->gst_slab,
            ];
        });

        return response()->json(['results' => $results]);
    }

    /**
     * Store the final Bill + BillItems in DB.
     * Form submission from create.blade.php
     */
    public function store(Request $request)
    {
        // The entire cart is passed as JSON in "cart_data"
        $cartJson = $request->input('cart_data');
        $cart = json_decode($cartJson, true) ?? [];

        if (empty($cart)) {
            return redirect()->route('bill.create')
                ->with('error', 'No items in cart.');
        }

        $discount   = $request->input('discount', 0);
        $customerId = $request->input('customer_id');

        // Sum up total on server side (security check)
        $sum = 0;
        foreach ($cart as $item) {
            $sum += $item['price'] * $item['quantity'];
        }

        $finalAmount = $sum - $discount;
        if ($finalAmount < 0) {
            $finalAmount = 0;
        }

        // Create Bill
        $bill = Bill::create([
            'user_id'      => auth()->id(), // or however you're assigning user_id
            'customer_id'  => $customerId,
            'total_amount' => $sum,
            'discount'     => $discount,
            'final_amount' => $finalAmount,
        ]);

        // Create Bill Items
        foreach ($cart as $item) {
            BillItem::create([
                'bill_id'    => $bill->id,
                'product_id' => $item['product_id'],
                'quantity'   => $item['quantity'],
                'price'      => $item['price'],
                'gst_slab'   => $item['gst_slab'] ?? null,
            ]);
        }

        // After saving, just redirect
        return redirect()->route('bill.create')
            ->with('success', 'Bill created successfully!');
    }
}
