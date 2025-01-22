<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SaleController extends Controller
{

    public function bill()
    {
        $products=Product::select('id','name_tamil','name_english','price','gst_slab','barcode')->get();
        return view('sales.bill' , compact('products'));
    }

    public function create()
    {
        
        return view('sales.create');
    }

    
}
