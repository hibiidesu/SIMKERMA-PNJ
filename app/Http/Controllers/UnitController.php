<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('unit/index', [
            'data' => Unit::orderBy('id', 'desc')->get()
        ]);
    }

    public function create()
    {
        return view('unit/add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:unit',
        ]);
        $insert = Unit::create([
            'name' => $request->name,
        ]);
        if ($insert) {
            return redirect('/admin/unit')->with('success', 'Data berhasil ditambahkan');
        } else {
            return redirect('/admin/unit')->with('error', 'Data gagal ditambahkan');
        }
    }

    public function show(Unit $Unit)
    {
        //
    }

    public function edit(Unit $Unit, $id)
    {
        return view('unit/edit', [
            'data' => Unit::findOrFail($id),
        ]);
    }

    public function update(Request $request, Unit $Unit)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required|unique:unit',
        ]);
        $update = Unit::findOrFail($request->id)->update([
            'name' => $request->name,
        ]);
        if ($update) {
            return redirect('/admin/unit')->with('success', 'Data berhasil diupdate');
        } else {
            return redirect('/admin/unit')->with('error', 'Data gagal diupdate');
        }
        dd($request->input());
    }
}
