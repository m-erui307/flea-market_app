<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\PurchaseRequest;

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

    public function updateAddress(AddressRequest $request, Product $product)
    {
        $user = Auth::user();

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $request->only(['postal_code', 'address', 'building'])
        );

        return redirect()->route('purchase', $product);
    }

    public function store(PurchaseRequest $request, Product $product)
    {
    $user = Auth::user();
    $profile = $user->profile;

    if ($product->purchase) {
        return redirect()->back();
    }

    Purchase::create([
        'user_id' => $user->id,
        'product_id' => $product->id,
        'postal_code' => $profile->postal_code,
        'address'     => $profile->address,
        'building'    => $profile->building,
        'payment'     => $request->payment,
    ]);

    return redirect()->route('product.list');
    }
}