<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use App\Models\Suggestion;

class DashboardController extends Controller
{
    public function index()
    {
        $totalResep    = Recipe::count();
        $totalSaran    = Suggestion::count();
        $saranBaru     = Suggestion::where('status', 'baru')->count();
        $saranResepBaru = Suggestion::where('jenis', 'resep_baru')->count();
        $resepTerbaru  = Recipe::orderBy('id', 'desc')->take(3)->get();

        return view('admin.dashboard', compact(
            'totalResep', 'totalSaran', 'saranBaru', 'saranResepBaru', 'resepTerbaru'
        ));
    }
}
