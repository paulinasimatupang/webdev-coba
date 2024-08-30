<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Redirect;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Entities\Screen; 
use App\Entities\ScreenType; 

class ScreenController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Screen::query();

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
        $screen_type = ScreenType::all();

        $user = session()->get('user');

        return view('apps.screen.list')
            ->with('data' , $data)
            ->with('screen_type',$screen_type)
            ->with('username', $user->username);
    }

    public function create(Request $request){
        $screen_type = ScreenType::query()->get();
        return view('apps.screen.add')
                ->with('screen_type', $screen_type);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'screen_id' => 'required|string|max:7',
                'screen_type_id' => 'required|string|max:2',
                'screen_title' => 'required|string|max:100',
                'version' => 'required|string|max:10',
                'action_url' => 'nullable|string|max:256',
            ]);
            $screen = new Screen();
            $screen->screen_id = $validatedData['screen_id'];
            $screen->screen_type_id = $validatedData['screen_type_id'];
            $screen->screen_title = $validatedData['screen_title'];
            $screen->version = $validatedData['version'];
            $screen->action_url = $validatedData['action_url'];
            $screen->save();
            return Redirect::to('screen')->with('success', 'Data berhasil disimpan.');
        } catch (\Exception $e) {
            return Redirect::to('screen/create')->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $screen = Screen::findOrFail($id);
        $screen_type = ScreenType::all();
        return view('apps.screen.edit', compact('screen', 'screen_type'));
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'screen_id' => 'required|string|max:7',
                'screen_type_id' => 'required|string|max:2',
                'screen_title' => 'required|string|max:100',
                'version' => 'required|string|max:10',
                'action_url' => 'nullable|string|max:256',
            ]);

            $screen = Screen::findOrFail($id);
            $screen->screen_id = $validatedData['screen_id'];
            $screen->screen_type_id = $validatedData['screen_type_id'];
            $screen->screen_title = $validatedData['screen_title'];
            $screen->version = $validatedData['version'];
            $screen->action_url = $validatedData['action_url'];
            $screen->save();

            return Redirect::to('screen')->with('success', 'Data berhasil disimpan.');
        } catch (\Exception $e) {
            return Redirect::route('screen_edit', $id)
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())
                ->withInput();
        }
    }


    public function destroy($id)
    {
        try {
            $screen = Screen::findOrFail($id);
            $screen->delete();
            return response()->json(['success' => 'Data berhasil dihapus.']); 
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage()], 500); 
        }

    }
}
