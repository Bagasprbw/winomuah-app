<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;
use App\Models\Category;
use App\Models\Product;
use App\Models\Portfolio;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1️⃣ User (1 row)
        $user = User::create([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
        ]);

        // 2️⃣ Company (1 row)
        $company = Company::create([
            'company_name' => 'Winomuah',
            'about' => 'Kami adalah studio kreatif yang fokus pada produk ilustrasi, merchandise, dan karya digital.',
            'address' => 'Jl. Merdeka No. 45, Jakarta',
            'phone' => '+628123456789',
            'instagram' => '@studiokaryanusantara',
            'logo' => 'company/logo.png',
            'banner' => 'company/banner.png',
        ]);

        // 3️⃣ Categories (6 rows)
        $categories = [
            ['name' => 'Komik', 'type' => 'portfolio'],
            ['name' => 'Ilustrasi Digital', 'type' => 'portfolio'],
            ['name' => 'Keychain', 'type' => 'product'],
            ['name' => 'Aksesori', 'type' => 'product'],
            ['name' => 'Poster', 'type' => 'product'],
            ['name' => 'Sticker', 'type' => 'product'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // Ambil beberapa kategori
        $catProduct = Category::where('type', 'product')->first();
        $catPortfolio = Category::where('type', 'portfolio')->first();

        // 4️⃣ Products (2 rows)
        Product::create([
            'category_id' => $catProduct->id,
            'name' => 'Keychain Acrylic Chibi',
            'description' => 'Keychain karakter chibi lucu berbahan acrylic tebal, tahan lama, dan elegan.',
            'image' => 'products/keychain1.jpg',
            'price' => 35000,
            'is_published' => true,
        ]);

        Product::create([
            'category_id' => $catProduct->id,
            'name' => 'Poster Anime Limited Edition',
            'description' => 'Poster karakter anime eksklusif dicetak di kertas art paper 260 gsm ukuran A3.',
            'image' => 'products/poster1.jpg',
            'price' => 75000,
            'is_published' => true,
        ]);

        // 5️⃣ Portfolio (2 rows)
        Portfolio::create([
            'category_id' => $catPortfolio->id,
            'title' => 'Ilustrasi Karakter Fantasy',
            'tools' => 'Clip Studio Paint, Wacom Tablet',
            'description' => 'Karya digital dengan tema dunia fantasy, menampilkan karakter penyihir muda.',
            'image' => 'portfolio/fantasy1.png',
        ]);

        Portfolio::create([
            'category_id' => $catPortfolio->id,
            'title' => 'Komik Pendek Slice of Life',
            'tools' => 'Medibang Paint, iPad Pro',
            'description' => 'Komik pendek bergenre slice of life tentang kehidupan sehari-hari ilustrator.',
            'image' => 'portfolio/comic1.png',
        ]);

        echo "✅ Dummy data berhasil ditambahkan!\n";
    }
}
