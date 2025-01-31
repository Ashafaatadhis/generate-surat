<?php

namespace App\Http\Controllers;

use App\Models\TemplateLetter;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Data untuk grafik populer (berdasarkan penggunaan count_use)
        $popularTemplates = TemplateLetter::orderBy('count_use', 'desc')
            ->take(5) // Ambil 5 template terpopuler
            ->get(['title', 'count_use']);

        // Data untuk grafik terbaru (berdasarkan tanggal pembuatan)
        $newestTemplates = TemplateLetter::orderBy('created_at', 'desc')
            ->take(5) // Ambil 5 template terbaru
            ->get(['title', 'count_use']);

        return view('dashboard.index', compact('popularTemplates', 'newestTemplates'));
    }
}
