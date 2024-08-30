<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Redirect;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Controllers\Controller;
use App\Entities\Component;
use App\Entities\ComponentType;
use App\Entities\ComponentContentType;

class ComponentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Component::query();

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
        $component_type = ComponentType::all();
        $component_content_type = ComponentContentType::all();
        $user = session()->get('user');

        return view('apps.component.list')
            ->with('data', $data)
            ->with('component_type', $component_type)
            ->with('component_content_type', $component_content_type)
            ->with('username', $user->username);
    }

    public function create(Request $request){
        $component_type = ComponentType::all();
        $component_content_type = ComponentContentType::all();
        return view('apps.component.add')
                ->with('component_type', $component_type)
                ->with('component_content_type', $component_content_type);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'comp_id' => 'required|string|max:5',
                'component_type_id' => 'required|string|max:2',
                'comp_content_type' => 'required|string|max:2',
                'visible' => ['required', 'string', 'in:t,f'],
                'comp_lbl' => 'required|string|max:100',
                'comp_act' => 'nullable|string|max:100',
                'mandatory' => ['required', 'string', 'in:t,f'],
                'disabled' => ['required', 'string', 'in:t,f'],
                'min_length' => 'required|integer|max:4',
                'max_length' => 'required|integer|max:4',
                'comp_lbl_en' => 'nullable|string|max:100',
            ]);
            
            $component = new Component();
            $component->comp_id = $validatedData['comp_id'];
            $component->component_type_id = $validatedData['component_type_id'];
            $component->comp_content_type = $validatedData['comp_content_type'];
            $component->visible = $validatedData['visible'];
            $component->comp_lbl = $validatedData['comp_lbl'];
            $component->comp_act = $validatedData['comp_act'];
            $component->mandatory = $validatedData['mandatory'];
            $component->disabled = $validatedData['disabled'];
            $component->min_length = $validatedData['min_length'];
            $component->max_length = $validatedData['max_length'];
            $component->comp_lbl_en = $validatedData['comp_lbl_en'];
            $component->save();
            return Redirect::to('component')->with('success', 'Data berhasil disimpan.');
        } catch (\Exception $e) {
            return Redirect::to('component/create')->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $component = Component::findOrFail($id);
        // dd($component);
        $component_type = ComponentType::all();
        $component_content_type = ComponentContentType::all();
        return view('apps.component.edit')
                ->with('component', $component)
                ->with('component_type', $component_type)
                ->with('component_content_type', $component_content_type);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'comp_id' => 'required|max:255',
            'comp_lbl' => 'required|max:255',
            'comp_act' => 'nullable|max:255',
            'comp_lbl_en' => 'nullable|max:255',
            'min_length' => 'required|numeric|min:1',
            'max_length' => 'required|numeric|min:1|gte:min_length',
            'component_type_id' => 'required',
            'component_content_type' => 'required',
            'visible' => ['required', 'string', 'in:t,f'],
            'mandatory' => ['required', 'string', 'in:t,f'],
            'disabled' => ['required', 'string', 'in:t,f'],
        ]);

        try {
            $component = Component::find($id);
            if (!$component) {
                return redirect()->route('component_edit', $id)
                    ->with('error', 'Component not found.');
            }

            $component->update([
                'comp_id' => $request->comp_id,
                'comp_lbl' => $request->comp_lbl,
                'comp_act' => $request->comp_act,
                'comp_lbl_en' => $request->comp_lbl_en,
                'min_length' => $request->min_length,
                'max_length' => $request->max_length,
                'component_type_id' => $request->component_type_id,
                'component_content_type' => $request->component_content_type,
                'visible' => $request->visible,
                'mandatory' => $request->mandatory,
                'disabled' => $request->disabled,
            ]);

            return redirect()->route('component', $id)
                ->with('success', 'Component updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Update error:', [
                'message' => $e->getMessage(),
                'data' => $request->all(),
                'errors' => $e->getTraceAsString(),
            ]);
            return redirect()->route('component_edit', $id)
                ->with('error', 'An error occurred while saving the data: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $component = Component::findOrFail($id);
            $component->delete();
            return Redirect::to('component')->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            return Redirect::route('component')
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}
