<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'type' => 'required|in:product,portofolio',
        ]);

        Category::create($validated);

        return back()->with('success', '✅ Category added successfully!');
    }

    public function destroy(Category $category)
    {
        // cek apakah kategori masih punya produk
        $productCount = $category->products()->count();
        $portofolioCount = $category->portfolios()->count();

        if ($productCount > 0) {
            // hapus semua produk dan gambarnya
            foreach ($category->products as $product) {
                if ($product->image && Storage::disk('public')->exists($product->image)) {
                    Storage::disk('public')->delete($product->image);
                }
                $product->delete();
            }
        }
        if ($portofolioCount > 0) {
            // hapus semua portofolio dan gambarnya
            foreach ($category->portfolios as $portofolio) {
                if ($portofolio->image && Storage::disk('public')->exists($portofolio->image)) {
                    Storage::disk('public')->delete($portofolio->image);
                }
                $portofolio->delete();
            }
        }

        // hapus kategori
        $category->delete();

        return back()->with('success', '✅ Category and related products deleted successfully!');
    }
}
