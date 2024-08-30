<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use DB;
use App\Entities\ServiceMeta;
use App\Entities\MetaType;
use App\Entities\Service;
use Exception;
use Illuminate\Support\Facades\Log;

class FeeController extends Controller
{
    public function index()
    {
        try {
            $username = auth()->user()->username; 

           $groups = ServiceMeta::where('meta_id', 'fee')
                ->whereIn('influx', [3])
                ->with('service') 
                ->orderBy('service_id') 
                ->get();

            Log::info('Data ServiceMeta berhasil diambil.', [
                'meta_id' => 'fee',
                'influx_values' => [3],
                'total_groups' => $groups->count(),
            ]);


            return view('apps.fee.list', compact('groups', 'username'));
        } catch (Exception $e) {
            Log::error('Terjadi kesalahan saat memuat data.', [
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
            ]);
            return redirect()->route('fee')
                ->with('error', 'Terjadi kesalahan saat memuat data: ' . $e->getMessage());
        }
    }

    public function create()
    {
        $meta_type = MetaType::all();
        $service = Service::all();
        return view('apps.fee.add', compact('meta_type', 'service'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validatedData = $request->validate([
                'service_id' => 'required|string',
                'meta_id' => 'required|string', // Pastikan 'meta_id' adalah string untuk mengakomodasi 'fee'
                'meta_default' => 'nullable|string',
                'influx' => 'nullable|string',
            ]);

            // Memastikan tidak ada duplikasi record dengan kunci yang sama
            $existingRecord = ServiceMeta::where('meta_id', $validatedData['meta_id'])
                ->where('service_id', $validatedData['service_id'])
                ->where('seq', $request->input('seq'))
                ->first();

            if ($existingRecord) {
                return redirect()->route('fee_create')
                    ->with('error', 'Data sudah ada.')
                    ->withInput();
            }

            ServiceMeta::create($validatedData);
            DB::commit();
            return redirect()->route('fee')->with('success', 'Data berhasil ditambahkan.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('fee_create')
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($meta_id, $service_id, $seq)
    {
        try {
            // Mengambil data dengan ketiga kunci
            $group = ServiceMeta::where([
                ['meta_id', $meta_id],
                ['service_id', $service_id],
                ['seq', $seq]
            ])->firstOrFail();

            return view('apps.fee.edit', compact('group'));
        } catch (Exception $e) {
            return redirect()->route('fee')
                ->with('error', 'Data tidak ditemukan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $meta_id, $service_id, $seq)
    {
        DB::beginTransaction();
        try {
            // Validasi data yang masuk
            $validatedData = $request->validate([
                'meta_default' => 'nullable|string',
            ]);

            // Update meta_default untuk influx 3
            $updated = DB::connection('pgsql_billiton')->table('service_meta')
                ->where('meta_id', '=', $meta_id)
                ->where('service_id', '=', $service_id)
                ->where('seq', '=', $seq)
                ->where('influx', '=', 3)
                ->update([
                    'meta_default' => $request->input('meta_default'),
                ]);

            if ($updated === 0) {
                throw new Exception('Tidak ada record yang diperbarui untuk influx 3.');
            }

            // Update meta_default untuk influx 5 yang memiliki meta_id dan service_id yang sama
            DB::connection('pgsql_billiton')->table('service_meta')
                ->where('meta_id', '=', $meta_id)
                ->where('service_id', '=', $service_id)
                ->where('influx', '=', 5)
                ->update([
                    'meta_default' => $request->input('meta_default'),
                ]);

            DB::commit();
            return redirect()->route('fee')->with('success', 'Data berhasil diperbarui.');
        } catch (Exception $e) {
            DB::rollBack();
            \Log::error('Update failed: ' . $e->getMessage(), [
                'meta_id' => $meta_id,
                'service_id' => $service_id,
                'seq' => $seq,
            ]);
            return redirect()->route('fee_edit', ['meta_id' => $meta_id, 'service_id' => $service_id, 'seq' => $seq])
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            // Mengambil data dengan ID yang sesuai, meta_id 'fee', dan influx 3 atau 5
            $group = ServiceMeta::where('id', $id)
                ->where('meta_id', 'fee')
                ->whereIn('influx', [3, 5])
                ->firstOrFail();

            $group->delete();
            DB::commit();
            return redirect()->route('fee')->with('success', 'Data berhasil dihapus.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('fee')
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}