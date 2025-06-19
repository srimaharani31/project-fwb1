<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct()
    {
        // Hanya owner dan admin yang bisa mengakses selain index dan show
        // $this->middleware('auth')->except(['index', 'show']);
        // $this->middleware('checkRole:owner,admin')->except(['index', 'show']); // Untuk create, store, edit, update, destroy
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['user', 'category'])->paginate(10);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Hanya owner yang bisa membuat produk
        if (Auth::user()->role !== 'owner') {
            abort(403, 'Unauthorized action.');
        }
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Hanya owner yang bisa menyimpan produk
        if (Auth::user()->role !== 'owner') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('product_images', 'public');
        }

        Product::create([
            'user_id' => Auth::id(), // Owner yang membuat produk
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        // Hanya owner yang bisa mengedit produknya sendiri
        if (Auth::user()->role === 'owner' && Auth::id() !== $product->user_id) {
            abort(403, 'Unauthorized action.');
        }
        // Admin bisa mengedit semua produk
        if (Auth::user()->role !== 'owner' && Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // Hanya owner yang bisa mengupdate produknya sendiri
        if (Auth::user()->role === 'owner' && Auth::id() !== $product->user_id) {
            abort(403, 'Unauthorized action.');
        }
        // Admin bisa mengupdate semua produk
        if (Auth::user()->role !== 'owner' && Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('product_images', 'public');
            $product->image = $imagePath;
        }

        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Hanya owner yang bisa menghapus produknya sendiri
        if (Auth::user()->role === 'owner' && Auth::id() !== $product->user_id) {
            abort(403, 'Unauthorized action.');
        }
        // Admin bisa menghapus semua produk
        if (Auth::user()->role !== 'owner' && Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}