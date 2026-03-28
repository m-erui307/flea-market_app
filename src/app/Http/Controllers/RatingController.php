<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\Product;
use App\Models\Purchase;

class RatingController extends Controller
{
    public function store(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
    $purchase = Purchase::where('product_id', $productId)->first();

    $isBuyer = $purchase && $purchase->user_id === auth()->id();
    $rateeId = $isBuyer ? $product->user_id : $purchase->user_id;

    // これで確実に保存
    Rating::create([
        'rater_id' => auth()->id(),
        'ratee_id' => $rateeId,
        'product_id' => $product->id,
        'rating' => $request->rating,
    ]);

    if ($isBuyer && $purchase && !$purchase->completed_at) {
        $purchase->completed_at = now();
        $purchase->save();
    }

    return redirect()->route('product.list');
    }
}
