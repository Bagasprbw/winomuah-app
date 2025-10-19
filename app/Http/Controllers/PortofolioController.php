<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Company;
use App\Models\Portofolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class PortofolioController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Portofolio/Index', [
            'company' => Company::first(),
            'portofolio' => Portofolio::with('category')->get()->map(fn($p) => [
                'id' => $p->id,
                'title' => $p->title,
                'description' => $p->description,
                'image' => $p->image,
                'tools' => $p->tools,
                'is_published' => (bool) $p->is_published,
                'category' => $p->category?->name,
            ]),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Portofolio/Create', [
            'company' => Company::first(),
            'categories' => Category::where('type', 'portofolio')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'nullable|string',
            'tools' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('portofolio', 'public');
        }

        Portofolio::create($validated);

        return redirect()->route('portofolio.index')->with('success', '✅ Portofolio created successfully!');
    }

    public function edit(Portofolio $portofolio)
    {
        return Inertia::render('Admin/Portofolio/Edit', [
            'company' => Company::first(),
            'categories' => Category::where('type', 'portofolio')->get(),
            'portofolio' => $portofolio,
        ]);
    }

    public function update(Request $request, Portofolio $portofolio)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'nullable|string',
            'tools' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:5120',
        ]);

        // Jika user upload gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($portofolio->image && Storage::disk('public')->exists($portofolio->image)) {
                Storage::disk('public')->delete($portofolio->image);
            }

            // Simpan gambar baru
            $validated['image'] = $request->file('image')->store('portofolio', 'public');
        }

        $portofolio->update($validated);

        return redirect()->route('portofolio.index')->with('success', '✅ Portofolio updated successfully!');
    }

    public function togglePublish(Request $request, Portofolio $portofolio)
    {
        $request->validate([
            'is_published' => 'required|boolean',
        ]);

        $portofolio->update([
            'is_published' => $request->is_published,
        ]);

        // ✅ Tentukan pesan dinamis
        $message = $request->is_published
            ? "✅ {$portofolio->title} berhasil di-publish!"
            : "⚙️ {$portofolio->title} diubah menjadi private.";

        return back()
            ->with('success', $message);
    }

    public function destroy(Portofolio $portofolio)
    {
        // Hapus gambar dari storage jika ada
        if ($portofolio->image && Storage::disk('public')->exists($portofolio->image)) {
            Storage::disk('public')->delete($portofolio->image);
        }

        // Hapus data portofolio dari database
        $portofolio->delete();

        // Redirect balik ke daftar portofolio dengan notifikasi sukses
        return redirect()->route('portofolio.index')->with('success', '🗑️ Portofolio deleted successfully!');
    }
}
