<?php

namespace App\Http\Controllers\Homepage;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index($slug)
    {
        // get parent category
        $categories = Category::where('parent_id', null)->get();
        // get category by slug
        $category = Category::where('slug', $slug)->first();
        $id = $category->id;
        $product = Product::where('categories_id', $id)->paginate(6);

        return view('homepage.category.index', compact('category', 'product', 'categories'));
    }
}