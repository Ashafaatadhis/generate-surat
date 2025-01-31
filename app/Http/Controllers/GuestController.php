<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\TemplateLetter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpWord\TemplateProcessor;

class GuestController extends Controller
{
    // Menampilkan halaman input untuk guest
    public function index($unique_code_link)
    {
        $link = Link::where('unique_kode_link', $unique_code_link)->first();

        // Jika link tidak ditemukan atau kuota sudah habis
        if (!$link || $link->kuota <= 0) {
            return response()->view('guest.invalid_link', [], 404); // Tampilkan halaman error
        }
        // Ambil semua template yang ada di database
        $templates = TemplateLetter::all();
        $unique_code  = $unique_code_link;

        return view('guest.index', compact('templates', 'unique_code'));
    }

    // Memproses data yang diinput oleh guest
    public function store(Request $request)
    {

        $request->validate([
            'template_id' => 'required|exists:template_letters,id', // Validasi template harus ada
            'unique_kode_link' => 'required|exists:links,unique_kode_link', // Validasi kode unik harus ada
        ]);



        // Ambil link berdasarkan kode unik
        $link = Link::where('unique_kode_link', $request->unique_kode_link)->first();

        // Periksa apakah link valid dan kuota masih tersedia
        if (!$link || $link->kuota <= 0) {
            return redirect()->back()->with('error', 'Invalid link or quota exhausted.');
        }

        $data = $request->all();

        $templateLetter = TemplateLetter::find($request->template_id);

        $templateProcessor = new TemplateProcessor(storage_path("app/public/" . $templateLetter->content));

        // Mengganti variabel dengan data
        foreach ($data as $key => $value) {
            $templateProcessor->setValue($key, $value);
        }

        // Menyimpan hasil penggantian ke file baru
        $outputPath = storage_path('app/temp/' . time() . '_processed.docx');

        $templateProcessor->saveAs($outputPath);

        // Kurangi kuota setelah dokumen berhasil dihasilkan
        $link->decrement('kuota');
        $templateLetter->increment("count_use");
        // Unduh file DOCX
        return response()->download($outputPath)->deleteFileAfterSend();

        // Kembalikan pesan sukses
        // return redirect()->back()->with('success', 'Data has been successfully submitted.');
    }
}
