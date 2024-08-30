<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\BillerCreateRequest;
use App\Http\Requests\BillerUpdateRequest;
use App\Repositories\BillerRepository;
use App\Validators\BillerValidator;
use App\Entities\Biller;
use Exception;

class BillersController extends Controller
{
    protected $repository;
    protected $validator;

    public function __construct(BillerRepository $repository, BillerValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    public function index(Request $request)
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));

        $data = Biller::select('*');

        if ($request->has('search')) {
            $data = $data->whereRaw('lower(name) like (?)', ["%{$request->search}%"]);
        }

        if ($request->has('status')) {
            $data = $data->where('status', $request->status);
        }

        $total = $data->count();

        if ($request->has('limit')) {
            $data->take($request->get('limit'));

            if ($request->has('offset')) {
                $data->skip($request->get('offset'));
            }
        }

        if ($request->has('order_type')) {
            $orderType = $request->get('order_type') == 'asc' ? 'asc' : 'desc';
            $orderBy = $request->has('order_by') ? $request->get('order_by') : 'created_at';
            $data->orderBy($orderBy, $orderType);
        } else {
            $data->orderBy('created_at', 'desc');
        }

        $data = $data->get();

        // Ambil username dari autentikasi atau sesi
        $username = auth()->user() ? auth()->user()->username : '';

        return view('apps.billers.list', compact('data', 'total', 'username'));
    }

    public function create()
    {
        // Ambil data yang dibutuhkan di halaman create
        $groups = Biller::all(); // Misalnya Anda ingin menampilkan semua biller sebagai opsi grup

        return view('apps.billers.add', compact('groups'));
    }

    public function store(BillerCreateRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $data = $this->repository->create($request->all());

            DB::commit();

            return redirect()->route('billers')->with('success', 'Biller created.');
        } catch (ValidatorException $e) {
            DB::rollBack();

            return redirect()->route('billers_create')->withErrors($e->getMessageBag())->withInput();
        } catch (Exception $e) {
            DB::rollBack();

            // Log error
            \Log::error('Error creating biller: ', ['error' => $e->getMessage()]);

            return redirect()->route('billers_create')->with('error', 'Something went wrong!')->withInput();
        }
    }

    public function edit($id)
    {
        try {
            $data = $this->repository->findOrFail($id); // Gunakan findOrFail untuk menangani data tidak ditemukan

            return view('apps.billers.edit', compact('data'));
        } catch (Exception $e) {
            return redirect()->route('billers')->with('error', 'Biller not found: ' . $e->getMessage());
        }
    }

    public function update(BillerUpdateRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $data = $this->repository->update($request->all(), $id);

            DB::commit();

            return redirect()->route('billers')->with('success', 'Biller updated.');
        } catch (ValidatorException $e) {
            DB::rollBack();

            return redirect()->route('billers_edit', $id)->withErrors($e->getMessageBag())->withInput();
        } catch (Exception $e) {
            DB::rollBack();

            // Log error
            \Log::error('Error updating biller: ', ['error' => $e->getMessage()]);

            return redirect()->route('billers_edit', $id)->with('error', 'Something went wrong!')->withInput();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            // Temukan Biller berdasarkan ID atau lemparkan pengecualian jika tidak ditemukan
            $biller = $this->repository->findOrFail($id);

            // Hapus Biller dari database
            $biller->delete();

            DB::commit();

            return redirect()->route('billers')->with('success', 'Biller berhasil dihapus.');
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->route('billers')
                ->with('error', 'Terjadi kesalahan saat menghapus biller: ' . $e->getMessage());
        }
    }
}
