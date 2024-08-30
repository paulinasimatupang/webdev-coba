<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Redirect;
use Validator;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\DataCalonNasabahCreateRequest;
use App\Http\Requests\DataCalonNasabahUpdateRequest;
use App\Repositories\DataCalonNasabahRepository;
use App\Validators\DataCalonNasabahValidator;

use Illuminate\Support\Facades\Log;
use Ixudra\Curl\Facades\Curl;

use App\Entities\DataCalonNasabah;
use App\Entities\CompOption;

class DataCalonNasabahController extends Controller
{
    /**
     * @var DataCalonNasabahRepository
     */
    protected $repository;

    /**
     * @var DataCalonNasabahValidator
     */
    protected $validator;

    /**
     * DataCalonNasabahController constructor.
     *
     * @param DataCalonNasabahRepository $repository
     * @param DataCalonNasabahValidator $validator
     */
    public function __construct(DataCalonNasabahRepository $repository, DataCalonNasabahValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('apps.calon_nasabah.menu');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));

        $data = DataCalonNasabah::select('*');
        $data = $data->whereIn('status', [2, 3, 4]);

        if ($request->has('search')) {
            $data = $data->whereRaw('lower(name) like (?)', ["%{$request->search}%"]);
        }

        $total = $data->count();

        if ($request->has('order_type')) {
            if ($request->get('order_type') == 'asc') {
                if ($request->has('order_by')) {
                    $data->orderBy($request->get('order_by'));
                } else {
                    $data->orderBy('request_time');
                }
            } else {
                if ($request->has('order_by')) {
                    $data->orderBy($request->get('order_by'), 'desc');
                } else {
                    $data->orderBy('request_time', 'desc');
                }
            }
        } else {
            $data->orderBy('request_time', 'desc');
        }

        $data = $data->get();

        foreach ($data as $nasabah) {
            if ($nasabah->status == 1) {
                $nasabah->status_text = 'Accepted';
            } else {
                $nasabah->status_text = 'Rejected';
            }
        }

        $user = session()->get('user');

        return view('apps.calon_nasabah.list')
            ->with('data', $data)
            ->with('username', $user->username);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list_request(Request $request)
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));

        $data = DataCalonNasabah::select('*');
        $data = $data->where('status', 0);

        if ($request->has('search')) {
            $data = $data->whereRaw('lower(name) like (?)', ["%{$request->search}%"]);
        }

        $total = $data->count();

        if ($request->has('order_type')) {
            if ($request->get('order_type') == 'asc') {
                if ($request->has('order_by')) {
                    $data->orderBy($request->get('order_by'));
                } else {
                    $data->orderBy('request_time');
                }
            } else {
                if ($request->has('order_by')) {
                    $data->orderBy($request->get('order_by'), 'desc');
                } else {
                    $data->orderBy('request_time', 'desc');
                }
            }
        } else {
            $data->orderBy('request_time', 'desc');
        }

        $data = $data->get();

        $user = session()->get('user');

        return view('apps.calon_nasabah.list-request')
            ->with('data', $data)
            ->with('username', $user->username);
    }

    public function list_approve(Request $request)
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));

        $data = DataCalonNasabah::select('*');
        $data = $data->where('status', 1);

        if ($request->has('search')) {
            $data = $data->whereRaw('lower(name) like (?)', ["%{$request->search}%"]);
        }

        $total = $data->count();

        if ($request->has('order_type')) {
            if ($request->get('order_type') == 'asc') {
                if ($request->has('order_by')) {
                    $data->orderBy($request->get('order_by'));
                } else {
                    $data->orderBy('request_time');
                }
            } else {
                if ($request->has('order_by')) {
                    $data->orderBy($request->get('order_by'), 'desc');
                } else {
                    $data->orderBy('request_time', 'desc');
                }
            }
        } else {
            $data->orderBy('request_time', 'desc');
        }

        $data = $data->get();

        $user = session()->get('user');

        return view('apps.calon_nasabah.list-approve')
            ->with('data', $data)
            ->with('username', $user->username);
    }

    public function store_cif($id)
    {
        DB::beginTransaction();
        try {
            $nasabah = DataCalonNasabah::find($id);
            if ($nasabah) {
                $nama_lengkap = $nasabah->nama_lengkap;
                $nama_alias = $nasabah->nama_alias;
                $ibu_kandung = $nasabah->ibu_kandung;
                $tempat_lahir = $nasabah->tempat_lahir;
                $tgl_lahir = $nasabah->tgl_lahir;
                $jenis_kelamin = $nasabah->jenis_kelamin;
                $agama = $nasabah->agama;
                $status_nikah = $nasabah->status_nikah;
                $alamat = $nasabah->alamat;
                $rt = $nasabah->rt;
                $rw = $nasabah->rw;
                $kecamatan = $nasabah->kecamatan;
                $kelurahan = $nasabah->kelurahan;
                $kab_kota = $nasabah->kab_kota;
                $provinsi = $nasabah->provinsi;
                $kode_pos = $nasabah->kode_pos;
                $status_penduduk = $nasabah->status_penduduk;
                $kewarganegaraan = $nasabah->kewarganegaraan;
                $no_telp = $nasabah->no_telp;
                $no_hp = $nasabah->no_hp;
                $npwp = $nasabah->npwp;
                $jenis_identitas = $nasabah->jenis_identitas;
                $no_identitas = $nasabah->no_identitas;
                $golongan_darah = $nasabah->golongan_darah;
                $expired_identitas = $nasabah->expired_identitas;
                $pendidikan_terakhir = $nasabah->pendidikan_terakhir;
                $email = $nasabah->email;
                $branchid = $nasabah->branchid;

                $terminal = '353471045058692';
                $dateTime = date("YmdHis");

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "http://108.137.154.8:8080/ARRest/api/");
                $data = json_encode([
                    'msg' => [
                        'msg_id' => "$terminal$dateTime",
                        'msg_ui' => "$terminal",
                        'msg_si' => 'CC0004',
                        'msg_dt' => 'lakupandai|' . $no_identitas . '|' . $nama_lengkap . '|' . $nama_alias . '|' . $ibu_kandung . '|' . $tempat_lahir . '|' . $tgl_lahir . '|' . $jenis_kelamin . '|' .
                            $agama . '|' . $status_nikah . '|' . $alamat . '|' . $rt . '|' . $rw . '|' . $kecamatan . '|' . $kelurahan . '|' . $kab_kota . '|' . $provinsi . '|' . $kode_pos .
                            '|' . $status_penduduk . '|' . $kewarganegaraan . '|' . $no_telp . '|' . $no_hp . '|' . $npwp . '|' . $jenis_identitas . '|' . $golongan_darah . '|' . $expired_identitas .
                            '|' . $pendidikan_terakhir . '|' . $email . '|' . $branchid
                    ]
                ]);

                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: text/plain'
                ]);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

                $output = curl_exec($ch);
                $err = curl_error($ch);
                $info = curl_getinfo($ch);
                curl_close($ch);

                Log::info('cURL Request URL: ' . $info['url']);
                Log::info('cURL Request Data: ' . $data);
                Log::info('cURL Response: ' . $output);

                $responseArray = json_decode($output, true);

                if ($err) {
                    Log::error('cURL Error: ' . $err);
                } else {
                    $cifid = null;
                    if (isset($responseArray['screen']['comps']['comp'])) {
                        foreach ($responseArray['screen']['comps']['comp'] as $comp) {
                            if ($comp['comp_lbl'] === 'No CIF') {
                                $cifid = $comp['comp_values']['comp_value'][0]['value'];
                                $nasabah->no_cif = $cifid;
                            }
                        }
                    }
                    $nasabah->save();
                }

                if (isset($responseArray['screen']['title']) && $responseArray['screen']['title'] === 'Gagal') {
                    return false;
                } else {
                    DB::commit();
                    return true;
                }
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error in store_cif: ' . $e->getMessage());
            return false;
        }
    }

    public function registration_code($id)
    {
        DB::beginTransaction();
        try {
            $nasabah = DataCalonNasabah::find($id);
            if ($nasabah) {
                do {
                    $no_registrasi = str_pad(mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT);
                    $exists = DataCalonNasabah::where('no_registrasi', $no_registrasi)->exists();
                } while ($exists);

                $nasabah->no_registrasi = $no_registrasi;
                $nasabah->save();
            }
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error generate: ' . $e->getMessage());
            return false;
        }
    }

    public function store_rekening($id)
    {
        DB::beginTransaction();
        try {
            $nasabah = DataCalonNasabah::find($id);
            if ($nasabah) {
                $nama_lengkap = $nasabah->nama_lengkap;
                $no_cif = $nasabah->no_cif;
                $kode_produk = 36;
                $no_registrasi = $nasabah->no_registrasi;
                $branchid = $nasabah->branchid;

                $terminal = '353471045058692';
                $dateTime = date("YmdHis");

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "http://108.137.154.8:8080/ARRest/api/");
                $data = json_encode([
                    'msg' => [
                        'msg_id' => "$terminal$dateTime",
                        'msg_ui' => "$terminal",
                        'msg_si' => 'CRS004',
                        'msg_dt' => 'lakupandai|' . $nama_lengkap . '|' . $no_cif . '|' . $kode_produk . '|' . $no_registrasi . '|' . $branchid
                    ]
                ]);

                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: text/plain'
                ]);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

                $output = curl_exec($ch);
                $err = curl_error($ch);
                $info = curl_getinfo($ch);
                curl_close($ch);

                Log::info('cURL Request URL: ' . $info['url']);
                Log::info('cURL Request Data: ' . $data);
                Log::info('cURL Response: ' . $output);

                $responseArray = json_decode($output, true);

                if ($err) {
                    Log::error('cURL Error: ' . $err);
                } else {
                    $noRekening = null;
                    if (isset($responseArray['screen']['comps']['comp'])) {
                        foreach ($responseArray['screen']['comps']['comp'] as $comp) {
                            if ($comp['comp_lbl'] === 'No Rekening') {
                                $noRekening = $comp['comp_values']['comp_value'][0]['value'];
                                $nasabah->no_rekening = $noRekening;
                            }
                        }
                    }
                    $nasabah->save();
                }

                if (isset($responseArray['screen']['title']) && $responseArray['screen']['title'] === 'Gagal') {
                    return false;
                } else {
                    DB::commit();
                    return true;
                }
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error in store_cif: ' . $e->getMessage());
            return false;
        }
    }

    public function approveNasabah($id)
    {
        DB::beginTransaction();
        try {
            $nasabah = DataCalonNasabah::find($id);

            if (!$nasabah) {
                return Redirect::to('/nasabah/approve')
                    ->with('error', "Data nasabah tidak ditemukan");
            }

            $this->registration_code($id);

            if (!$this->registration_code($id)) {
                return Redirect::to('/nasabah/approve')
                    ->with('error', "Gagal menghasilkan nomor registrasi.");
            }

            if (!$this->store_cif($id)) {
                return Redirect::to('/nasabah/approve')
                    ->with('error', "Gagal membuat CIF.");
            }

            if (!$this->store_rekening($id)) {
                return Redirect::to('/nasabah/approve')
                    ->with('error', "Gagal membuat rekening.");
            }

            $nasabah->status = 2;
            $nasabah->reply_time = now();
            $nasabah->save();

            DB::commit();
            return Redirect::to('/nasabah/approve')->with('success', 'Nasabah berhasil disetujui, CIF dan rekening berhasil dibuat.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error in approveNasabah: ' . $e->getMessage());
            return Redirect::to('/nasabah/approve')
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }

    public function rejectNasabah($id)
    {
        DB::beginTransaction();
        try {
            $nasabah = DataCalonNasabah::where('id', $id)->first();
            if (!$nasabah) {
                throw new \Exception("nasabah not found");
            }

            $nasabah->status = 3;
            $nasabah->reply_time = now();
            $nasabah->save();

            DB::commit();
            return redirect()->route('nasabah_request')->with('success', 'Permintaan Berhasil Ditolak.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error : ' . $e->getMessage());
            return Redirect::to('nasabah_request')
                ->with('error', $e->getMessage());
        }
    }

    public function acceptNasabah($id)
    {
        DB::beginTransaction();
        try {
            $nasabah = DataCalonNasabah::where('id', $id)->first();
            if (!$nasabah) {
                throw new \Exception("nasabah not found");
            }

            $nasabah->status = 1;
            $nasabah->save();

            DB::commit();
            return redirect()->route('nasabah_request')->with('success', 'Permintaan Berhasil Diterima.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error : ' . $e->getMessage());
            return Redirect::to('nasabah_request')
                ->with('error', $e->getMessage());
        }
    }

    public function detailRequest($id)
    {
        $nasabah = DataCalonNasabah::find($id);
        if ($nasabah) {
            $jenis_kelamin = CompOption::where('comp_id', 'CIF05')->get();
            $agama = CompOption::where('comp_id', 'CIF06')->get();
            $status_nikah = CompOption::where('comp_id', 'CIF07')->get();
            $status_penduduk = CompOption::where('comp_id', 'CIF16')->get();
            $kewarganegaraan = CompOption::where('comp_id', 'CIF17')->get();
            $jenis_identitas = CompOption::where('comp_id', 'CIF21')->get();
            $pendidikan_terakhir = CompOption::where('comp_id', 'CIF25')->get();
            $kab_kota = CompOption::where('comp_id', 'CIF13')->get();
            $provinsi = CompOption::where('comp_id', 'CIF14')->get();
            $golongan_darah = CompOption::where('comp_id', 'CIF23')->get();

            return view('apps.calon_nasabah.detail-request')
                ->with('nasabah', $nasabah)
                ->with('jenis_kelamin', $jenis_kelamin)
                ->with('agama', $agama)
                ->with('status_nikah', $status_nikah)
                ->with('status_penduduk', $status_penduduk)
                ->with('kewarganegaraan', $kewarganegaraan)
                ->with('jenis_identitas', $jenis_identitas)
                ->with('pendidikan_terakhir', $pendidikan_terakhir)
                ->with('kab_kota', $kab_kota)
                ->with('provinsi', $provinsi)
                ->with('golongan_darah', $golongan_darah);
        } else {
            return Redirect::to('nasabah_request')
                ->with('error', 'Data not found');
        }
    }
    public function detailApprove($id)
    {
        $nasabah = DataCalonNasabah::find($id);
        if ($nasabah) {
            $jenis_kelamin = CompOption::where('comp_id', 'CIF05')->get();
            $agama = CompOption::where('comp_id', 'CIF06')->get();
            $status_nikah = CompOption::where('comp_id', 'CIF07')->get();
            $status_penduduk = CompOption::where('comp_id', 'CIF16')->get();
            $kewarganegaraan = CompOption::where('comp_id', 'CIF17')->get();
            $jenis_identitas = CompOption::where('comp_id', 'CIF21')->get();
            $pendidikan_terakhir = CompOption::where('comp_id', 'CIF25')->get();
            $kab_kota = CompOption::where('comp_id', 'CIF13')->get();
            $provinsi = CompOption::where('comp_id', 'CIF14')->get();
            $golongan_darah = CompOption::where('comp_id', 'CIF23')->get();

            return view('apps.calon_nasabah.detail-approve')
                ->with('nasabah', $nasabah)
                ->with('jenis_kelamin', $jenis_kelamin)
                ->with('agama', $agama)
                ->with('status_nikah', $status_nikah)
                ->with('status_penduduk', $status_penduduk)
                ->with('kewarganegaraan', $kewarganegaraan)
                ->with('jenis_identitas', $jenis_identitas)
                ->with('pendidikan_terakhir', $pendidikan_terakhir)
                ->with('kab_kota', $kab_kota)
                ->with('provinsi', $provinsi)
                ->with('golongan_darah', $golongan_darah);
        } else {
            return Redirect::to('nasabah_request')
                ->with('error', 'Data not found');
        }
    }

    public function showImageFromServer($imageName)
    {
        $baseUrl = "http://108.137.154.8:8081/ARRest/images";
        $imageUrl = $baseUrl . $imageName;

        return view('calon_nasabah.list', ['imageUrl' => $imageUrl]);
    }

    public function listJson(Request $request)
    {
        // Memeriksa pengguna yang terautentikasi
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Ambil branchid dari body request
        $branchid = $request->input('branchid');

        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));

        // Filter data berdasarkan branchid jika tersedia
        $data = DataCalonNasabah::select('*')
            ->when($branchid, function ($query, $branchid) {
                return $query->where('branchid', $branchid);
            })
            ->whereIn('status', [2, 3, 4]);

        if ($request->has('search')) {
            $data = $data->whereRaw('lower(name) like (?)', ["%{$request->search}%"]);
        }

        $total = $data->count();

        if ($request->has('order_type')) {
            if ($request->get('order_type') == 'asc') {
                if ($request->has('order_by')) {
                    $data->orderBy($request->get('order_by'));
                } else {
                    $data->orderBy('request_time');
                }
            } else {
                if ($request->has('order_by')) {
                    $data->orderBy($request->get('order_by'), 'desc');
                } else {
                    $data->orderBy('request_time', 'desc');
                }
            }
        } else {
            $data->orderBy('request_time', 'desc');
        }

        $data = $data->get();

        foreach ($data as $nasabah) {
            if ($nasabah->status == 1) {
                $nasabah->status_text = 'Accepted';
            } else {
                $nasabah->status_text = 'Rejected';
            }
        }

        return response()->json([
            'status' => true,
            'data' => $data,
            'username' => $user->username,
        ]);
    }


}
