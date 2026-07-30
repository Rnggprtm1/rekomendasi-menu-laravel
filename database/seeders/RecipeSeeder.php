<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Recipe;
use Illuminate\Support\Facades\File;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Recipe::truncate(); // Clear existing recipes
        
        $json = File::get(base_path('database/data_recipes.json'));
        $recipes = json_decode($json, true);
        
        foreach ($recipes as $recipe) {
            Recipe::create($recipe);
        }
    }
}
