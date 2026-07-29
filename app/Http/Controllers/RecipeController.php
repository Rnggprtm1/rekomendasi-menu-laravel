<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    /**
     * Halaman utama — render tampilan dengan semua data resep.
     */
    public function index()
    {
        $recipes = Recipe::orderBy('id')->get();
        return view('index', compact('recipes'));
    }

    /**
     * API: Kembalikan semua resep dalam format JSON.
     */
    public function apiIndex()
    {
        $recipes = Recipe::orderBy('id')->get();
        return response()->json($recipes);
    }

    /**
     * API: Kembalikan satu resep berdasarkan id numerik.
     */
    public function apiShow(int $id)
    {
        $recipe = Recipe::where('id', $id)->first();

        if (!$recipe) {
            return response()->json(['error' => 'Resep tidak ditemukan'], 404);
        }

        return response()->json($recipe);
    }
}
