<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = [
            [
                'id' => 1,
                'title' => 'Pochita Keychain',
                'image' => asset('assets/Featured-products1.png'),
                'price' => 'Rp 8.000',
                'desc' => 'Made with high-quality material, this keychain perfectly captures Pochita’s adorable look.',
                'material' => 'Acrylic',
                'category' => 'Accessories',
                'images' => [
                    asset('assets/Featured-products1.png'),
                    asset('assets/Featured-products1.png'),
                ],
            ],
            [
                'id' => 2,
                'title' => 'Owl Crochet Keychain',
                'image' => asset('assets/Featured-products2.png'),
                'price' => 'Rp 9.000',
                'desc' => 'Cute handmade owl keychain from cotton yarn.',
                'material' => 'Cotton yarn',
                'category' => 'Accessories',
                'images' => [
                    asset('assets/Featured-products2.png'),
                    asset('assets/Featured-products2.png'),
                ],
            ],
            [
                'id' => 3,
                'title' => 'Heart Brass Pendant',
                'image' => asset('assets/Featured-products3.png'),
                'price' => 'Rp 9.000',
                'desc' => 'Elegant handcrafted brass pendant in heart shape.',
                'material' => 'Brass',
                'category' => 'Jewelry',
                'images' => [
                    asset('assets/Featured-products3.png'),
                    asset('assets/Featured-products3.png'),
                ],
            ],
        ];

        return Inertia::render('Home', [
            'products' => $products,
        ]);
    }
}
