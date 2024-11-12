<?php

namespace Tests\Feature;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use faker\Factory as paker;
use Faker\Factory;
use Illuminate\Http\Response;

class kerjasamaTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_tracker()
    {
        $response = $this->get('/trackpengajuan');

        $response->assertStatus(200);
    }
    public function test_login()
    {
        $this->withoutExceptionHandling();
        session()->setPreviousUrl('/admin/dashboard'); // set previous url

        $response = $this->post('/login', [
            'username' => 'admin123',
            'password' => 'admin123',
        ]);
        $this->assertAuthenticated();



    }
    public function test_login_failed()
    {
        session()->setPreviousUrl('/admin/dashboard'); // set previous url

        $response = $this->post('/login', [
            'username' => 'kosong',
            'password' => 'kosong',
        ]);
        $response->assertSessionHasErrors('username');
     
    }
    public function test_dashboard()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, 'web')->get('/admin/dashboard');
        $response->assertStatus(200);
    }
    public function test_pengisian_form_pengajuan()
    {
        $paker = Factory::create();
        $user = User::find(1);
        session()->setPreviousUrl('/admin/pengajuan-kerjasama');
        $data = [
            'mitra' => 'duck',
            'kerjasama' => 'test',
            'tanggal_mulai' => Carbon::now()->format('d-m-Y'),
            'tanggal_selesai' => Carbon::now()->addYears(20)->format('d-m-Y'),
            'nomor' => '1',
            'kegiatan'=> $paker->sentence,
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

        $response = $this->actingAs($user)->post('admin/pengajuan-kerjasama/store', $data);

        $response->assertRedirect('/admin/pengajuan-kerjasama');

        $this->assertDatabaseHas('kerjasamas', [
            'mitra' => 'duck',
        ]);
    }

    public function test_pengisian_form_jenis_kerjasama()
    {
        $user = User::find(1);
        $date = Carbon::now()->format('d-m-Y H-i-s');
        $data = [
            'jenis_kerjasama' => 'kerja_testing_' . $date,
        ];
        session()->setPreviousUrl('/admin/jenis-kerjasama');

        $response = $this->actingAs($user)->post('admin/jenis-kerjasama/store', $data);
        $response->assertRedirect('/admin/jenis-kerjasama/');


    }

    public function test_pengisian_form_pks()
    {
        $user = User::find(1); // login jadi admin

        $data = [
            'pks' => 'testing_pks_' . Carbon::now()->format('d-m-Y H-i-s'),
        ];
        session()->setPreviousUrl('/admin/perjanjian-kerjasama');
        $response = $this->followingRedirects()->actingAs($user, '')->post('admin/perjanjian-kerjasama/store', $data);
        $response->assertStatus(200);
    }
    public function test_pengisian_form_jurusan()
    {
        $user = User::find(1);
        $data = [
            'name' => 'jurusan_testing_' . Carbon::now()->format('d-m-Y H-i-s'),
        ];
        $response = $this->followingRedirects()->actingAs($user, '')->post('admin/unit/store', $data);
        $response->assertStatus(200);
    }
    public function test_pengisian_form_prodi()
    {
        $user = User::find(1);
        $data = [
            'name' => 'prodi' . Carbon::now()->format('d-m-Y H-i-s'),
        ];
        $response = $this->followingRedirects()->actingAs($user, '')->post('admin/prodi/store', $data);
        $response->assertStatus(200);
    }
    public function test_pengisian_form_kriteria_mitra()
    {
        $user = User::find(1);
        $data = [
            'kriteria_mitra' => 'kriteria_mitra_testing_' . Carbon::now()->format('d-m-Y H-i-s'),
        ];
        $response = $this->followingRedirects()->actingAs($user, '')->post('/admin/kriteria/mitra/store', $data);
        $response->assertStatus(200);
    }
    public function test_pengisian_form_kriteria_kemitraan()
    {
        $user = User::find(1);
        $data = [
            'kriteria_mitra' => 'kriteria_kemitraan_testing_' . Carbon::now()->format('d-m-Y H-i-s'),
        ];
        $response = $this->followingRedirects()->actingAs($user, '')->post('/admin/kriteria/kemitraan/store', $data);
        $response->assertStatus(200);
    }

    // testing view (admin)
    public function test_admin_view_dashboard()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, '')->get('/admin/dashboard');
        $response->assertStatus(200);
    }
    public function test_admin_view_kerjasama()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, '')->get('admin/kerjasama/');
        $response->assertStatus(200);
    }
    public function test_admin_view_pengajuan_kerjasama()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, '')->get('admin/pengajuan-kerjasama');
        $response->assertStatus(200);
    }
    public function test_admin_view_unit()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, '')->get('admin/unit');
        $response->assertStatus(200);
    }
    public function test_admin_view_prodi()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, '')->get('admin/prodi');
        $response->assertStatus(200);
    }
    public function test_admin_view_kriteria_mitra()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, '')->get('admin/kriteria/mitra');
        $response->assertStatus(200);
    }
    public function test_admin_view_kriteria_kemitraan()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, '')->get('admin/kriteria/kemitraan');
        $response->assertStatus(200);
    }

}
