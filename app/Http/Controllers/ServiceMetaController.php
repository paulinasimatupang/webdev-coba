<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use DB;
use App\Entities\ServiceMeta;
use App\Entities\MetaType;
use App\Entities\Service;
use Exception;

class ServiceMetaController extends Controller
{
    public function index()
    {
        try {
            $username = auth()->user()->username; // Cara mendapatkan username
            $groups = ServiceMeta::all();
            return view('apps.servicemeta.list', compact('groups', 'username'));
        } catch (Exception $e) {
            return redirect()->route('servicemeta')
                ->with('error', 'Terjadi kesalahan saat memuat data: ' . $e->getMessage());
        }
    }

    public function create()
    {
        $meta_type = MetaType::all();
        $service = Service::all();
        return view('apps.servicemeta.add', compact('meta_type', 'service'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validatedData = $request->validate([
                'meta_id' => 'required',
                'service_id' => 'required',
                'seq' => 'required',
                'meta_type_id' => 'required',
                'meta_default' => 'nullable',
                'influx' => 'required',
            ]);


            ServiceMeta::create($validatedData);
            DB::commit();
            return redirect()->route('servicemeta')->with('success', 'Data berhasil ditambahkan.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('servicemeta_create')
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        try {
            $group = ServiceMeta::findOrFail($id);
            return view('apps.servicemeta.edit', compact('group'));
        } catch (Exception $e) {
            return redirect()->route('servicemeta')
                ->with('error', 'Data tidak ditemukan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $validatedData = $request->validate([
                'meta_id' => 'required|integer',
                'service_id' => 'required|string',
                'seq' => 'required|integer',
                'meta_type_id' => 'required|string',
                'meta_default' => 'nullable|string',
                'influx' => 'nullable|string',
            ]);

            $group = ServiceMeta::findOrFail($id);
            $group->update($validatedData);
            DB::commit();
            return redirect()->route('servicemeta')->with('success', 'Data berhasil diperbarui.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('servicemeta_edit', $id)
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $group = ServiceMeta::findOrFail($id);
            $group->delete();
            DB::commit();
            return redirect()->route('servicemeta')->with('success', 'Data berhasil dihapus.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('servicemeta')
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}
