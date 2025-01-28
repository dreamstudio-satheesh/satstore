<?php

namespace App\Http\Controllers;


use App\Models\Bill;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function showInvoice($billId)
    {
        $bill = Bill::with(['customer', 'user', 'billItems.product'])->findOrFail($billId);

        return view('invoices.print', compact('bill'));
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
        $validated = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'invoice_date' => 'required|date_format:d-m-Y',
            'discount' => 'required|numeric|min:0',
            'subtotal' => 'required|numeric|min:0',
            'tax' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.gst_slab' => 'required|in:5,12,18',
        ]);

        DB::transaction(function () use ($validated) {

            $bill = Bill::create([
                'user_id' => auth()->id(),
                /** @Disregard [OPTIONAL_CODE] [OPTION_DESCRIPTION] */
                'customer_id' => $validated['customer_id'],
                'total_amount' => $validated['subtotal'],
                'discount' => $validated['discount'],
                'final_amount' => $validated['total'],
            ]);

            // Insert bill items with tax details
            foreach ($validated['items'] as $item) {
                $taxableValue = $item['price'] / (1 + ($item['gst_slab'] / 100));
                $taxAmount = $item['price'] - $taxableValue;
                $cgst = $taxAmount / 2;
                $sgst = $taxAmount / 2;

                $bill->items()->create([
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'taxable_value' => $taxableValue,
                    'gst_slab' => $item['gst_slab'],
                    'cgst' => $cgst,
                    'sgst' => $sgst,
                ]);
            }
        });


        return response()->json(['message' => 'Bill created successfully.']);


        // After saving, just redirect
        /*  return redirect()->route('bill.create')
            ->with('success', 'Bill created successfully!'); */
    }
}
