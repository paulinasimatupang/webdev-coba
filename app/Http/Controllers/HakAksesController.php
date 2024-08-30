<?php

namespace App\Http\Controllers;

use App\Entities\MasterData;
use Illuminate\Http\Request;
use DB;
use Exception;

class HakAksesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $username = auth()->user()->username;
            $groups = MasterData::all();
            return view('apps.hakakses.list', compact('groups', 'username'));
        } catch (Exception $e) {
            return redirect()->route('hakakses')
                ->with('error', 'Terjadi kesalahan saat memuat data: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('apps.hakakses.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'status' => 'required|boolean',
            ]);
    
            // Buat entitas baru tanpa menyetel ID secara manual
            MasterData::create($validatedData);
            DB::commit();
            return redirect()->route('hakakses')->with('success', 'Data berhasil ditambahkan.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('hakakses_create')
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $group = MasterData::findOrFail($id);
            return view('apps.hakakses.edit', compact('group'));
        } catch (Exception $e) {
            return redirect()->route('hakakses')
                ->with('error', 'Data tidak ditemukan: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'status' => 'required|boolean',
            ]);

            $group = MasterData::findOrFail($id);
            $group->update($validatedData);
            DB::commit();
            return redirect()->route('hakakses')->with('success', 'Data berhasil diperbarui.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('hakakses_edit', $id)
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $group = MasterData::findOrFail($id);
            $group->delete();
            DB::commit();
            return redirect()->route('hakakses')->with('success', 'Data berhasil dihapus.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('hakakses')
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }

    public function showChart()
    {
        try {
            // Ambil data yang diperlukan untuk grafik
            $data = MasterData::select('name', 'status', DB::raw('count(*) as total'))
                ->groupBy('name', 'status')
                ->get()
                ->groupBy('name')
                ->map(function ($item) {
                    return $item->pluck('total', 'status')->toArray();
                });

            $labels = array_keys($data->first()); // Nama-nama dari entitas
            $activeData = [];
            $inactiveData = [];

            foreach ($data as $item) {
                $activeData[] = $item[1] ?? 0; // Status 1 untuk aktif
                $inactiveData[] = $item[0] ?? 0; // Status 0 untuk non-aktif
            }

            // Konversi data menjadi format yang dapat digunakan oleh library grafik
            $chartData = [
                'labels' => $labels,
                'datasets' => [
                    [
                        'label' => 'Active',
                        'data' => $activeData,
                        'borderColor' => '#36A2EB',
                        'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                        'fill' => false,
                    ],
                    [
                        'label' => 'Inactive',
                        'data' => $inactiveData,
                        'borderColor' => '#FF6384',
                        'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                        'fill' => false,
                    ],
                ],
            ];

            // Kirim data ke view untuk ditampilkan dalam grafik
            return view('apps.hakakses.chart', compact('chartData'));
        } catch (Exception $e) {
            return redirect()->route('mhakakses_chart')
                ->with('error', 'Terjadi kesalahan saat memuat data grafik: ' . $e->getMessage());
        }
    }
}
