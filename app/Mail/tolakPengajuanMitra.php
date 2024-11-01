<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Kerjasama;

class tolakPengajuanMitra extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $kerjasama;
    public $catatan;
    public function __construct($kerjasama,$catatan)
    {
        $this->kerjasama = $kerjasama;
        $this->catatan = $catatan;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Tolak Pengajuan Kerjasama')
                    ->markdown('mails.markdown.tolakPengajuanMitra')
                    ->with(['kerjasama', $this->kerjasama, 'catatan', $this->catatan]);
    }
}
