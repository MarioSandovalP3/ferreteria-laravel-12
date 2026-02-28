<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            // Tech Brands
            ['name' => 'Apple', 'slug' => 'apple', 'description' => 'Technology and consumer electronics'],
            ['name' => 'Samsung', 'slug' => 'samsung', 'description' => 'Electronics and technology'],
            ['name' => 'Sony', 'slug' => 'sony', 'description' => 'Electronics, gaming, and entertainment'],
            ['name' => 'LG', 'slug' => 'lg', 'description' => 'Electronics and appliances'],
            ['name' => 'HP', 'slug' => 'hp', 'description' => 'Computers and printers'],
            ['name' => 'Dell', 'slug' => 'dell', 'description' => 'Computers and technology solutions'],
            ['name' => 'Lenovo', 'slug' => 'lenovo', 'description' => 'Personal computers and electronics'],
            
            // Tools & Hardware
            ['name' => 'DeWalt', 'slug' => 'dewalt', 'description' => 'Power tools and hand tools'],
            ['name' => 'Bosch', 'slug' => 'bosch', 'description' => 'Power tools and appliances'],
            ['name' => 'Makita', 'slug' => 'makita', 'description' => 'Power tools'],
            
            // Fashion
            ['name' => 'Nike', 'slug' => 'nike', 'description' => 'Sportswear and athletic shoes'],
            ['name' => 'Adidas', 'slug' => 'adidas', 'description' => 'Sportswear and athletic shoes'],
            ['name' => 'Puma', 'slug' => 'puma', 'description' => 'Sportswear and athletic shoes'],
            
            // General
            ['name' => 'Generic', 'slug' => 'generic', 'description' => 'Generic or unbranded products'],
            ['name' => 'Other', 'slug' => 'other', 'description' => 'Other brands'],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
