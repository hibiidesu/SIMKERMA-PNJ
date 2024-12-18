<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Unit;
use App\Models\prodi;
use App\Models\Kerjasama;
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

            if ($data->jurusan) {
                $jurusanIds = explode(',', $data->jurusan);
                $prodiIds = explode(',', $data->prodi);

                foreach ($jurusanIds as $id) {
                    $jurusan[] = Unit::find($id)->name;
                }

                foreach ($prodiIds as $id) {
                    $prodi[] = Prodi::find($id)->name;
                }
            }

            $jurusanString = implode(', ', $jurusan);
            $prodiString = implode(', ', $prodi);

            $arr[] = [
                $index + 1,
                $data->mitra,
                $data->kerjasama,
                $data->nomor,
                $data->kegiatan,
                $data->sifat,
                $jurusanString,
                $prodiString,
                $data->jenis_kerjasama->jenis_kerjasama,
                $data->tanggal_mulai,
                $data->tanggal_selesai,
                $data->file ? asset('surat_kerjasama/' . $data->file) : "",
            ];
        }

        return $arr;
    }
    public function headings(): array
    {
        return ["No.",  "Nama Mitra", "Judul Kerjasama", "No SK/MOU", "Kegiatan", "Sifat", "Jurusan", "Program Studi", "Jenis Kerjasama", "Tanggal Mulai", "Tanggal Selesai", "Bukti"];
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
