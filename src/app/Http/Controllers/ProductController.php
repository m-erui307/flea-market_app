<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
}
