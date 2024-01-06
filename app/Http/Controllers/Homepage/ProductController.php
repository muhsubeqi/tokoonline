<?php

namespace App\Http\Controllers\Homepage;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::paginate(6);
        return view('homepage.product.index', compact('product'));
    }

    public function detail($slug)
    {
        $product = Product::where('slug', $slug)->first();
        // get parent category
        $categories = Category::where('parent_id', null)->get();

        return view('homepage.product.detail', compact('product', 'categories'));
    }
}