<?php

namespace App\Http\Controllers\Homepage;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $product = Product::orderBy('id', 'DESC')->limit(9)->get();
        return view('homepage.home', compact('product'));
    }
}