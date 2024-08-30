<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Redirect;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\TerminalCreateRequest;
use App\Http\Requests\TerminalUpdateRequest;
use App\Repositories\TerminalRepository;
use App\Validators\TerminalValidator;

use App\Entities\Terminal;
use App\Entities\Merchant;
use App\Entities\TerminalBilliton;
use App\Entities\TerminalUserBilliton;
use App\Entities\UsersBilliton;

/**
 * Class TerminalsController.
 *
 * @package namespace App\Http\Controllers;
 */
class TerminalsController extends Controller
{
    /**
     * @var TerminalRepository
     */
    protected $repository;

    /**
     * @var TerminalValidator
     */
    protected $validator;

    /**
     * TerminalsController constructor.
     *
     * @param TerminalRepository $repository
     * @param TerminalValidator $validator
     */
    public function __construct(TerminalRepository $repository, TerminalValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));

        $data = Terminal::select('*');

	    $data = $data->whereHas('merchant.user', function($query){
            $query->where(function($q){
                $q->where('is_user_mireta', '!=', 1)->orWhereNull('is_user_mireta');
            });
            $query->where(function($q){
                $q->where('is_development_user', '!=', 1)->orWhereNull('is_development_user');
            });
        });

        if($request->has('search')){
            $data = $data->whereRaw('lower(name) like (?)',["%{$request->search}%"]);
        }

        if($request->has('status')){
            $data = $data->where('status',$request->status);
        }

        $total = $data->count();
    
        if($request->has('limit')){
            $data->take($request->get('limit'));
            
            if($request->has('offset')){
            	$data->skip($request->get('offset'));
            }
        }

        if($request->has('order_type')){
            if($request->get('order_type') == 'asc'){
                if($request->has('order_by')){
                    $data->orderBy($request->get('order_by'));
                }else{
                    $data->orderBy('created_at');
                }
            }else{
                if($request->has('order_by')){
                    $data->orderBy($request->get('order_by'), 'desc');
                }else{
                    $data->orderBy('created_at', 'desc');
                }
            }
        }else{
            $data->orderBy('created_at', 'desc');
        } 

        $data = $data->get();

        foreach($data as $item){
            if($item->merchant_id){
                $item->status = 'Used';
            }else{
                $item->status = 'Not Used';
            }
        }

        $user = session()->get('user');

        return view('apps.terminals.list')
                ->with('data', $data)
                ->with('username', $user->username);
    }

    public function create(Request $request){
        $merchant = Merchant::where('terminal_id',null)->orderBy('name')->get();
        $merchant = $merchant->where('status_agen', 1);


        return view('apps.terminals.add')
                ->with('merchant', $merchant);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TerminalCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(TerminalCreateRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);
            $merchant = Merchant::where('id', $request->merchant_id)->first();
            if($merchant){    
                $reqData = $request->all();
                $reqData['merchant_id']             = $merchant->mid;
                $reqData['merchant_name']           = $merchant->name;
                $reqData['merchant_address']        = $merchant->address;
                $reqData['merchant_account_number'] = $merchant->no;
                $data   = $this->repository->create($reqData);
            }else{
                $data   = $this->repository->create($request->all());
            }
            if($data){
                if($merchant){   
                    $merchant->terminal_id = $request->tid;
                    $merchant->save();
                }

                DB::commit();
                return Redirect::to('terminal')
                                    ->with('message', 'Terminal created');
            }else{
                DB::rollBack();
                return Redirect::to('terminal/create')
                            ->with('error', $data->error)
                            ->withInput();
            }
        } catch (Exception $e) {
            DB::rollBack();
                return Redirect::to('terminal/create')
                            ->with('error', $e)
                            ->withInput();
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
                return Redirect::to('terminal/create')
                            ->with('error', $e)
                            ->withInput();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TerminalCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    
    public function activateBilliton(TerminalUpdateRequest $request, $id)
    {
        DB::beginTransaction();
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);
            
            $terminal = Terminal::where('id', $id)->first();
            
            if ($request->has('merchant_id')) {
                $merchant = Merchant::where('mid', $request->merchant_id)->first();
                if ($merchant) {
                    $reqData['merchant_id']             = $merchant->mid;
                    $reqData['merchant_name']           = $merchant->name;
                    $reqData['merchant_address']        = $merchant->address;
                    $reqData['merchant_account_number'] = $merchant->no;
                } else {
                    $reqData['merchant_id']             = null;
                    $reqData['merchant_name']           = null;
                    $reqData['merchant_address']        = null;
                    $reqData['merchant_account_number'] = null;
                }

                $data = $this->repository->update($reqData, $id);
            }

            if ($terminal) {
                $terminalBilliton = new TerminalBilliton();
                $terminalBilliton->terminal_id          = $terminal->tid;
                $terminalBilliton->terminal_type        = '1';
                $terminalBilliton->terminal_imei        = $terminal->imei;
                $terminalBilliton->terminal_name        = $terminal->serial_number;
                $terminalBilliton->merchant_id          = $terminal->merchant_id;
                $terminalBilliton->terminal_sim_number  = $terminal->iccid;
                $terminalBilliton->save();

                if ($terminalBilliton) {
                    $user = UsersBilliton::select('*')
                                        ->orderBy('user_uid', 'desc')
                                        ->first();

                    if ($user) {
                        $userId = (int)$user->user_uid + 1;
                        $usersBilliton = UsersBilliton::create([
                                'user_uid'                  => $userId,
                                'user_status_uid'           => 1,
                                'user_type_uid'             => 1,
                                'username'                  => $terminal->tid,
                                'version'                   => '1.7',
                                'brand'                     => $terminal->merchant_name,
                                'model'                     => $terminal->merchant_address,
                                'os_ver'                    => 'AGEN BJB BISA',
                                'account_name'              => $terminal->merchant_account_number,
                                'app_ver'                   => $terminal->sid,
                                'need_approval'             => 't',
                                'batch_no'                  => 0,
                            ]);

                        if ($usersBilliton) {
                            $terminalUserBilliton = TerminalUserBilliton::create([
                                'terminal_id'               => $terminal->tid,
                                'user_uid'                  => $userId,
                                ]);

                            if ($terminalUserBilliton) {
                                DB::commit();
                                return Redirect::to('terminal')
                                                    ->with('success', 'Activate Successfully');
                            } else {
                                DB::rollback();
                                return Redirect::to('terminal')
                                                    ->with('failed', 'Activate Failed');
                            }
                        } else {
                            DB::rollback();
                            return Redirect::to('terminal')
                                                ->with('failed', 'Activate Failed');
                        }
                    } else {
                        DB::rollback();
                        return Redirect::to('terminal')
                                            ->with('failed', 'Activate Failed');
                    }
                }
            }
    }

    public function updateBilliton(TerminalUpdateRequest $request, $id)
    {
        DB::beginTransaction();
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);
            
            $terminal = Terminal::where('id', $id)->first();

            if ($terminal) {
                $terminalBilliton = new TerminalBilliton();
                $terminalBilliton->terminal_id          = $terminal->tid;
                $terminalBilliton->terminal_type        = '1';
                $terminalBilliton->terminal_imei        = $terminal->imei;
                $terminalBilliton->terminal_name        = $terminal->serial_number;
                $terminalBilliton->merchant_id          = $terminal->merchant_id;
                $terminalBilliton->terminal_sim_number  = $terminal->iccid;
                $terminalBilliton->save();

                if ($terminalBilliton) {
                    DB::commit();
                    return Redirect::to('terminal')
                                                    ->with('success', 'Update Successfully');
                } else {
                    DB::rollback();
                    return Redirect::to('terminal')
                                                    ->with('failed', 'Update Failed');
                }
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->repository->find($id);
        
        $response = [
            'status'  => true,
            'message' => 'Success',
            'data'    => $data,
        ];

        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $terminal = Terminal::find($id);
        $checkTerminalBilliton = false;
        if($terminal){
            $terminalBilliton = TerminalBilliton::where('terminal_imei', $terminal->imei)
                                                ->first();

            if($terminalBilliton){
                $checkTerminalBilliton = true;
                $tidBilliton = $terminalBilliton->terminal_id;
            } else {
                $checkTerminalBilliton = false;
                $tidBilliton = " ";
            }

            $merchant = Merchant::where('terminal_id',null)
                                ->orWhere('terminal_id',$terminal->tid)
                                ->orderBy('name')
                                ->get();

            return view('apps.terminals.edit')
                ->with('terminal', $terminal)
                ->with('merchant', $merchant)
                ->with('tidBilliton', $tidBilliton)
                ->with('checkTerminalBilliton', $checkTerminalBilliton);
        } else {
            return Redirect::to('terminal')
                            ->with('error', 'Data not found');
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TerminalUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(TerminalUpdateRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $reqData = $request->all();

            if ($request->has('merchant_id')) {
                $merchant = Merchant::where('mid', $request->merchant_id)->first();
                if ($merchant) {
                    $reqData['merchant_id'] = $merchant->mid;
                    $reqData['merchant_name'] = $merchant->name;
                    $reqData['merchant_address'] = $merchant->address;
                    $reqData['merchant_account_number'] = $merchant->no;
                } else {
                    $reqData['merchant_id'] = null;
                    $reqData['merchant_name'] = null;
                    $reqData['merchant_address'] = null;
                    $reqData['merchant_account_number'] = null;
                }
            }

            $data = $this->repository->update($reqData, $id);

            if (!$data) {
                DB::rollBack();
                return Redirect::to('terminal/'.$id.'/edit')->with('error', 'Failed to update terminal data.');
            }

            $terminalBilliton = TerminalBilliton::where('terminal_id', $request->get('tid'))->first();
            if ($terminalBilliton) {
                $terminalBilliton->update([
                    'terminal_sim_number' => $request->get('iccid'),
                    'terminal_name' => $request->get('serial_number'),
                    'terminal_imei' => $request->get('imei'),
                ]);
            } else {
                DB::rollBack();
                return Redirect::to('terminal/'.$id.'/edit')->with('error', 'TerminalBilliton not found for terminal_id: ' . $request->get('tid'));
            }

            DB::commit();
            return Redirect::to('terminal')->with('message', 'Terminal updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::to('terminal/'.$id.'/edit')
                        ->with('error', $e->getMessage())
                        ->withInput();
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            return Redirect::to('terminal/'.$id.'/edit')
                        ->with('error', $e->getMessage())
                        ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $data = Terminal::find($id);
            if($data){
                if($data->merchant_id != null){
                    $merchant = Merchant::where('mid',$data->merchant_id)->first();
                    if($merchant){
                        $merchant->terminal_id = null;
                        $merchant->save();
                    }
                }
            }
            $deleted = $this->repository->delete($id);

            if($deleted){
                $response = [
                    'status'  => true,
                    'message' => 'Terminal deleted.'
                ];
    
                DB::commit();
                return response()->json($response, 200);
            }
            
        } catch (Exception $e) {
            // For rollback data if one data is error
            DB::rollBack();

            return response()->json([
                'status'    => false, 
                'error'     => 'Something wrong!',
                'exception' => $e
            ], 500);
        } catch (\Illuminate\Database\QueryException $e) {
            // For rollback data if one data is error
            DB::rollBack();

            return response()->json([
                'status'    => false, 
                'error'     => 'Something wrong!',
                'exception' => $e
            ], 500);
        }
    }

    public function deleteMerchantData($id, $mid){
        $terminal = Terminal::find($id);
        if($terminal){
            $terminal->merchant_id = null;
            $terminal->merchant_name = null;
            $terminal->merchant_address = null;
            $terminal->merchant_account_number = null;
            $terminal->save();
        }

        $merchant = Merchant::where('mid',$mid)->first();
        if($merchant){
            $merchant->terminal_id = null;
            $merchant->save();
        }
    }
}
