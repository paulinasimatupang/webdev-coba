<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Entities\PersenFee;
use Exception;

class PersenFeeController extends Controller
{
    public function index()
    {
        try {
            $persenFees = PersenFee::all();
            return view('apps.persen_fee.list', compact('persenFees'));
        } catch (Exception $e) {
            return redirect()->route('persen_fee')
                ->with('error', 'Terjadi kesalahan saat memuat data: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('apps.persen_fee.add');
    }
    
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $idExists = DB::connection('pgsql_billiton')
                ->table('persen_fee')
                ->where('id', $request->input('id'))
                ->exists();
    
            if ($idExists) {
                return redirect()->route('persen_fee_create')
                    ->with('error', 'ID sudah ada, silakan gunakan ID lain.')
                    ->withInput();
            }
    
            $validatedData = $request->validate([
                'id' => 'required|integer',
                'penerima' => 'required|string|max:50',
                'persentase' => 'required|integer',
            ]);
    
            $persenFee = PersenFee::create($validatedData);
    
            DB::commit();
            return redirect()->route('persen_fee')->with('success', 'Persen Fee berhasil ditambahkan.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('persen_fee_create')
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    public function edit($id)
    {
        try {
            $group = PersenFee::findOrFail($id);
            return view('apps.persen_fee.edit', compact('group'));
        } catch (Exception $e) {
            return redirect()->route('persen_fee')
                ->with('error', 'Data tidak ditemukan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $validatedData = $request->validate([
                'penerima' => 'required|string|max:255',
                'persentase' => 'required|numeric',
            ]);

            $group = PersenFee::findOrFail($id);
            $group->update([
                'penerima' => $validatedData['penerima'],
                'persentase' => $validatedData['persentase'],
            ]);

            DB::commit();
            return redirect()->route('persen_fee')->with('success', 'Persen Fee berhasil diperbarui.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('persen_fee_edit', ['id' => $id])
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $group = PersenFee::findOrFail($id);
            $group->delete();
            DB::commit();
            return redirect()->route('persen_fee')->with('success', 'Persen Fee berhasil dihapus.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('persen_fee')
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}
