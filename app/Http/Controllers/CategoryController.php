<?php

namespace App\Http\Controllers;

use App\Models\Category;
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

        return back()
        ->with('success', '✅ Category added successfully!');
    }
}
