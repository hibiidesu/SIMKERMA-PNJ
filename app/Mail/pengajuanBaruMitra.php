<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Kerjasama;

class pengajuanBaruMitra extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $kerjasama;
    public function __construct($kerjasama)
    {
        $this->kerjasama = $kerjasama;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Pengajuan kerjasama berhasil dibuat' )
                    ->markdown('mails.markdown.pengajuanBaruMitra')
                    ->with(['kerjasama', $this->kerjasama]);
    }
}
