<?php

namespace App\Http\Controllers;

use App\Models\TemplateLetter;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\TemplateProcessor;

class TemplateLetterController extends Controller
{

    public function getTemplateVariables($templateId)
    {
        $templateLetter = TemplateLetter::findOrFail($templateId);
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(storage_path("app/public/" . $templateLetter->content));

        // Mendapatkan daftar variabel dalam template
        $variables = $templateProcessor->getVariables();

        return response()->json($variables);
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $templates = TemplateLetter::all();
        return view('dashboard.template_letters.index', compact('templates'));
    }

    // Menampilkan form untuk membuat template baru
    public function create()
    {
        return view('dashboard.template_letters.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'required|mimes:docx|max:10240', // Maksimal 10MB untuk file
        ]);

        // Mengambil file dan menyimpannya di folder uploads
        $file = $request->file('file');

        $uploadPath = storage_path('app/public/templates');
        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0775, true);
        }

        // Menyimpan file ke folder yang tepat
        $path = $file->move($uploadPath, time() . '_' . $file->getClientOriginalName());
        $finalPath = "templates/" . $path->getFilename();

        // Menyimpan template yang baru dibuat ke database
        TemplateLetter::create([
            'title' => $request->name,
            'content' => $finalPath,  // Simpan HTML
        ]);

        return redirect()->route('dashboard.templates.index')->with('success', 'Template created successfully');
    }
    public function edit($id)
    {
        // Mendapatkan template berdasarkan ID
        $template = TemplateLetter::findOrFail($id);

        // Menampilkan form edit dengan data template
        return view('dashboard.template_letters.edit', compact('template'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'nullable|mimes:docx|max:10240', // Maksimal 10MB untuk file
        ]);

        // Mendapatkan template berdasarkan ID
        $template = TemplateLetter::findOrFail($id);

        // Update nama template
        $template->title = $request->name;

        // Jika ada file yang diupload
        if ($request->hasFile('file')) {
            // Menghapus file lama
            if (File::exists(storage_path('app/public/' . $template->content))) {
                File::delete(storage_path('app/public/' . $template->content));
            }

            // Mengambil file yang diupload
            $file = $request->file('file');

            // Menyimpan file ke folder yang tepat
            $uploadPath = storage_path('app/public/templates');
            $path = $file->move($uploadPath, time() . '_' . $file->getClientOriginalName());
            $finalPath = "templates/" . $path->getFilename();

            // Update content dengan path file baru
            $template->content = $finalPath;
        }

        // Simpan perubahan
        $template->save();

        return redirect()->route('dashboard.templates.index')->with('success', 'Template updated successfully');
    }

    public function destroy($id)
    {
        // Mendapatkan template berdasarkan ID
        $template = TemplateLetter::findOrFail($id);

        // Menghapus file template
        if (File::exists(storage_path('app/public/' . $template->content))) {
            File::delete(storage_path('app/public/' . $template->content));
        }

        // Menghapus data template dari database
        $template->delete();

        return redirect()->route('dashboard.templates.index')->with('success', 'Template deleted successfully');
    }
}
