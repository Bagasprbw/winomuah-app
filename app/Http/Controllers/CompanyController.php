<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    public function index()
    {
        $company = Company::first(); // ambil data company pertama
        return Inertia::render('Admin/Company/Index', [
            'company' => $company,
        ]);
    }

    public function update(Request $request)
    {
        $company = Company::first() ?? new Company();

        $validated = $request->validate([
            'company_name' => 'required|string|max:150',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'about' => 'nullable|string',
            'instagram' => 'nullable|string|max:100',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png|max:9216',
            'banner' => 'nullable|image|mimes:jpeg,jpg,png|max:9216',
        ]);

        //  logo
        if ($request->hasFile('logo')) {
            if ($company->logo && Storage::disk('public')->exists($company->logo)) {
                Storage::disk('public')->delete($company->logo);
            }
            $validated['logo'] = $request->file('logo')->store('company', 'public');
        } else {
            unset($validated['logo']);
        }

        //  banner
        if ($request->hasFile('banner')) {
            if ($company->banner && Storage::disk('public')->exists($company->banner)) {
                Storage::disk('public')->delete($company->banner);
            }
            $validated['banner'] = $request->file('banner')->store('company', 'public');
        } else {
            unset($validated['banner']);
        }

        $company->fill($validated);
        $company->save();

        return redirect()->route('company.index')->with('success', 'Data perusahaan berhasil diperbarui!');
    }
}
