<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Kerjasama;
use App\Models\prodi;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use faker\Factory as paker;
use Faker\Factory;
use Illuminate\Http\Response;

class adminTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */


    // ---------------------------
    // Kategori: test_admin_view_*
    // ---------------------------

    public function test_admin_view_dashboard()
    {
        $user = User::find(1);  // cari user
        $response = $this->actingAs($user)->get('/admin/dashboard'); // acting as itu login jadi user 
        $response->assertStatus(200);
        $response->assertViewIs('home');
    }
    public function test_admin_view_user()
    {
        $user = User::find(1);
        $response = $this->actingAs($user)->get('/admin/user');
        $response->assertStatus(200);
        $response->assertViewIs('user.index');
    }

    public function test_admin_view_kerjasama()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, '')->get('admin/kerjasama/');
        $response->assertStatus(200);
        $response->assertViewIs('kerjasama.index');
    }

    public function test_admin_view_pengajuan_kerjasama()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, '')->get('admin/pengajuan-kerjasama');
        $response->assertViewIs('review.index');
        $response->assertStatus(200);
    }

    public function test_admin_view_unit()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, '')->get('admin/unit');
        $response->assertStatus(200);
        $response->assertViewIs('unit.index');
    }

    public function test_admin_view_prodi()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, '')->get('admin/prodi');
        $response->assertStatus(200);
        $response->assertViewIs('prodi.index');
    }

    public function test_admin_view_jenis_kerjasama()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, '')->get('admin/jenis-kerjasama');
        $response->assertStatus(200);
        $response->assertViewIs('jenis-kerjasama.index');
    }

    public function test_admin_view_pks()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, '')->get('admin/perjanjian-kerjasama');
        $response->assertStatus(200);
        $response->assertViewIs('perjanjian.index');
    }

    public function test_admin_view_kriteria_mitra()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, '')->get('admin/kriteria/mitra');
        $response->assertStatus(200);
        $response->assertViewIs('kriteria.mitra.index');
    }

    public function test_admin_view_kriteria_kemitraan()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, '')->get('admin/kriteria/kemitraan');
        $response->assertStatus(200);
        $response->assertViewIs('kriteria.kemitraan.index');
    }

    // -------------------------------
    // Kategori: test_admin_view_add_*
    // -------------------------------

    public function test_admin_view_add_user()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, '')->get('admin/user/add');
        $response->assertStatus(200);
        $response->assertViewIs('user.add');
    }
    public function test_admin_view_add_pengajuan_kerjasama()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, '')->get('admin/pengajuan-kerjasama/add');
        $response->assertStatus(200);
        $response->assertViewIs('review.add');
    }

    public function test_admin_view_add_unit()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, '')->get('admin/unit/add');
        $response->assertStatus(200);
        $response->assertViewIs('unit.add');
    }

    public function test_admin_view_add_prodi()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, '')->get('admin/prodi/add');
        $response->assertStatus(200);
        $response->assertViewIs('prodi.add');
    }

    public function test_admin_view_add_jenis_kerjasama()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, '')->get('admin/jenis-kerjasama/add');
        $response->assertStatus(200);
        $response->assertViewIs('jenis-kerjasama.add');
    }

    public function test_admin_view_add_pks()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, '')->get('admin/perjanjian-kerjasama/add');
        $response->assertStatus(200);
        $response->assertViewIs('perjanjian.add');
    }

    public function test_admin_view_add_kriteria_mitra()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, '')->get('admin/kriteria/mitra/add');
        $response->assertStatus(200);
        $response->assertViewIs('kriteria.mitra.add');
    }

    public function test_admin_view_add_kriteria_kemitraan()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, '')->get('admin/kriteria/kemitraan/add');
        $response->assertStatus(200);
        $response->assertViewIs('kriteria.kemitraan.add');
    }

    // -------------------------------
    // Kategori: test_admin_view_edit_*
    // -------------------------------

    public function test_admin_view_edit_pengajuan_kerjasama()
    {
        $user = User::find(1);
        $data = Kerjasama::find(2);
        $response = $this->actingAs($user, '')->get('admin/pengajuan-kerjasama/edit/' . $data->id);
        $response->assertViewIs('review.edit');
        $response->assertStatus(200);
    }
    public function test_admin_view_edit_user()
    {
        $user = User::find(1);
        $data = User::find(10);
        $response = $this->actingAs($user, '')->get('admin/user/edit/' . $data->id);
        $response->assertViewIs('user.edit');
        $response->assertStatus(200);
    }
    public function test_admin_view_edit_unit()
    {
        $user = User::find(1);
        $data = Unit::find(1);
        $response = $this->actingAs($user, '')->get('admin/unit/edit/' . $data->id);
        $response->assertViewIs('unit.edit');
        $response->assertStatus(200);
    }
    public function test_admin_view_edit_prodi()
    {
        $user = User::find(1);
        $data = prodi::find(1);
        $response = $this->actingAs($user, '')->get('admin/prodi/edit/' . $data->id);
        $response->assertViewIs('prodi.edit');
        $response->assertStatus(200);
    }

    // -------------------------------
    // Kategori: test_admin_view_detail_*
    // -------------------------------

    public function test_admin_view_detail_kerjasama(){
        $user = User::find(1);
        $data = Kerjasama::find(1);
        $response = $this->actingAs($user, '')->get('admin/pengajuan-kerjasama/detail/' . $data->id);
        $response->assertViewIs('review.detail');
        $response->assertSee('dumns',true);
        $response->assertSee('Temporibus et dolorum tenetur ad est sit maiores.',true);
        $response->assertSee('1',true);
        $response->assertStatus(200);
    }


    public function test_admin_tracker()
    {
        $response = $this->get('/trackpengajuan');

        $response->assertStatus(200);
    }
    public function test_admin_login()
    {
        $this->withoutExceptionHandling();
        session()->setPreviousUrl('/admin/dashboard'); // set previous url

        $response = $this->post('/login', [
            'username' => 'admin123',
            'password' => 'admin123',
        ]);
        $this->assertAuthenticated();
    }
    public function test_admin_login_failed()
    {
        session()->setPreviousUrl('/admin/dashboard'); // set previous url

        $response = $this->post('/login', [
            'username' => 'kosong',
            'password' => 'kosong',
        ]);
        $response->assertSessionHasErrors('username');
    }

    public function test_unauthorized_admin_access_dashboard()
    {
        $user = User::find(4); // pic user
        $response = $this->actingAs($user)->get('/admin/dashboard');
        // Assert that the user receives a 403 Forbidden status
        $response->assertForbidden();
    }


    public function test_admin_store_form_pengajuan()
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

        $response = $this->actingAs($user)->post('admin/pengajuan-kerjasama/store', $data);

        $response->assertRedirect('/admin/pengajuan-kerjasama');

        $this->assertDatabaseHas('kerjasamas', [
            'mitra' => 'duck',
        ]);
    }
    // public function test_admin_store_form_pengajuan_failed()
    // {
    //     $user = User::find(1);
    //     session()->setPreviousUrl('/admin/pengajuan-kerjasama');
    //     $data = [];
    //     $response = $this->actingAs($user)->post('admin/pengajuan-kerjasama/store', $data);
    //     $response->assertRedirect('/admin/pengajuan-kerjasama');
    //      belum ketemu buat coverage error
    // }


    public function test_admin_store_form_jenis_kerjasama()
    {
        $user = User::find(1);
        $date = Carbon::now()->format('d-m-Y H-i-s');
        $data = [
            'jenis_kerjasama' => 'kerja_testing_' . $date,
        ];
        session()->setPreviousUrl('/admin/jenis-kerjasama');

        $response = $this->actingAs($user)->post('admin/jenis-kerjasama/store', $data);
        $response->assertRedirect('/admin/jenis-kerjasama/');
        $this->assertDatabaseHas('jenis_kerjasamas', [
            'jenis_kerjasama' => $data['jenis_kerjasama']
        ]);
    }

    public function test_admin_store_form_pks()
    {
        $user = User::find(1); // login jadi admin

        $data = [
            'pks' => 'testing_pks_' . Carbon::now()->format('d-m-Y H-i-s'),
        ];
        session()->setPreviousUrl('/admin/perjanjian-kerjasama');
        $response = $this->followingRedirects()->actingAs($user, '')->post('admin/perjanjian-kerjasama/store', $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('pks', [
            'pks' => $data['pks']
        ]);
    }
    public function test_admin_store_form_jurusan()
    {
        $user = User::find(1);
        $data = [
            'name' => 'jurusan_testing_' . Carbon::now()->format('d-m-Y H-i-s'),
        ];
        $response = $this->followingRedirects()->actingAs($user, '')->post('admin/unit/store', $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('unit', [
            'name' => $data['name']
        ]);
    }
    public function test_admin_store_form_prodi()
    {
        $user = User::find(1);
        $paker = Factory::create();
        $data = [
            'unit_id' => $paker->randomElement(range(1, 10)),
            'name' => 'prodi_' . Carbon::now()->format('d-m-Y H-i-s'),
        ];
        $response = $this->followingRedirects()->actingAs($user, '')->post('admin/prodi/store', $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('prodis', [
            'name' => $data['name']
        ]);
    }
    public function test_admin_store_form_kriteria_mitra()
    {
        $user = User::find(1);
        $data = [
            'kriteria_mitra' => 'kriteria_mitra_testing_' . Carbon::now()->format('d-m-Y H-i-s'),
        ];
        $response = $this->followingRedirects()->actingAs($user, '')->post('/admin/kriteria/mitra/store', $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('kriteria_mitras', [
            'kriteria_mitra' => $data['kriteria_mitra']
        ]);
    }
    public function test_admin_store_form_kriteria_kemitraan()
    {
        $user = User::find(1);
        $data = [
            'kriteria_kemitraan' => 'kriteria_kemitraan_testing_' . Carbon::now()->format('d-m-Y H-i-s'),
        ];
        $response = $this->followingRedirects()->actingAs($user, '')->post('/admin/kriteria/kemitraan/store', $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('kriteria_kemitraans', [
            'kriteria_kemitraan' => $data['kriteria_kemitraan']
        ]);
    }
    public function test_admin_store_form_user()
    {
        session()->setPreviousUrl('/admin/user');
        $user = User::find(1); // Admin user
        $paker = Factory::create();
        $data = [
            'username' => $paker->userName,
            'email' => $paker->email,
            'name' => $paker->name,
            'password' => 'password123',
            're_password' => 'password123',
            'role_id' => 1,
        ];

        $response = $this->followingRedirects()->actingAs($user)->post('/admin/user/store', $data);
        $this->assertDatabaseHas('users', [
            'email' => $data['email'],
            'username' => $data['username'],
        ]);
        $response->assertStatus(200);
    }
}
