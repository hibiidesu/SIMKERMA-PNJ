<?php

namespace App\Mail;

use App\Models\Kerjasama;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class pengajuanBaruMitra extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $kerjasama;
    public $tanggal_mulai;
    public $tanggal_selesai;
    public $kegiatan;
    public $sifat;
    public $pic_pnj;


    public function __construct($kerjasama, $tanggal_mulai, $tanggal_selesai, $kegiatan, $sifat, $pic_pnj)
    {
        $this->kerjasama = $kerjasama;
        $this->tanggal_mulai = $tanggal_mulai;
        $this->tanggal_selesai = $tanggal_selesai;
        $this->kegiatan = $kegiatan;
        $this->sifat = $sifat;
        $this->pic_pnj = $pic_pnj;
    }

    public function build()
    {
        $tanggal_pengajuan = Carbon::now();
        return $this->subject('Pengajuan Kerjasama Baru')
                    ->markdown('mails.markdown.pengajuanBaruMitra')
                    ->with([
                        'kerjasama' => $this->kerjasama,
                        'tanggal_mulai' => $this->tanggal_mulai,
                        'tanggal_selesai' => $this->tanggal_selesai,
                        'kegiatan' => $this->kegiatan,
                        'sifat' => $this->sifat,
                        'tanggal_pengajuan' => $tanggal_pengajuan,
                        'pic_pnj' =>$this->pic_pnj,
                    ]);
    }
}
