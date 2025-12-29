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
}
