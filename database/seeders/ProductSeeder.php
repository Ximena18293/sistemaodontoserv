<?php

namespace Database\Seeders;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Product One',
            'description' => 'This is the description for Product One.',
            'category' => 'Category One',
            'price' => 19.99,
            'stock' => 100,
            'status' => 1, // Activo
            'user_id' => 1, // Valor por defecto
        ]);

        Product::create([
            'name' => 'Product Two',
            'description' => 'This is the description for Product Two.',
            'category' => 'Category Two',
            'price' => 29.99,
            'stock' => 50,
            'status' => 1, // Activo
            'user_id' => 2, // Valor por defecto
        ]);

        Product::create([
            'name' => 'Product Three',
            'description' => 'This is the description for Product Three.',
            'category' => 'Category Three',
            'price' => 39.99,
            'stock' => 75,
            'status' => 1, // Activo
            'user_id' => 3, // Valor por defecto
        ]);
    }
}
