<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $company = Company::first(); // ambil 1 data company (karena cuma satu)

        return Inertia::render('Admin/Dashboard', [
            'company' => $company,
        ]);
    }
}
