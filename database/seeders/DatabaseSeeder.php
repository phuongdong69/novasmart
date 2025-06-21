<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            OriginSeeder::class,
            CategorySeeder::class,
            CartSeeder::class,
            ProductsTableSeeder::class,
            AttributesTableSeeder::class,
            AttributeValuesTableSeeder::class,
            ProductVariantsTableSeeder::class,
            VariantAttributeValuesTableSeeder::class,
            ThumbnailsTableSeeder::class,
        ]);
    }
}
