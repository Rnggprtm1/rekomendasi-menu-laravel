<?php

namespace App\Http\Controllers;

use App\Models\Suggestion;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SuggestionController extends Controller
{
    public function show()
    {
        return view('saran');
    }

    public function store(Request $request)
    {
        $isResep = $request->jenis === 'resep_baru';

        // Validasi dasar
        $rules = [
            'jenis'    => 'required|in:saran,resep_baru',
            'pengirim' => 'nullable|string|max:50',
        ];

        if ($isResep) {
            // Validasi lengkap untuk usulan resep
            $rules += [
                'judul'       => 'required|string|max:100',
                'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                'time'        => 'required|integer|min:1',
                'difficulty'  => 'required|in:mudah,sedang,sulit',
                'portion'     => 'required|integer|min:1',
                'ingredients' => 'required|string',
                'steps'       => 'required|array|min:1',
                'steps.*.text' => 'required|string',
            ];
        } else {
            // Validasi untuk saran biasa
            $rules += [
                'konten' => 'required|string|max:1000',
            ];
        }

        $request->validate($rules);

        if ($isResep) {
            // Proses upload gambar
            $imagePath = 'images/default.jpg';
            if ($request->hasFile('image')) {
                $file     = $request->file('image');
                $filename = Str::slug($request->judul) . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images'), $filename);
                $imagePath = 'images/' . $filename;
            }

            // Bahan: string dipisah koma → array
            $ingredients = array_map('trim', explode(',', $request->ingredients));

            // Steps: filter yang kosong
            $steps = collect($request->steps)
                ->filter(fn($s) => !empty($s['text']))
                ->map(fn($s) => ['minute' => (int)($s['minute'] ?? 0), 'text' => $s['text']])
                ->values()
                ->toArray();

            Suggestion::create([
                'pengirim'    => trim($request->pengirim) ?: 'Anonim',
                'jenis'       => 'resep_baru',
                'judul'       => $request->judul,
                'konten'      => 'Usulan resep: ' . $request->judul,
                'bahan'       => $request->ingredients,
                'image'       => $imagePath,
                'time'        => (int) $request->time,
                'difficulty'  => $request->difficulty,
                'portion'     => (int) $request->portion,
                'ingredients' => $ingredients,
                'steps'       => $steps,
                'status'      => 'baru',
            ]);
        } else {
            Suggestion::create([
                'pengirim' => trim($request->pengirim) ?: 'Anonim',
                'jenis'    => 'saran',
                'judul'    => '',
                'konten'   => $request->konten,
                'bahan'    => '',
                'status'   => 'baru',
            ]);
        }

        return redirect()->route('saran')
            ->with('success', $isResep
                ? 'Resepmu berhasil dikirim! Menunggu persetujuan Admin.'
                : 'Terima kasih! Saranmu sudah terkirim.');
    }
}
