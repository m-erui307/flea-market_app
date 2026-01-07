<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return view('product_list', compact('products'));
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

    public function recommend()
    {
    $user = Auth::user();

    $products = Product::whereHas('likes', function ($query) use ($user) {
        $query->where('user_id', $user->id);
    })->get();

    return view('product_list', compact('products'));
    }

    public function store(Request $request)
    {
    // 画像保存
    $path = $request->file('image')->store('products', 'public');

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
}
