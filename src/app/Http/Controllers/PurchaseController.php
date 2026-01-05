<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function show(Product $product)
    {
        $user = Auth::user();
        $profile = $user->profile;

        return view('purchase', compact('product', 'profile'));
    }



    public function editAddress(Product $product)
    {
        $user = Auth::user();
        return view('address_change', compact('user', 'product'));
    }

    public function updateAddress(Request $request, Product $product)
    {
        $user = Auth::user();

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $request->only(['postal_code', 'address', 'building'])
        );

        return redirect()->route('purchase', $product);
    }

}