<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Rating;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
  public function show(Product $product)
  {
    $user = Auth::user();

    $product = Product::with('messages')->findOrFail($product->id);

    $product->messages()
    ->where('user_id', '!=', $user->id) // 相手のメッセージ
    ->whereNull('read_at')
    ->update([
        'read_at' => now()
    ]);


    if (!$product->purchase) {
            abort(404);
        }

    $purchase = $product->purchase;

    $alreadyRated = Rating::where('product_id', $product->id)
    ->where('rater_id', auth()->id())
    ->exists();

    $buyer = $purchase->user;
    $seller = $product->user;

    if ($buyer->id !== $user->id && $seller->id !== $user->id) {
    abort(403);
    }

    // 自分がどっちか判定
    if ($buyer->id === $user->id) {
            $partner = $seller;
            $isBuyer = true;
            $isSeller = false;
        } else {
            $partner = $buyer;
            $isBuyer = false;
            $isSeller = true;
        }

    $partnerProfile = $partner->profile ?? null;
    $myProfile = $user->profile ?? null;

    // 自分が購入した商品
        $purchasedProducts = $user->purchases()
            ->with('product')
            ->get()
            ->pluck('product')
            ->filter(); // null除去

        // 自分が出品して購入された商品
        $soldProducts = Product::where('user_id', $user->id)
            ->whereHas('purchase')
            ->get();

        // 合体して重複削除
        $transactionProducts = $purchasedProducts
            ->merge($soldProducts)
            ->unique('id')
            ->values();

        // 今見てる商品を除外
        $otherProducts = $transactionProducts
            ->where('id', '!=', $product->id)
            ->values();


        return view('transaction', compact(
            'product',
            'user',
            'partner',
            'partnerProfile',
            'myProfile',
            'isBuyer',
            'isSeller',
            'otherProducts',
            'purchase',
            'alreadyRated'
        ));
    }
}