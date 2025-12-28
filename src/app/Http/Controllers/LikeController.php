<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store(Product $product)
    {
        Like::firstOrCreate([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
        ]);

        return back();
    }

    public function destroy(Product $product)
    {
        Like::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->delete();

        return back();
    }
}
