<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::latest()->take(8)->get(); // contoh ambil 8 produk
        return view('home', compact('products'));
    }
}
