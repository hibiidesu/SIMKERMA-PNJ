<?php

namespace App\Http\Controllers;

use App\Models\Kerjasama;
use App\Models\Persetujuan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersetujuanController extends Controller
{
    public function index()
    {
        $persetujuanPending = Persetujuan::where('user_id', Auth::id())
            ->where('status', 'menunggu')
            ->with('kerjasama')
            ->get();

        return view('persetujuan.index', compact('persetujuanPending'));
    }

    public function show($id)
    {
        $persetujuan = Persetujuan::findOrFail($id);
        return view('persetujuan.show', compact('persetujuan'));
    }

    public function update(Request $request, $id)
    {
        $persetujuan = Persetujuan::findOrFail($id);
        $persetujuan->status = $request->status;
        $persetujuan->catatan = $request->catatan;
        $persetujuan->save();

        $kerjasama = $persetujuan->kerjasama;
        
        // Periksa apakah semua pemimpin sudah menyetujui
        $allApproved = $kerjasama->persetujuans()
            ->where('status', '!=', 'disetujui')
            ->doesntExist();

        // Hitung jumlah persetujuan yang ditolak
        $rejectedCount = $kerjasama->persetujuans()
            ->where('status', 'ditolak')
            ->count();

        if ($allApproved) {
            $kerjasama->step = 3; // Diterima
            $kerjasama->save();
        } elseif ($rejectedCount > 0) {
            $kerjasama->step = 2; // Ditolak
            $kerjasama->save();
        }
        // Jika tidak semua menyetujui dan tidak ada yang menolak, biarkan status tetap menunggu

        return redirect()->route('pemimpin.persetujuan.index')->with('success', 'Persetujuan berhasil diperbarui');
    }
}
