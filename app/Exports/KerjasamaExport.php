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
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

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
    $arr = array();

    $kerjasama = Kerjasama::where('step', 7)->orderBy('id', 'desc');
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
                $kerjasama = $kerjasama->whereDate('tanggal_selesai', '>=', Carbon::now())
                    ->whereMonth('tanggal_selesai', '>=', Carbon::now()->month)
                    ->whereMonth('tanggal_selesai', '<=', Carbon::now()->month + 3)
                    ->whereYear('tanggal_selesai', date('Y'));
            } else if ($this->request['date'] == '4') {
                $kerjasama = $kerjasama->whereDate('tanggal_selesai', '<', Carbon::now());
            }
        }
    }

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
                $unit = Unit::find($id);
                if ($unit) {
                    $jurusan[] = $unit->name;
                }
            }

            foreach ($prodiIds as $id) {
                $prodiModel = prodi::find($id);
                if ($prodiModel) {
                    $prodi[] = $prodiModel->name;
                }
            }

            foreach ($k_mitraId as $id) {
                $id = trim($id);
                if (is_numeric($id)) {
                    $kriteriaMitra = kriteria_mitra::find($id);
                    if ($kriteriaMitra) {
                        $k_mitra[] = $kriteriaMitra->kriteria_mitra;
                    }
                }
            }

            foreach ($k_kemitraanId as $id) {
                $id = trim($id);
                if (is_numeric($id)) {
                    $kriteriaKemitraan = kriteria_kemitraan::find($id);
                    if ($kriteriaKemitraan) {
                        $k_kemitraan[] = $kriteriaKemitraan->kriteria_kemitraan;
                    }
                }
            }
        }

        $jurusanString = implode(', '.chr(10), $jurusan);
        $prodiString = implode(', '.chr(10), $prodi);
        $kMitraString = implode(', '.chr(10), $k_mitra);
        $kKemitraanString = implode(', '.chr(10), $k_kemitraan);

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
        AfterSheet::class => function(AfterSheet $event) {
            foreach ($event->sheet->getColumnIterator('J') as $row) {
                foreach ($row->getCellIterator() as $cell) {
                    if (str_contains($cell->getValue(), '://')) {
                        $cell->setHyperlink(new Hyperlink($cell->getValue(), 'Click here to access file'));
                        $event->sheet->getStyle($cell->getCoordinate())->applyFromArray([
                            'font' => [
                                'color' => ['rgb' => '0000FF'],
                                'underline' => 'single'
                            ]
                        ]);
                    }
                }
            }

            $lastColumn = $event->sheet->getHighestColumn();
            $headerRange = 'A1:' . $lastColumn . '1';
            $event->sheet->getDelegate()->getStyle($headerRange)->applyFromArray([
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                    'size' => 13,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4472C4'],
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ]);

            $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(30);

            $dataRange = 'A2:' . $lastColumn . $event->sheet->getHighestRow();
            $event->sheet->getDelegate()->getStyle($dataRange)->applyFromArray([
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'CCCCCC'],
                    ],
                ],
            ]);

            $wrapColumns = ['D', 'E', 'I', 'J'];
            foreach ($wrapColumns as $column) {
                $columnRange = $column . '2:' . $column . $event->sheet->getHighestRow();
                $event->sheet->getDelegate()->getStyle($columnRange)->getAlignment()->setWrapText(true);
            }

            for ($i = 2; $i <= $event->sheet->getHighestRow(); $i++) {
                $event->sheet->getDelegate()->getRowDimension($i)->setRowHeight(-1);
            }

            foreach (range('A', $lastColumn) as $column) {
                $event->sheet->getDelegate()->getColumnDimension($column)->setAutoSize(true);
            }
        },
    ];
}
}
