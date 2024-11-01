<?php

namespace App\Console\Commands;

use App\Mail\tolakPengajuanMitra;
use App\Models\Kerjasama;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class expirePengajuan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kerjasama:expirePengajuan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mencari Pengajuan yang tidak selesai dalam waktu seminggu dan belum di setujui oleh direktur';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = Carbon::now();

        $expiredKerjasamas = Kerjasama::where('step', '<', 7)
            ->where('created_at', '<', $now->subDays(7))
            ->get();

        foreach ($expiredKerjasamas as $kerjasama) {
            $kerjasama->step = 0;
            $kerjasama-> reviewer_id = '1';
            $kerjasama ->catatan = 'Tertolak Otomatis Oleh Sistem Karena Kadaluarsa';
            $kerjasama->save();

            Mail::to($kerjasama->user->email)
                ->send(new tolakPengajuanMitra($kerjasama,$kerjasama->catatan));
        }

        $this->info('Expired Kerjasama processed and notifications sent.');
    }

}
