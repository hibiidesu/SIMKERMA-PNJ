<?php

namespace App\Http\Controllers;

use App\Models\templateSurat;
use Illuminate\Http\Request;

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
        return view('surat.index',compact('data'));
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
        'template_surat' => 'required|file|mimes:pdf,doc,docx'
    ]);

    $file = $request->file('template_surat');
    $nama = $request->nama_surat; // Get the actual value of 'nama_surat'

    // Store the file in the 'template_surat' disk with the name $nama
    $move = Storage::disk('template_surat')->put($nama, file_get_contents($file));
    
    if ($move) {
        $templateSurat = templateSurat::create([
            'nama_surat' => $request->nama_surat,
            'template_surat' => $nama // Use the $nama variable
        ]);
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
    public function destroy(templateSurat $templateSurat)
    {
        //
    }
}
