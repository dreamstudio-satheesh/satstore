<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    //

    public function search(Request $request)
    {
        $term = $request->get('term', '');

        // Example: match name or mobile
        $customers = Customer::where('name', 'LIKE', "%$term%")
            ->orWhere('mobile', 'LIKE', "%$term%")
            ->limit(20)
            ->get();

        // Format results for Select2
        $formatted = [];
        foreach ($customers as $customer) {
            $formatted[] = [
                'id'   => $customer->id,
                'text' => $customer->name . ' (' . $customer->mobile . ')',
            ];
        }

        return response()->json($formatted);
    }



    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string',
            'mobile' => 'required|string|unique:customers,mobile',
        ]);

        $customer = \App\Models\Customer::create([
            'name'    => $request->name,
            'mobile'  => $request->mobile,
            'address' => $request->address,
        ]);

        // Return in Select2 format
        return response()->json([
            'id'   => $customer->id,
            'text' => $customer->name . ' (' . $customer->mobile . ')',
        ]);
    }
}
