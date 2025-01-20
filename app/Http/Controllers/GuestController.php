<?php

namespace App\Http\Controllers;

use App\Models\TemplateLetter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpWord\TemplateProcessor;

class GuestController extends Controller
{
    // Menampilkan halaman input untuk guest
    public function index()
    {
        // Ambil semua template yang ada di database
        $templates = TemplateLetter::all();

        return view('guest.index', compact('templates'));
    }

    // Memproses data yang diinput oleh guest
    public function store(Request $request)
    {
        $request->validate([
            'template_id' => 'required|exists:template_letters,id', // Validasi template harus ada
        ]);


        $data = $request->all();

        $templateLetter = TemplateLetter::find($request->template_id);

        $templateProcessor = new TemplateProcessor(storage_path("app/public/" . $templateLetter->content));

        // Mengganti variabel dengan data

        foreach ($data as $key => $value) {

            $templateProcessor->setValue($key, $value);
        }

        // Menyimpan hasil penggantian ke file baru
        $outputPath = storage_path('app/temp/' . time() . '_processed.docx');
        // dd($templateProcessor);4

        $templateProcessor->saveAs($outputPath);

        // Hapus file DOCX setelah konversi
        // if (file_exists($outputPath)) {
        //     unlink($outputPath);
        // }
        // Unduh file PDF
        return response()->download($outputPath)->deleteFileAfterSend();

        return redirect()->back()->with('success', 'Data has been successfully submitted.');
    }
}
