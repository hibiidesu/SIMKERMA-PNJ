<?php

namespace App\Http\Controllers;

use App\Mail\pengajuanBaru;
use App\Models\Jenis_kerjasama;
use App\Models\Kerjasama;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class WebController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function chartData()
    {
        $active = Kerjasama::where('sifat', '<>', '')
            ->where('step', 7)
            ->whereDate('tanggal_selesai', '>=', Carbon::now())
            ->count();
        $inactive = Kerjasama::where('sifat', '<>', '')
            ->where('step', 7)
            ->whereDate('tanggal_selesai', '<', Carbon::now())
            ->count();

        return response()->json([
            'labels' => ['Masih Berlaku', 'Sudah Berakhir'],
            'data' => [$active, $inactive],
        ]);
    }
    public function chartBySifat(Request $request)
    {
        switch ($request->filter) {
            case 0:
                $sql = Kerjasama::selectRaw('sifat as label, count(*) as data')
                    ->where('step', 7)
                    ->where('sifat', '<>', '')
                    ->groupBy('sifat')
                    ->get();
                break;
            case 1:
                $sql = Kerjasama::selectRaw('sifat as label, count(*) as data')
                    ->where('step', 7)
                    ->where('sifat', '<>', '')
                    ->whereDate('tanggal_selesai', '>=', Carbon::now())
                    ->groupBy('sifat')
                    ->get();
                break;
            case 2:
                $sql = Kerjasama::selectRaw('sifat as label, count(*) as data')
                    ->where('step', 7)
                    ->where('sifat', '<>', '')
                    ->whereDate('tanggal_selesai', '<', Carbon::now())
                    ->groupBy('sifat')
                    ->get();
                break;
        }
        return response()->json([
            'result' => $sql,
        ]);
    }
    public function chartByMemorandum(Request $request)
    {
        switch ($request->filter) {
            case 0:
                $sql = Kerjasama::selectRaw('pks.id as pks_id, pks.pks as label, count(*) as data')
                    ->where('step', 7)
                    ->join('pks', DB::raw("CAST(pks.id as varchar)"), '=', 'kerjasamas.pks')
                    ->groupBy('label', 'pks_id')
                    ->get();
                $more = Kerjasama::selectRaw('kerjasamas.pks as label, count(*) as data')
                    ->where('pks', 'like', '%,%')
                    ->groupBy('pks')
                    ->get();
                break;
            case 1:
                $sql = Kerjasama::selectRaw('pks.id as pks_id, pks.pks as label, count(*) as data')
                    ->where('step', 7)
                    ->join('pks', DB::raw("CAST(pks.id as varchar)"), '=', 'kerjasamas.pks')
                    ->whereDate('tanggal_selesai', '>=', Carbon::now())
                    ->groupBy('label', 'pks_id')
                    ->get();
                $more = Kerjasama::selectRaw('kerjasamas.pks as label, count(*) as data')
                    ->whereDate('tanggal_selesai', '>=', Carbon::now())
                    ->where('pks', 'like', '%,%')
                    ->groupBy('pks')
                    ->get();
                break;
            case 2:
                $sql = Kerjasama::selectRaw('pks.id as pks_id, pks.pks as label, count(*) as data')
                    ->where('step', 7)
                    ->join('pks', DB::raw("CAST(pks.id as varchar)"), '=', 'kerjasamas.pks')
                    ->whereDate('tanggal_selesai', '<', Carbon::now())
                    ->groupBy('label', 'pks_id')
                    ->get();
                $more = Kerjasama::selectRaw('kerjasamas.pks as label, count(*) as data')
                    ->where('step', 7)
                    ->where('pks', 'like', '%,%')
                    ->whereDate('tanggal_selesai', '<', Carbon::now())
                    ->groupBy('pks')
                    ->get();
                break;
        }
        return response()->json([
            'more' => $more,
            'result' => $sql,
        ]);
    }
    public function chartByUnit(Request $request)
    {
        switch ($request->filter) {
            case 0:
                $sql = Kerjasama::selectRaw('unit.id as unit_id, unit.name as label, count(*) as data')
                    ->where('step', 7)
                    ->join('unit', DB::raw("CAST(unit.id as varchar)"), '=', 'kerjasamas.jurusan')
                    ->where('jurusan', '<>', '')
                    ->groupBy('label', 'unit_id')
                    ->get();
                $more = Kerjasama::selectRaw('kerjasamas.jurusan as label, count(*) as data')
                    ->where('step', 7)
                    ->where('jurusan', 'like', '%,%')
                    ->groupBy('jurusan')
                    ->get();
                break;
            case 1:
                $sql = Kerjasama::selectRaw('unit.id as unit_id, unit.name as label, count(*) as data')
                    ->where('step', 7)
                    ->join('unit', DB::raw("CAST(unit.id as varchar)"), '=', 'kerjasamas.jurusan')
                    ->where('jurusan', '<>', '')
                    ->whereDate('tanggal_selesai', '>=', Carbon::now())
                    ->groupBy('label', 'unit_id')
                    ->get();
                $more = Kerjasama::selectRaw('kerjasamas.jurusan as label, count(*) as data')
                    ->where('step', 7)
                    ->whereDate('tanggal_selesai', '>=', Carbon::now())
                    ->where('jurusan', 'like', '%,%')
                    ->groupBy('jurusan')
                    ->get();
                break;
            case 2:
                $sql = Kerjasama::selectRaw('unit.id as unit_id, unit.name as label, count(*) as data')
                    ->where('step', 7)
                    ->join('unit', DB::raw("CAST(unit.id as varchar)"), '=', 'kerjasamas.jurusan')
                    ->whereDate('tanggal_selesai', '<', Carbon::now())
                    ->where('jurusan', '<>', '')
                    ->groupBy('label', 'unit_id')
                    ->get();
                $more = Kerjasama::selectRaw('kerjasamas.jurusan as label, count(*) as data')
                    ->where('step', 7)
                    ->where('jurusan', 'like', '%,%')
                    ->whereDate('tanggal_selesai', '<', Carbon::now())
                    ->groupBy('jurusan')
                    ->get();
                break;
        }
        return response()->json([
            'more' => $more,
            'result' => $sql,
        ]);
    }
    public function chartByJenisKerjasama(Request $request)
    {
        $sqlLabels = Kerjasama::select('jenis_kerjasama_id', 'jenis_kerjasama as label')
            ->where('step', 7)
            ->leftJoin('jenis_kerjasamas', 'jenis_kerjasamas.id', '=', 'kerjasamas.jenis_kerjasama_id')
            ->groupBy('jenis_kerjasama_id', 'label')
            ->orderBy('label', 'asc')
            ->get();
        switch ($request->filter) {
            case 0:
                $sql = Kerjasama::selectRaw('jenis_kerjasama_id, count(*) as data, jenis_kerjasama as label')
                    ->where('step', 7)
                    ->leftJoin('jenis_kerjasamas', 'jenis_kerjasamas.id', '=', 'kerjasamas.jenis_kerjasama_id')
                    ->groupBy('jenis_kerjasama_id', 'label')
                    ->orderBy('label', 'asc')
                    ->get();
                break;
            case 1:
                $sql = Kerjasama::selectRaw('jenis_kerjasama_id, count(*) as data, jenis_kerjasama as label')
                    ->where('step', 7)
                    ->leftJoin('jenis_kerjasamas', 'jenis_kerjasamas.id', '=', 'kerjasamas.jenis_kerjasama_id')
                    ->whereDate('tanggal_selesai', '>=', Carbon::now())
                    ->groupBy('jenis_kerjasama_id', 'label')
                    ->orderBy('label', 'asc')
                    ->get();
                break;
            case 2:
                $sql = Kerjasama::selectRaw('jenis_kerjasama_id, count(*) as data, jenis_kerjasama as label')
                    ->where('step', 7)
                    ->leftJoin('jenis_kerjasamas', 'jenis_kerjasamas.id', '=', 'kerjasamas.jenis_kerjasama_id')
                    ->whereDate('tanggal_selesai', '<', Carbon::now())
                    ->groupBy('jenis_kerjasama_id', 'label')
                    ->orderBy('label', 'asc')
                    ->get();
                break;
        }
        return response()->json([
            'labels' => $sqlLabels,
            'result' => $sql,
        ]);
    }
    public function chartBySifatYear()
    {
        $sql = Kerjasama::selectRaw('sifat as label, count(*) as data, extract(year from tanggal_mulai) as year')
            ->where('step', 7)
            ->where('sifat', '<>', '')
            ->groupBy('year', 'label')
            ->orderBy('year', 'asc')
            ->get();
        $sqlYear = Kerjasama::selectRaw('count(*) as data, extract(year from tanggal_mulai) as year')
            ->where('step', 7)
            ->where('sifat', '<>', '')
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get();
        return response()->json([
            'labels' => $sqlYear,
            'result' => $sql,
        ]);
    }
    public function chartByJenisYear()
    {
        $sql = Kerjasama::selectRaw('count(*) as data, extract(year from tanggal_mulai) as year, jenis_kerjasama as label')
            ->where('step', 7)
            ->leftJoin('jenis_kerjasamas', 'jenis_kerjasamas.id', '=', 'kerjasamas.jenis_kerjasama_id')
            ->groupBy('year', 'label')
            ->orderBy('year', 'asc')
            ->get();
        $sqlYear = Kerjasama::selectRaw('count(*) as data, extract(year from tanggal_mulai) as year')
            ->where('step', 7)
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get();

        return response()->json([
            'labels' => $sqlYear,
            'result' => $sql,
        ]);
    }
}
