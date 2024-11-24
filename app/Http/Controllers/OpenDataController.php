<?php

namespace App\Http\Controllers;

use App\Models\Kerjasama;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OpenDataController extends Controller
{

public function getKerjasamaStats()
    {
        $totalKerjasama = 1000;
        $kerjasamaBerlangsung = 500;
        $kerjasamaSelesai = 500;
        // $now = Carbon::now();

        // $totalKerjasama = Kerjasama::count();

        // $kerjasamaBerlangsung = Kerjasama::where('tanggal_mulai', '<=', $now)
        //     ->where('tanggal_selesai', '>=', $now)
        //     ->count();

        // $kerjasamaSelesai = Kerjasama::where('tanggal_selesai', '<', $now)
        //     ->count();



        return response()->json([
            'total' => $totalKerjasama,
            'berlangsung' => $kerjasamaBerlangsung,
            'selesai' => $kerjasamaSelesai,
        ]);
    }
}
