<?php

namespace Tests\Feature;

use App\Models\Kerjasama;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class picTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_pic_login()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/login', [
            'username' => 'pic123',
            'password' => 'pic123',
        ]);
        $this->assertAuthenticated();
    }
    public function test_pic_login_failed(){
        $response = $this->post('/login', [
            'username' => 'pic123',
            'password' => 'admin',
        ]);
        // dd($response);
        $response->assertSessionHasErrors(['username' => 'These credentials do not match our records.']);
        $this->withoutExceptionHandling();
    }
    public function test_pic_see_admin_dashboard(){
        $user = User::find(4);
        $response = $this->actingAs($user, '')->get('admin/dashboard');
        $response->assertStatus(403);
        $response->assertForbidden();
    }
    public function test_pic_view_dashboard(){
        $user = User::find(4);
        $response = $this->actingAs($user, '')->get('pic/dashboard');
        $response->assertStatus(200);
        $response->assertViewIs('home');
    }
    public function test_pic_view_pengajuan_kerjasama(){
        $user = User::find(4);
        $response = $this->actingAs($user, '')->get('pic/pengajuan-kerjasama');
        $response->assertStatus(200);
        $response->assertViewIs('review.index');
    }
    public function test_pic_view_add_pengajuan_kerjasama(){
        $user = User::find(4);
        $response = $this->actingAs($user, '')->get('pic/pengajuan-kerjasama/add');
        $response->assertStatus(200);
        $response->assertViewIs('review.add');
    }
    public function test_pic_view_kerjasama(){
        $user = User::find(4);
        $response = $this->actingAs($user, '')->get('pic/kerjasama/');
        $response->assertStatus(200);
        $response->assertViewIs('kerjasama.index');
    }
    public function test_pic_store_form_pengajuan()
    {
        $paker = Factory::create();
        $user = User::find(4);
        session()->setPreviousUrl('/pic/pengajuan-kerjasama');
        $data = [
            'mitra' => $paker->sentence,
            'kerjasama' => 'pic',
            'tanggal_mulai' => Carbon::now()->format('d-m-Y'),
            'tanggal_selesai' => Carbon::now()->addYears(20)->format('d-m-Y'),
            'nomor' => '1',
            'kegiatan' => $paker->sentence,
            'sifat' => 'nasional',
            'kriteria_kemitraan_id' => $paker->randomElements(range(1, 10), 3),
            'kriteria_mitra_id' => $paker->randomElements(range(1, 10), 3),
            'jenis_kerjasama_id' => 1,
            'perjanjian' => $paker->randomElements(range(1, 4), 1),
            'jurusan' => $paker->randomElements(range(1, 12), 3),
            'pic_pnj' => 'sain',
            'alamat_perusahaan' => 'sini',
            'pic_industri' => 'aku',
            'jabatan_pic_industri' => 'sini',
            'step' => 1,
            'file' => UploadedFile::fake()->create('dokumen.pdf'),
        ];

        $response = $this->actingAs($user)->post('pic/pengajuan-kerjasama/store', $data);

        $response->assertRedirect('/pic/pengajuan-kerjasama');
        $response->assertSessionHas('success', 'Data berhasil ditambahkan dan menunggu persetujuan legal');
        $this->assertDatabaseHas('kerjasamas', [
            'mitra' => $data['mitra']
        ]);
    }

    public function test_pic_update_form_kerjasama()
{
    $paker = Factory::create();
    $user = User::find(4);
    session()->setPreviousUrl('/pic/pengajuan-kerjasama');


    $kerjasama = Kerjasama::find(4);

    $data = [
        'id' => $kerjasama->id,
        'mitra' => $paker->sentence,
        'kerjasama' => 'pic',
        'tanggal_mulai' => Carbon::now()->format('d-m-Y'),
        'tanggal_selesai' => Carbon::now()->addYears(20)->format('d-m-Y'),
        'nomor' => '1',
        'kegiatan' => $paker->sentence,
        'sifat' => 'nasional',
        'kriteria_kemitraan_id' => $paker->randomElement(range(1, 10)),
        'kriteria_mitra_id' => $paker->randomElement(range(1, 10)),
        'jenis_kerjasama_id' => 1,
        'perjanjian' => $paker->randomElement(range(1,3),1 ),
        'jurusan' => $paker->randomElement(range(1, 12)),
        'pic_pnj' => 'sain',
        'alamat_perusahaan' => 'sini',
        'pic_industri' => 'aku',
        'jabatan_pic_industri' => 'sini',
        'step' => 1,
    ];

    $response = $this->actingAs($user)
        ->post('pic/pengajuan-kerjasama/update', $data);
    $response->assertSessionHas('success', 'Data berhasil diubah');
    $this->assertDatabaseHas('kerjasamas', [
        'id' => $kerjasama->id,
        'mitra' => $data['mitra'],
        'kerjasama' => $data['kerjasama'],
        'nomor' => $data['nomor'],
        'step' => 1,
    ]);
}


}
