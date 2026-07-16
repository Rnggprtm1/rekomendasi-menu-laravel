<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::orderBy('id')->get();
        return view('admin.resep.index', compact('recipes'));
    }

    public function create(Request $request)
    {
        // Bisa pre-fill dari saran (kalau datang dari konversi saran)
        $prefill = [
            'name'  => $request->query('name', ''),
            'bahan' => $request->query('bahan', ''),
        ];
        return view('admin.resep.create', compact('prefill'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:100',
            'time'       => 'required|integer|min:1',
            'difficulty' => 'required|in:mudah,sedang,sulit',
            'portion'    => 'required|integer|min:1',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'ingredients'=> 'required|string',
            'steps'      => 'required|array|min:1',
            'steps.*.minute' => 'required|integer',
            'steps.*.text'   => 'required|string',
        ]);

        // Proses upload gambar jika ada file yang dikirim
        $imagePath = 'images/default.jpg';
        if ($request->hasFile('image')) {
            $file      = $request->file('image');
            $filename  = Str::slug($request->name) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $imagePath = 'images/' . $filename;
        }

        // Ingredients: string dipisah koma → array
        $ingredients = array_map('trim', explode(',', $request->ingredients));

        // Steps: filter yang kosong
        $steps = collect($request->steps)
            ->filter(fn($s) => !empty($s['text']))
            ->map(fn($s) => ['minute' => (int)$s['minute'], 'text' => $s['text']])
            ->values()
            ->toArray();

        // Ambil id terbesar lalu +1
        $lastId = Recipe::orderBy('id', 'desc')->value('id') ?? 0;

        Recipe::create([
            'id'          => $lastId + 1,
            'name'        => $request->name,
            'ingredients' => $ingredients,
            'time'        => (int) $request->time,
            'difficulty'  => $request->difficulty,
            'portion'     => (int) $request->portion,
            'image'       => $imagePath,
            'steps'       => $steps,
        ]);

        return redirect()->route('admin.resep.index')
            ->with('success', "Resep \"{$request->name}\" berhasil ditambahkan! ");
    }

    public function edit(int $id)
    {
        $recipe = Recipe::where('id', $id)->firstOrFail();
        return view('admin.resep.edit', compact('recipe'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'name'       => 'required|string|max:100',
            'time'       => 'required|integer|min:1',
            'difficulty' => 'required|in:mudah,sedang,sulit',
            'portion'    => 'required|integer|min:1',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'ingredients'=> 'required|string',
            'steps'      => 'required|array|min:1',
        ]);

        $recipe = Recipe::where('id', $id)->firstOrFail();

        // Proses upload gambar baru jika ada, jika tidak pakai gambar lama
        $imagePath = $recipe->image;
        if ($request->hasFile('image')) {
            $file      = $request->file('image');
            $filename  = Str::slug($request->name) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $imagePath = 'images/' . $filename;
        }

        $ingredients = array_map('trim', explode(',', $request->ingredients));

        $steps = collect($request->steps)
            ->filter(fn($s) => !empty($s['text']))
            ->map(fn($s) => ['minute' => (int)$s['minute'], 'text' => $s['text']])
            ->values()
            ->toArray();

        $recipe->update([
            'name'        => $request->name,
            'ingredients' => $ingredients,
            'time'        => (int) $request->time,
            'difficulty'  => $request->difficulty,
            'portion'     => (int) $request->portion,
            'image'       => $imagePath,
            'steps'       => $steps,
        ]);

        return redirect()->route('admin.resep.index')
            ->with('success', "Resep \"{$request->name}\" berhasil diperbarui! ");
    }

    public function destroy(int $id)
    {
        $recipe = Recipe::where('id', $id)->firstOrFail();
        $name   = $recipe->name;
        $recipe->delete();

        return redirect()->route('admin.resep.index')
            ->with('success', "Resep \"{$name}\" berhasil dihapus.");
    }
}
