<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Origin;
use App\Models\Category;
use Faker\Factory as Faker;
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run()
    {
        // Create an instance of Faker for generating dummy data
        $faker = Faker::create();

        // Get a list of brands, origins, and categories
        $brands = Brand::all();
        $origins = Origin::all();
        $categories = Category::all();

        // Check if there are any brands, origins, and categories
        if ($brands->isEmpty() || $origins->isEmpty() || $categories->isEmpty()) {
            $this->command->error('Brands, Origins, or Categories are missing. Please seed them first!');
            return;
        }

        // Seed 10 products (you can adjust the number as needed)
        foreach (range(1, 10) as $index) {
            Product::create([
                'brand_id' => $brands->random()->id, // Get random brand
                'origin_id' => $origins->random()->id, // Get random origin
                'category_id' => $categories->random()->id, // Get random category
                'name' => $faker->word(), // Random product name
                'description' => $faker->paragraph(), // Random product description
            ]);
        }

        $this->command->info('Products seeded successfully!');
    }
}
