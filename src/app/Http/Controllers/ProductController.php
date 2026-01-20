<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ExhibitionRequest;
use App\Http\Requests\PurchaseRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;
use App\Models\Purchase;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        $products = Product::with('purchase')
        ->when($userId, function ($query) use ($userId) {
            $query->where('user_id', '!=', $userId);
        })
        ->when($request->keyword, function ($query, $keyword) {
            $query->where('product_name', 'like', "%{$keyword}%");
        })
        ->get();

        return view('product_list', [
        'products' => $products,
        'type' => 'recommend',
        ]);
    }

    public function show($id)
    {
    $product = Product::withCount('likes')->findOrFail($id);
    return view('product_detail', compact('product'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('exhibition', compact('categories'));
    }

    public function recommend(Request $request)
    {
        if (!Auth::check()) {
        return view('product_list', [
            'products' => collect(),
        ]);
    }

        $userId = Auth::id();

        $products = Product::where('user_id', '!=', $userId)
        ->with('purchase')
        ->whereHas('likes', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->when($request->keyword, function ($query, $keyword) {
            $query->where('product_name', 'like', "%{$keyword}%");
        })
        ->get();

        return view('product_list', [
        'products' => $products,
        'type' => 'mylist',
        ]);
    }

    public function store(ExhibitionRequest $request)
    {
    // 画像保存
    $path = $request->file('product_image')->store('products', 'public');

    $product = Product::create([
        'user_id' => Auth::id(),
        'product_name' => $request->product_name,
        'brand' => $request->brand,
        'explanation' => $request->explanation,
        'price' => $request->price,
        'condition' => $request->condition,
        'product_image' => '/storage/' . $path,
    ]);

    if ($request->filled('category_ids')) {
        $product->categories()->sync($request->category_ids);
    }

    return redirect('/product_list');
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $products = Product::when($keyword, function ($query, $keyword) {
            $query->where('product_name', 'like', '%' . $keyword . '%');
        })->get();

        return view('product_list', compact('products', 'keyword'));
    }

    public function purchase(PurchaseRequest $request, Product $product)
    {
        $user = Auth::user();
        $profile = $user->profile;

        // 既に購入済みかチェック
        if ($product->purchase) {
            return redirect()->back();
        }

        // 購入情報作成
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

    public function checkout(PurchaseRequest $request, Product $product)
    {
    $user = Auth::user();

    // 既に購入済みチェック
    if ($product->purchase) {
        return redirect()->back();
    }

    Stripe::setApiKey(config('services.stripe.secret'));

    // 支払い方法分岐
    if ($request->payment == 1) {
        $paymentMethods = ['konbini'];
    } else {
        $paymentMethods = ['card'];
    }

    $session = Session::create([
        'payment_method_types' => $paymentMethods,
        'line_items' => [[
            'price_data' => [
                'currency' => 'jpy',
                'product_data' => [
                    'name' => $product->product_name,
                ],
                'unit_amount' => $product->price,
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',

        'success_url' => route('products.success', $product)
            . '?payment=' . $request->payment,

        'cancel_url' => url()->previous(),
    ]);

    return redirect($session->url);
    }

    public function success(Request $request, Product $product)
    {
    $user = Auth::user();
    $profile = $user->profile;

    // 二重購入防止
    if ($product->purchase) {
        return redirect()->route('product.list');
    }

    Purchase::create([
        'user_id' => $user->id,
        'product_id' => $product->id,
        'postal_code' => $profile->postal_code,
        'address'     => $profile->address,
        'building'    => $profile->building,
        'payment'     => $request->payment, // 1 or 2
    ]);

    return redirect()->route('product.list');
    }
}
