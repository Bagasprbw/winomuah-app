<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Products/Index', [
            'company' => Company::first(),
            'products' => Product::with('category')->get()->map(fn($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'description' => $p->description,
                'image' => $p->image,
                'price' => $p->price,
                'is_published' => (bool) $p->is_published,
                'category' => $p->category?->name,
            ]),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Products/Create', [
            'company' => Company::first(),
            'categories' => Category::where('type', 'product')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->route('products.index')->with('success', '✅ Product created successfully!');
    }

    public function edit(Product $product)
    {
        return Inertia::render('Admin/Products/Edit', [
            'company' => Company::first(),
            'categories' => Category::where('type', 'product')->get(),
            'product' => $product,
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:5120',
        ]);

        // Jika user upload gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            // Simpan gambar baru
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('products.index')->with('success', '✅ Product updated successfully!');
    }

    public function togglePublish(Request $request, Product $product)
    {
        $request->validate([
            'is_published' => 'required|boolean',
        ]);

        $product->update([
            'is_published' => $request->is_published,
        ]);

        // ✅ Tentukan pesan dinamis
        $message = $request->is_published
            ? "✅ {$product->name} berhasil di-publish!"
            : "⚙️ {$product->name} diubah menjadi private.";

        return back()
            ->with('success', $message);
    }

    public function destroy(Product $product)
    {
        // Hapus gambar dari storage jika ada
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        // Hapus data produk dari database
        $product->delete();

        // Redirect balik ke daftar produk dengan notifikasi sukses
        return redirect()->route('products.index')->with('success', '🗑️ Product deleted successfully!');
    }

    public function publicIndex()
    {
        $products = Product::with('category')
            ->where('is_published', true)
            ->latest()
            ->get();

        return Inertia::render('Products/Index', [
            'products' => $products->map(fn($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'price' => 'Rp ' . number_format($p->price, 0, ',', '.'),
                'description' => $p->description,
                'image' => $p->image ? asset('storage/' . $p->image) : null,
                'category' => $p->category?->name,
            ]),
        ]);
    }

    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);

        return Inertia::render('Products/Show', [
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'price' => 'Rp ' . number_format($product->price, 0, ',', '.'),
                'description' => $product->description,
                'image' => $product->image ? asset('storage/' . $product->image) : null,
                'category' => $product->category?->name,
            ],
        ]);
    }
}
