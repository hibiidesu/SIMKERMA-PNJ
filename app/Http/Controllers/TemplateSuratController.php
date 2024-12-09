<?php

namespace App\Http\Controllers;

use App\Models\templateSurat;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TemplateSuratController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = templateSurat::all();
        return view('surat.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('surat.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'nama_surat' => 'required',
            'template_surat' => 'required|file|mimes:pdf,docx|max:10240', // Validate for PDF or DOCX, max size 10MB
        ]);


        $originalName = $request->file('template_surat')->getClientOriginalName();


        $filePath = time() . '_' . $originalName;


        $fileContents = file_get_contents($request->file('template_surat')->getRealPath());
        Storage::disk('template_surat')->put($filePath, $fileContents);


        templateSurat::create([
            'nama_surat' => $request->nama_surat,
            'template_surat' => $filePath,
        ]);


        return redirect('/admin/template')->with('success', 'Data berhasil ditambahkan');
    }

    public function download($id)
    {

        $template = templateSurat::find($id);

        if (!$template) {

            return redirect('/admin/template')->with('error', 'File tidak ditemukan.');
        }

        // Get the file path
        $filePath = $template->template_surat;


        if (Storage::disk('template_surat')->exists($filePath)) {

            return Storage::disk('template_surat')->download($filePath, $template->template_surat);
        } else {

            return redirect('/admin/template')->with('error', 'File tidak ditemukan di storage.');
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\templateSurat  $templateSurat
     * @return \Illuminate\Http\Response
     */
    public function show(templateSurat $templateSurat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\templateSurat  $templateSurat
     * @return \Illuminate\Http\Response
     */
    public function edit(templateSurat $templateSurat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\templateSurat  $templateSurat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, templateSurat $templateSurat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\templateSurat  $templateSurat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $templateSurat = templateSurat::find($id);
        if (!$templateSurat) {
            return redirect('/admin/template')->with('error', 'Template tidak ditemukan.');
        }
        $filePath = $templateSurat->template_surat;
        if (Storage::disk('template_surat')->exists($filePath)) {

            Storage::disk('template_surat')->delete($filePath);
        }
        $templateSurat->delete();
        return redirect('/admin/template')->with('success', 'Template berhasil dihapus.');
    }
}
