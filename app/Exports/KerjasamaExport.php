<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Unit;
use App\Models\prodi;
use App\Models\Kerjasama;
use App\Models\kriteria_kemitraan;
use App\Models\kriteria_mitra;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Cell\Hyperlink;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromCollection;

class KerjasamaExport implements FromArray, WithHeadings, ShouldAutoSize, WithEvents
{

    public function __construct($request)
    {
        $this->request = $request;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function array(): array
    {
        $x = 0;
        $arr = array();
        // $kerjasama = Kerjasama::all();

        $kerjasama = Kerjasama::orderBy('id', 'desc');
        if (count($this->request) > 0) {
            if ($this->request['type'] && $this->request['type'] != 'all') {
                $kerjasama = $kerjasama->where('jenis_kerjasama_id', ($this->request['type'] - 1));
            }

            if ($this->request['sifat'] && $this->request['sifat'] != 'all') {
                $kerjasama = $kerjasama->where('sifat', $this->request['sifat']);
            }

            if ($this->request['date'] && $this->request['date'] != '1') {
                if ($this->request['date'] == '2') {
                    $kerjasama = $kerjasama->whereDate('tanggal_selesai', '>=', Carbon::now());
                } else if ($this->request['date'] == '3') {
                    $kerjasama = $kerjasama->whereDate('tanggal_selesai', '>=', Carbon::now());
                    $kerjasama = $kerjasama->whereMonth('tanggal_selesai', '>=', Carbon::now()->month);
                    $kerjasama = $kerjasama->whereMonth('tanggal_selesai', '<=', Carbon::now()->month + 3);
                    $kerjasama = $kerjasama->whereYear('tanggal_selesai', date('Y'));
                } else if ($this->request['date'] == '4') {
                    $kerjasama = $kerjasama->whereDate('tanggal_selesai', '<', Carbon::now());
                }
            }
        }
        // @foreach (explode(',', $item->jurusan) as $x)
        //     @if ($loop->index + 1 < count(explode(',', $item->jurusan))) { {
        //         $unit[$x] . ', '

        // }}
        // @else  {{
        //         $unit[$x]

        //     }}
        // @endif
        // @endforeach

        foreach ($kerjasama->get() as $index => $data) {
            $jurusan = [];
            $prodi = [];
            $k_mitra = [];
            $k_kemitraan = [];

            if ($data->jurusan) {
                $jurusanIds = explode(',', $data->jurusan);
                $prodiIds = explode(',', $data->prodi);
                $k_mitraId = explode(',', $data->kriteria_mitra_id);
                $k_kemitraanId = explode(',', $data->kriteria_kemitraan_id);

                foreach ($jurusanIds as $id) {
                    $jurusan[] = Unit::find($id)->name;
                }

                foreach ($prodiIds as $id) {
                    $prodi[] = prodi::find($id)->name;
                }
                foreach  ($k_mitraId as $id) {
                    $k_mitra[] = kriteria_mitra::find($id)->kriteria_mitra;
                }
                foreach  ($k_kemitraanId as $id) {
                    $k_kemitraan[] = kriteria_kemitraan::find($id)->kriteria_kemitraan;
                }

            }

            $jurusanString = implode(', ', $jurusan);
            $prodiString = implode(', ', $prodi);
            $kMitraString = implode(', ', $k_mitra);
            $kKemitraanString = implode(', ', $k_kemitraan);

            $arr[] = [
                $index + 1,
                $data->mitra ?? 'KOSONG',
                $data->kerjasama ?? 'KOSONG',
                $kMitraString ?? 'KOSONG',
                $kKemitraanString ?? 'KOSONG',
                $data->nomor ?? 'KOSONG',
                $data->kegiatan ?? 'KOSONG',
                $data->sifat ?? 'KOSONG',
                $jurusanString ?? 'KOSONG',
                $prodiString ?? 'KOSONG',
                $data->jenis_kerjasama->jenis_kerjasama ?? 'KOSONG',
                $data->tanggal_mulai ?? 'KOSONG',
                $data->tanggal_selesai ?? 'KOSONG',
                $data->pic_pnj ?? 'KOSONG',
                $data->pic_industri ?? 'KOSONG',
                $data->jabatan_pic_industri ?? 'KOSONG',
                $data->telp_industri ?? 'KOSONG',
                $data->email ?? 'KOSONG',
                $data->alamat_perusahaan ?? 'KOSONG',
                $data->file ? asset('surat_kerjasama/' . $data->file) : "404",
            ];
        }

        return $arr;
    }

    public function headings(): array
    {
        return [
            "No.",
            "Nama Mitra",
            "Judul Kerjasama",
            "Kriteria Mitra",
            "Kriteria Kemitraan",
            "No SK/MOU",
            "Kegiatan",
            "Sifat",
            "Jurusan",
            "Program Studi",
            "Jenis Kerjasama",
            "Tanggal Mulai",
            "Tanggal Selesai",
            "PIC PNJ",
            "PIC Industri",
            "Jabatan PIC Industri",
            "Telp PIC Industri",
            "Email PIC Industri",
            "Alamat Perusahaan",
            "Bukti"
        ];
    }
    public function styles(Worksheet $sheet)
    {
        return [
            1  => ['font' => ['bold' => true]],
            1  => ['font' => ['size' => 20]],
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                foreach ($event->sheet->getColumnIterator('J') as $row) {
                    foreach ($row->getCellIterator() as $cell) {
                        if (str_contains($cell->getValue(), '://')) {
                            $cell->setHyperlink(new Hyperlink($cell->getValue(), 'Click here to access file'));
                            // Upd: Link styling added
                            $event->sheet->getStyle($cell->getCoordinate())->applyFromArray([
                                'font' => [
                                    'color' => ['rgb' => '0000FF'],
                                    'underline' => 'single'
                                ]
                            ]);
                        }
                    }
                }
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(13);
                // $event->sheet->getDelegate()->getStyle($cellRange)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('DD4B39');
                $event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
