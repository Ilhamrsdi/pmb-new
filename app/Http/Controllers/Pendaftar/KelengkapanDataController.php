<?php
namespace App\Http\Controllers\Pendaftar;

use App\Http\Controllers\Controller;
use App\Models\Atribut;
use App\Models\AtributGambar;
use App\Models\BerkasGelombangTransaksi;
use App\Models\Pendaftar;
use App\Models\RefPendapatan;
use App\Models\RefPendidikan;
use App\Models\RefProfesi;
use App\Models\Wali;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
// Tambahkan ini

class KelengkapanDataController extends Controller
{

    public function edit($id)
    {
        // Inisialisasi client untuk request API
        $client = new Client();

        // Mengambil data provinsi dari API Fariz

        // $authToken        = 'Bearer ' . '987|n5zdbFBJX7C94ROXgTyKNLaUMRHFiOT5GhElkvxd';
        // $responseProvinsi = $client->get('http://backend.sepyankristanto.my.id/api/v1/master/provinces', [
        //     'headers' => [
        //         'Authorization' => $authToken,
        //     ],
        // ]);
        // $provinsi = json_decode($responseProvinsi->getBody(), true)['data']; // Ambil array 'provinsi'

        $authToken        = 'Bearer ' . '987|n5zdbFBJX7C94ROXgTyKNLaUMRHFiOT5GhElkvxd';
        $responseProvinsi = $client->get('https://alamat.thecloudalert.com/api/provinsi/get/', [
            'headers' => [
                'Authorization' => $authToken,
            ],
        ]);
        $provinsi = json_decode($responseProvinsi->getBody(), true)['result'];

        // $responseKendaraan = $client->get('http://backend.sepyankristanto.my.id/api/v1/master/transportations', [
        //     'headers' => [
        //         'Authorization' => $authToken,
        //     ],
        // ]);
        // $kendaraan = json_decode($responseKendaraan->getBody(), true)['data'];
        $kendaraan = [
            ['id' => 1, 'name' => 'motor'],
            ['id' => 2, 'name' => 'mobil'],
        ];
        // return $kendaraan;
        // Mengambil data pendaftar dari database
        $pendaftar = Pendaftar::where('id', $id)->with('user', 'atribut')->first();

        // Form Biodata Diri
        // $kendaraan = RefKendaraan::get();
        // $jenis_tinggal = RefJenis_tinggal::get();
        // $responseJenis_tinggal = $client->get('http://backend.sepyankristanto.my.id/api/v1/master/type-of-stays', [
        //     'headers' => [
        //         'Authorization' => $authToken,
        //     ],
        // ]);
        // $jenis_tinggal = json_decode($responseJenis_tinggal->getBody(), true)['data'];

        $jenis_tinggal = [
            ['id' => 1, 'name' => 'rumah'],
            ['id' => 2, 'name' => 'kos'],
        ];

        // $negara = RefCountry::orderBy('name')->get();
        // $responseNegara = $client->get('http://backend.sepyankristanto.my.id/api/v1/master/countries', [
        //     'headers' => [
        //         'Authorization' => $authToken,
        //     ],
        // ]);
        // $negara = json_decode($responseNegara->getBody(), true)['data'];

        $negara = [
            ['id' => 1, 'name' => 'indonesia'],
            ['id' => 2, 'name' => 'malaysia'],
        ];

        // Mengambil data kabupaten berdasarkan provinsi pendaftar (jika ada)

        // $responsekabupaten_kota = $client->get('http://backend.sepyankristanto.my.id/api/v1/master/cities', [
        //     'headers' => [
        //         'Authorization' => $authToken,
        //     ],
        // ]);
        // $kabupaten_kota = json_decode($responsekabupaten_kota->getBody(), true)['data']; // Ambil array 'provinsi'
        // Mengambil data kabupaten/kota dari API
        $responsekabupaten_kota = $client->get('https://alamat.thecloudalert.com/api/kecamatan/get', [
            'headers' => [
                'Authorization' => $authToken,
            ],
        ]);

// Mengdecode body respons menjadi array asosiatif
        $kabupaten_kota = json_decode($responsekabupaten_kota->getBody(), true);

// Memeriksa apakah respons berhasil dan terdapat data kabupaten/kota
        $kabupatenKotaData = isset($kabupaten_kota['result']) ? $kabupaten_kota['result'] : [];

// $kecamatan = RefRegion::where('level', 3)->get();

        $responsekecamatan = $client->get('https://alamat.thecloudalert.com/api/kelurahan/get/', [
            'headers' => [
                'Authorization' => $authToken,
            ],
        ]);
        $kecamatan = json_decode($responsekecamatan->getBody(), true)['result'];

        // Ambil data kecamatan dan lainnya

        // $agama = RefAgama::get();
        // $responseAgama = $client->get('http://backend.sepyankristanto.my.id/api/v1/master/religions', [
        //     'headers' => [
        //         'Authorization' => $authToken,
        //     ],
        // ]);
        // $agama  = json_decode($responseAgama->getBody(), true)['data'];

        $agama = [
            ['id' => 1, 'name' => 'islam'],
            ['id' => 2, 'name' => 'hindu'],
        ];
        $ukuran = ['s', 'm', 'l', 'xl', 'xxl'];

        // Form Biodata Orang Tua
        $pendidikan = ['sd', 'smp', 'sma'];

        // $responsePendidikan = $client->get('http://backend.sepyankristanto.my.id/api/v1/master/religions', [
        //     'headers' => [
        //         'Authorization' => $authToken,
        //     ],
        // ]);
        // $pendidikan = json_decode($responsePendidikan->getBody(), true)['data'];
        // $profesi    = RefProfesi::get();
        // $pendapatan = RefPendapatan::get();

        $profesi = [
            ['id' => 1, 'name' => 'guru'],
            ['id' => 2, 'name' => 'staff'],
        ];
        $pendapatan = [
            ['id' => 1, 'name' => '1000'],
            ['id' => 2, 'name' => '2999'],
        ];

        // Form Berkas Pendukung
        $list_berkas = BerkasGelombangTransaksi::where('gelombang_id', $pendaftar->gelombang_id)
            ->with('berkas') // Eager load relasi settingBerkas
            ->get();
        $atributGambars = AtributGambar::all();
        // dd($atributGambars);
        // dd($list_berkas);    
        // Kirim data ke view
        return view('pendaftar.kelengkapan-data.kelengkapan-data', compact(
            'pendaftar', 'kendaraan', 'jenis_tinggal', 'negara', 'provinsi',
            'kabupaten_kota', 'kecamatan', 'agama', 'ukuran',
            'pendidikan', 'profesi', 'pendapatan', 'list_berkas', 'kabupatenKotaData', 'atributGambars'
        ));
    }

    public function get_kabupaten($id)
    {
        $client                 = new Client();
        $responsekabupaten_kota = $client->get('https://alamat.thecloudalert.com/api/kabkota/get/?d_provinsi_id=' . $id);

// Mengdecode body respons menjadi array asosiatif
        $kabupaten_kota = json_decode($responsekabupaten_kota->getBody(), true)['result'];

        return response()->json($kabupaten_kota);
    }

    public function get_kecamatan($id)
    {
        $client                 = new Client();
        $responsekabupaten_kota = $client->get('https://alamat.thecloudalert.com/api/kecamatan/get/?d_kabkota_id=' . $id, [
        ]);

// Mengdecode body respons menjadi array asosiatif
        $kabupaten_kota = json_decode($responsekabupaten_kota->getBody(), true)['result'];

        return response()->json($kabupaten_kota);
    }

    public function update(Request $request, $id)
    {

        // Update Data Pendaftar
        $pendaftar = Pendaftar::where('id', $id)->update([
            "nama"            => $request->nama,
            "nisn"            => $request->nisn,
            "sekolah"         => $request->sekolah,
            "alamat"          => $request->alamat,
            "jenis_tinggal"   => $request->jenis_tinggal,
            "jenis_kelamin"   => $request->jenis_kelamin,
            "kendaraan"       => $request->kendaraan,
            "kewarganegaraan" => $request->kewarganegaraan,
            "negara"          => $request->negara,
            "provinsi"        => $request->provinsi ?? 'jatim',
            "kabupaten"       => $request->kabupaten ?? 'banyuwangi',
            "kecamatan"       => $request->kecamatan ?? 'banyuwangi',
            "kelurahan_desa"  => $request->kelurahan_desa,
            "rt"              => $request->rt,
            "rw"              => $request->rw,
            "kode_pos"        => $request->kode_pos,
            "no_hp"           => $request->no_hp,
            "telepon_rumah"   => $request->telepon_rumah,
            "tempat_lahir"    => $request->tempat_lahir,
            "tanggal_lahir"   => $request->tanggal_lahir,
            "agama"           => $request->agama,
        ]);
        // return $request->all();

        // Update Data Orang Tua
        $wali = Wali::where('pendaftar_id', $id)->update([
            "nik_ayah"           => $request->nik_ayah,
            "status_ayah"        => $request->status_ayah,
            "nama_ayah"          => $request->nama_ayah,
            "tanggal_lahir_ayah" => $request->tanggal_lahir_ayah,
            "pendidikan_ayah"    => $request->pendidikan_ayah,
            "pekerjaan_ayah"     => $request->pekerjaan_ayah,
            "penghasilan_ayah"   => $request->penghasilan_ayah,
            "nik_ibu"            => $request->nik_ibu,
            "status_ibu"         => $request->status_ibu,
            "nama_ibu"           => $request->nama_ibu,
            "tanggal_lahir_ibu"  => $request->tanggal_lahir_ibu,
            "pendidikan_ibu"     => $request->pendidikan_ibu,
            "pekerjaan_ibu"      => $request->pekerjaan_ibu,
            "penghasilan_ibu"    => $request->penghasilan_ibu,
        ]);

        // Update Data Atribut
        $atribut = Atribut::where('pendaftar_id', $id)->update([
            'atribut_kaos'          => $request->atribut_kaos,
            'atribut_topi'          => $request->atribut_topi,
            'atribut_almamater'     => $request->atribut_almamater,
            'atribut_jas_lab'       => $request->atribut_jas_lab,
            'atribut_baju_lapangan' => $request->atribut_baju_lapangan,
        ]);
        // $namas = [];

        if (! empty($request->file)) {
            foreach ($request->file as $key => $value) {
                $nama = $id . '.' . $value->extension();
                $value->move(public_path('assets/file/' . $key . '/'), $nama);
            }
        }

        // return redirect()->route('kelengkapan-data.lanjutan.index', ['id' => $id])->with('tab', 'finish');
        return redirect()->route('kelengkapan-data.edit', ['id' => $id])->with('tab', 'finish');

    }

    public function index($id)
    {
        $client = new Client();
        $authToken = 'Bearer ' . '987|n5zdbFBJX7C94ROXgTyKNLaUMRHFiOT5GhElkvxd';
    
        // Caching data API agar tidak terlalu banyak request
        $provinsi = Cache::remember('provinsi_data', 60 * 60, function () use ($client, $authToken) {
            $response = $client->get('https://alamat.thecloudalert.com/api/provinsi/get/', [
                'headers' => ['Authorization' => $authToken],
            ]);
            return json_decode($response->getBody(), true)['result'] ?? [];
        });
    
        $kabupatenKotaData = Cache::remember('kabupaten_data', 60 * 60, function () use ($client, $authToken) {
            $response = $client->get('https://alamat.thecloudalert.com/api/kabkota/get', [
                'headers' => ['Authorization' => $authToken],
            ]);
            return json_decode($response->getBody(), true)['result'] ?? [];
        });
    
        $kecamatan = Cache::remember('kecamatan_data', 60 * 60, function () use ($client, $authToken) {
            $response = $client->get('https://alamat.thecloudalert.com/api/kelurahan/get', [
                'headers' => ['Authorization' => $authToken],
            ]);
            return json_decode($response->getBody(), true)['result'] ?? [];
        });
    
        // Mengambil data pendaftar dari database
        $pendaftar = Pendaftar::where('id', $id)->with(['user', 'atribut'])->firstOrFail();
        
        // Data statis langsung didefinisikan
        $jenis_tinggal = ['kontrak', 'sewa', 'kos', 'rumah'];
        $negara = ['indonesia'];
        $agama = ['islam', 'kristen'];
        $ukuran = ['s', 'm', 'l', 'xl', 'xxl'];
        $kendaraan = ['sepeda motor', 'mobil', 'sepeda gayung'];
    
        // Mengambil data pendidikan, profesi, dan pendapatan dengan eager loading untuk efisiensi
        $pendidikan = ['SD', 'SMP','SMA', 'S1', 'S2', 'S3'];
        $profesi = ['Wiraswasta', 'PNS', 'PETANI', 'DAGANG'];
        $pendapatan = ['Dibawah 3.000.000', 'Diatas 3.000.000'];
    
        // Form Berkas Pendukung
        $list_berkas = BerkasGelombangTransaksi::where('gelombang_id', $pendaftar->gelombang_id)
            ->with('berkas')
            ->get();
        
        $atributGambars = AtributGambar::all();
        // dd($pendaftar)->all;
        // dd(request()->all());

        return view('pendaftar.kelengkapan-data.kelengkapan-data-lanjutan', compact(
            'pendaftar', 'kendaraan', 'jenis_tinggal', 'negara', 'provinsi',
            'kabupatenKotaData', 'kecamatan', 'agama', 'ukuran',
            'pendidikan', 'profesi', 'pendapatan', 'list_berkas', 'atributGambars'
        ));
    }

    public function updateLanjutan(Request $request, $id)
    {
        // Validasi input
        // $request->validate([
        //     'nama' => 'required|string|max:255',
        //     'nisn' => 'required|numeric|digits:10',
        //     // Tambahkan validasi lainnya
        // ]);

        // Update data Pendaftar
        $pendaftar = Pendaftar::findOrFail($id);
        // $pendaftar->update([
        //     "nama"    => $request->nama,
        //     "nisn"    => $request->nisn,
        //     "sekolah" => $request->sekolah,
        //     // ...lanjutan atribut lainnya
        // ]);
        

        // Update data Wali
        $wali = Wali::where('pendaftar_id', $id)->firstOrFail();
        $wali->update([
            "nik_ayah"           => $request->nik_ayah,
            "status_ayah"        => $request->status_ayah,
            "nama_ayah"          => $request->nama_ayah,
            "tanggal_lahir_ayah" => $request->tanggal_lahir_ayah,
            "pendidikan_ayah"    => $request->pendidikan_ayah,
            "pekerjaan_ayah"     => $request->pekerjaan_ayah,
            "penghasilan_ayah"   => $request->penghasilan_ayah,
            "nik_ibu"            => $request->nik_ibu,
            "status_ibu"         => $request->status_ibu,
            "nama_ibu"           => $request->nama_ibu,
            "tanggal_lahir_ibu"  => $request->tanggal_lahir_ibu,
            "pendidikan_ibu"     => $request->pendidikan_ibu,
            "pekerjaan_ibu"      => $request->pekerjaan_ibu,
            "penghasilan_ibu"    => $request->penghasilan_ibu,
            // ...lanjutan atribut lainnya
        ]);

        // Update data Atribut
        $atribut = Atribut::where('pendaftar_id', $id)->firstOrFail();
        $atribut->update([
            'atribut_kaos' => $request->atribut_kaos,
            // ...lanjutan atribut lainnya
        ]);

        // Upload file jika ada
        if (! empty($request->file)) {
            foreach ($request->file as $key => $value) {
                $this->validate($request, [
                    "file.$key" => 'file|mimes:pdf,jpg,png|max:2048',
                ]);

                $nama            = $id . '.' . $value->extension();
                $destinationPath = public_path("assets/file/$key/");
                if (! file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                $value->move($destinationPath, $nama);
            }
        }

        // dd()->request()->all();
        // Redirect dengan pesan sukses
       return redirect()->back()->with('tab', 'finish');

    }

    //   use Illuminate\Support\Facades\Http; // Pastikan ini di-import

}
