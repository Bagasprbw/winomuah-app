<?php

namespace App\Http\Controllers;

use App\Models\Portofolio;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::with('category')
            ->where('is_published', true)
            ->latest()
            ->take(6)
            ->get()
            ->map(function ($p) {
                return [
                    'id' => $p->id,
                    'name' => $p->name,
                    'description' => $p->description,
                    'price' => $p->price,
                    'image' => $p->image ? asset('storage/' . $p->image) : null,
                    'category' => $p->category ? $p->category->name : null,
                ];
            });

        $portofolios = Portofolio::with('category')
            ->where('is_published', true)
            ->latest()
            ->take(8)
            ->get()
            ->map(function ($p) {
                return [
                    'id' => $p->id,
                    'title' => $p->title,
                    'description' => $p->description,
                    'image' => $p->image ? asset('storage/' . $p->image) : null,
                    'category' => $p->category ? $p->category->name : null,
                ];
            });

        return Inertia::render('Home', [
            'products' => $products,
            'portofolios' => $portofolios,
        ]);
    }
}
