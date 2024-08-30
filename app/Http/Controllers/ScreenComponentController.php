<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\ScreenComponent;
use App\Entities\Screen;
use App\Entities\Component;

class ScreenComponentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = ScreenComponent::query();

        if ($request->has('search')) {
            $data->whereRaw('lower(comp_id) like ?', ["%{$request->search}%"]);
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
        $screens = Screen::all();
        $components = Component::all();

        $user = session()->get('user');

        return view('apps.screencomponent.list')
            ->with('data' , $data)
            ->with('screens', $screens)
            ->with('components', $components)
            ->with('username', $user->username);
    }

    public function create(Request $request)
    {
        $screens = Screen::all();
        $components = Component::all();
        return view('apps.screencomponent.add')
                ->with('screens', $screens)
                ->with('components', $components);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'screen_id' => 'required|string|max:7',
                'comp_id' => 'required|string|max:10',
                'sequence' => 'required|integer',
            ]);

            $screenComponent = new ScreenComponent();
            $screenComponent->screen_id = $validatedData['screen_id'];
            $screenComponent->comp_id = $validatedData['comp_id'];
            $screenComponent->sequence = $validatedData['sequence'];
            $screenComponent->save();

            return redirect()->route('screen_component')->with('success', 'Data berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->route('screen_component_create')->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $screenComponent = ScreenComponent::findOrFail($id);
        $screens = Screen::all();
        $components = Component::all();

        return view('apps.screencomponent.edit', compact('screenComponent', 'screens', 'components'));
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'screen_id' => 'required|string|max:7',
                'comp_id' => 'required|string|max:10',
                'sequence' => 'required|integer',
            ]);
            $screenComponent = ScreenComponent::where('screen_id', $validatedData['screen_id'])
                ->where('comp_id', $validatedData['comp_id'])
                ->first();

            if ($screenComponent) {
                $screenComponent->sequence = $validatedData['sequence'];
                $screenComponent->save();
                
                return redirect()->route('screen_component')->with('success', 'Data berhasil diperbarui.');
            } else {
                return redirect()->route('screen_component_edit', $id)
                    ->with('error', 'Data tidak ditemukan.')
                    ->withInput();
            }
        } catch (\Exception $e) {
            return redirect()->route('screen_component_edit', $id)
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage())
                ->withInput();
        }
    }    

    public function destroy($id)
    {
        try {
            $screenComponent = ScreenComponent::findOrFail($id);
            $screenComponent->delete();

            return redirect()->route('screen_component')->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('screen_component_edit')->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}
