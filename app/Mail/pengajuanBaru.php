<?php

namespace App\Mail;

use App\Models\Kerjasama;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class pengajuanBaru extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $kerjasama;
    public $path;

    public function __construct($kerjasama, $path)
    {
        $this->kerjasama = $kerjasama;
        $this->path = $path;
    }

    public function build()
    {
        return $this->subject('Ada Pengajuan Kerjasama Baru Menunggu Untuk Di review')
                    ->markdown('mails.markdown.pengajuanBaru')
                    ->with([
                        'kerjasama' => $this->kerjasama,
                        'path' => $this->path,
                    ]);
    }
}
