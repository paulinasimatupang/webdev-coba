<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Redirect;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Controllers\Controller;
use App\Entities\Service;
use App\Entities\ServiceMeta;


class ServiceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Service::query();

        if ($request->has('search')) {
            $data->whereRaw('lower(name) like ?', ["%{$request->search}%"]);
        }

        if ($request->has('status')) {
            $data->where('status', $request->status);
        }

        $total = $data->count();

        if ($request->has('limit')) {
            $data->limit($request->get('limit'));

            if ($request->has('offset')) {
                $data->offset($request->get('offset'));
            }
        }

        if ($request->has('order_type') && $request->has('order_by')) {
            $orderType = $request->get('order_type') == 'asc' ? 'asc' : 'desc';
            $data->orderBy($request->get('order_by'), $orderType);
        }

        $data = $data->get();

        $user = session()->get('user');

        return view('apps.service.list')
            ->with('data', $data)
            ->with('username', $user->username);
    }

    public function create(Request $request){
        return view('apps.service.add');
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'service_id' => 'required|string|max:7',
                'service_name' => 'required|string|max:50',
                'screen_response' => 'nullable|string|max:7', // Ubah dari screen_response ke screen_respon
                'param1' => 'nullable|string|max:32', // Ubah dari param1 ke param_1 jika kolomnya sesuai
            ]);
            $service = new Service();
            $service->service_id = $validatedData['service_id'];
            $service->service_name = $validatedData['service_name'];
            $service->screen_response = $validatedData['screen_response']; // Ubah dari screen_response ke screen_respon
            $service->param1 = $validatedData['param1']; // Ubah dari param1 ke param_1 jika kolomnya sesuai
            $service->save();
            return Redirect::to('service')->with('success', 'Data berhasil disimpan.');
        } catch (\Exception $e) {
            return Redirect::to('service/create')->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())->withInput();
        }
    }


    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('apps.service.edit', compact('service'));
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'service_id' => 'required|string|max:7',
                'service_name' => 'required|string|max:50',
                'screen_response' => 'nullable|string|max:7',
                'param1' => 'nullable|string|max:32',
            ]);
            $service = Service::findOrFail($id);
            $service->service_id = $validatedData['service_id'];
            $service->service_name = $validatedData['service_name'];
            $service->screen_response = $validatedData['screen_response'];
            $service->param1 = $validatedData['param1'];
            $service->save();

            return Redirect::to('service')->with('success', 'Data berhasil disimpan.');
        } catch (\Exception $e) {
            return Redirect::route('service_edit', $id)
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $service = Service::findOrFail($id);
            $service->delete();
            return Redirect::to('service')->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return Redirect::route('service')
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}
