<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Dummy Data for Users (Password: password)
        User::create([
            'username' => 'admin',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
        User::create([
            'username' => 'staff',
            'password' => bcrypt('password'),
            'role' => 'staff',
        ]);

        // Dummy Data for Categories
        $categories = ['Elektronik', 'Kendaraan', 'Peralatan Keamanan', 'Kelistrikan', 'Material Bangunan'];
        foreach ($categories as $category) {
            \App\Models\Category::create(['name' => $category]);
        }

        // Dummy Data for Suppliers
        $supplier1 = \App\Models\Supplier::create(['name' => 'PT Maju Bersama', 'contact_info' => '08123456789']);
        $supplier2 = \App\Models\Supplier::create(['name' => 'CV Sumber Rejeki', 'contact_info' => '08198765432']);

        // Remove all previous products
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Models\Product::truncate();
        \Illuminate\Support\Facades\DB::table('product_supplier')->truncate(); // to be safe
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Fetch categories dynamically
        $getCatId = function($name) {
            $cat = \App\Models\Category::where('name', 'like', "%$name%")->first();
            return $cat ? $cat->id : \App\Models\Category::first()->id;
        };

        $productsData = [
            ['sku' => 'PRD-001', 'name' => 'laptop acer nitro v15 rtx3050', 'category' => 'Elektronik', 'price' => 12000000.00, 'stock' => 10, 'img' => 'prod_6ab53624b79b0.jpg'],
            ['sku' => 'PRD-002', 'name' => 'Honda Vario 125 gen2', 'category' => 'Kendaraan', 'price' => 32000000.00, 'stock' => 15, 'img' => null],
            ['sku' => 'PRD-003', 'name' => 'Helm Proyek Kuning', 'category' => 'Peralatan Keamanan', 'price' => 150000.00, 'stock' => 50, 'img' => 'prod_6ab53465269e2.jpg'],
            ['sku' => 'PRD-004', 'name' => 'Sepatu Safety Hitam', 'category' => 'Peralatan Keamanan', 'price' => 350000.00, 'stock' => 0, 'img' => 'prod_6ab5348987b43.png'],
            ['sku' => 'PRD-005', 'name' => 'Sarung Tangan Karet', 'category' => 'Peralatan Keamanan', 'price' => 25000.00, 'stock' => 100, 'img' => 'prod_6ab534c721e99.jpg'],
            ['sku' => 'PRD-006', 'name' => 'Kabel Tembaga 100m', 'category' => 'Kelistrikan', 'price' => 450000.00, 'stock' => 20, 'img' => 'prod_6ab534ebdefcf.jpg'],
            ['sku' => 'PRD-007', 'name' => 'Lampu LED 18W', 'category' => 'Kelistrikan', 'price' => 60000.00, 'stock' => 40, 'img' => 'prod_6ab5351fd9dab.jpg'],
            ['sku' => 'PRD-008', 'name' => 'Stop Kontak 4 Lubang', 'category' => 'Kelistrikan', 'price' => 35000.00, 'stock' => 0, 'img' => 'prod_6ab5353e8b266.jpg'],
            ['sku' => 'PRD-009', 'name' => 'Besi Beton 10mm', 'category' => 'Material Bangunan', 'price' => 75000.00, 'stock' => 200, 'img' => 'prod_6ab535874ee14.webp'],
            ['sku' => 'PRD-010', 'name' => 'Semen Portland 50kg', 'category' => 'Material Bangunan', 'price' => 65000.00, 'stock' => 150, 'img' => 'prod_6ab535ab9dd8a.jpg'],
            ['sku' => 'PRD-011', 'name' => 'Cat Tembok Putih 5kg', 'category' => 'Material Bangunan', 'price' => 120000.00, 'stock' => 0, 'img' => 'prod_6ab535d70dc34.webp'],
        ];

        foreach ($productsData as $data) {
            $p = \App\Models\Product::create([
                'sku' => $data['sku'],
                'name' => $data['name'],
                'category_id' => $getCatId($data['category']),
                'price' => $data['price'],
                'stock' => $data['stock'],
                'image_path' => $data['img'] ? 'products/' . $data['img'] : null,
            ]);
            // attach random supplier just so it has one
            $p->suppliers()->attach(rand(1, 2));
        }
    }
}
