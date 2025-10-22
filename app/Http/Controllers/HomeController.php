<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Portofolio;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::where('is_published', true)
            ->latest()
            ->take(6)
            ->get();

        $portfolios = Portofolio::where('is_published', true)
            ->latest()
            ->take(4)
            ->get();

        return Inertia::render('Home', [
            'products' => $products->map(fn($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'price' => 'Rp ' . number_format($p->price, 0, ',', '.'),
                'description' => $p->description,
                'image' => $p->image ? asset('storage/' . $p->image) : null,
            ]),
            'portfolios' => $portfolios->map(fn($p) => [
                'id' => $p->id,
                'title' => $p->title,
                'image' => $p->image ? asset('storage/' . $p->image) : null,
            ]),
        ]);
    }
}
