<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use App\Models\Suggestion;

class SuggestionController extends Controller
{
    public function index()
    {
        $suggestions = Suggestion::orderBy('created_at', 'desc')->get();

        // Tandai semua saran "baru" jadi "dibaca"
        Suggestion::where('status', 'baru')->update(['status' => 'dibaca']);

        return view('admin.saran.index', compact('suggestions'));
    }

    public function destroy(string $id)
    {
        $suggestion = Suggestion::findOrFail($id);
        $suggestion->delete();

        return redirect()->route('admin.saran.index')
            ->with('success', 'Saran berhasil dihapus.');
    }

    /**
     * Setujui usulan resep: langsung salin data ke koleksi recipes.
     */
    public function approve(string $id)
    {
        $suggestion = Suggestion::findOrFail($id);

        // Ambil id terbesar lalu +1
        $lastId = Recipe::orderBy('id', 'desc')->value('id') ?? 0;

        // Buat resep baru dari data saran
        Recipe::create([
            'id'          => $lastId + 1,
            'name'        => $suggestion->judul ?: 'Resep Tanpa Nama',
            'ingredients' => $suggestion->ingredients ?? [],
            'time'        => (int) ($suggestion->time ?? 15),
            'difficulty'  => $suggestion->difficulty ?? 'mudah',
            'portion'     => (int) ($suggestion->portion ?? 1),
            'image'       => $suggestion->image ?? 'images/default.jpg',
            'steps'       => $suggestion->steps ?? [],
        ]);

        // Update status saran menjadi disetujui
        $suggestion->update(['status' => 'disetujui']);

        $nama = $suggestion->judul ?: 'Resep';
        return redirect()->route('admin.saran.index')
            ->with('success', "Usulan resep \"{$nama}\" telah disetujui dan ditambahkan ke daftar menu!");
    }

    /**
     * Konversi saran jadi resep: redirect ke form create resep dengan data pre-filled.
     * (Tetap dipertahankan sebagai fallback untuk saran lama)
     */
    public function convertToRecipe(string $id)
    {
        $suggestion = Suggestion::findOrFail($id);

        return redirect()->route('admin.resep.create', [
            'name'  => $suggestion->judul ?? $suggestion->konten,
            'bahan' => $suggestion->bahan ?? '',
        ]);
    }
}
