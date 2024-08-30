<?php
// Connect to ARDI

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;
use Carbon\Carbon;
use Validator;
use Excel;
use App\Exports\TransactionBJBExport;
use App\Exports\TransactionFeeLakupandaiExport;
use App\Exports\TransactionFeeSaleExport;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\TransactionBJBCreateRequest;
use App\Http\Requests\TransactionBJBUpdateRequest;
use App\Repositories\TransactionBJBRepository;
use App\Validators\TransactionBJBValidator;
use Ixudra\Curl\Facades\Curl;

use App\Entities\Merchant;
use App\Entities\Service;
use App\Entities\TransactionBJB;
use App\Entities\Group;
use App\Entities\UserGroup;
use App\Entities\Revenue;
use App\Entities\Transaction;
use App\Entities\GroupSchema;
use App\Entities\GroupSchemaShareholder;
use App\Entities\TransactionLog;
use App\Http\Requests\TransactionSaleBJBUpdateRequest;
use App\Repositories\TransactionSaleBJBRepository;
use App\Validators\TransactionSaleBJBValidator;

/**
 * Class TransactionBJBsController.
 *
 * @package namespace App\Http\Controllers;
 */
class TransactionSaleBJBController extends Controller
{
    /**
     * @var TransactionSaleBJBRepository
     */
    protected $repository;

    /**
     * @var TransactionSaleBJBValidator
     */
    protected $validator;

    /**
     * TransactionBJBsController constructor.
     *
     * @param TransactionSaleBJBRepository $repository
     * @param TransactionSaleBJBValidator $validator
     */
    public function __construct(TransactionSaleBJBRepository $repository, TransactionSaleBJBValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexSale(Request $request)
    {

        // if(!$request->has('status') && $request->get('status')==''){
        //     $request->request->add([
        //         'status'  => 'Success'
        //     ]);
        // }
        if(!$request->has('start_date') && $request->get('start_date')==''){
            $request->request->add([
                'start_date'      => date("Y-m-d")
            ]);
        }
        if(!$request->has('end_date') && $request->get('end_date')==''){
            $request->request->add([
                'end_date'      => date("Y-m-d")
            ]);
        }
        // $request->request->add([
        //     'group_id'  => 1,
        //     'date'      => date("Y-m-d"),
        //     'schema_id' => 1,
        // ]);

        // $credentials = $request->only('group_id', 'date', 'schema_id');
        // $rules = [
        //     'group_id'  => 'required',
        //     'schema_id' => 'required',
        //     'date'      => 'required',
        // ];
        
        // $validator = Validator::make($credentials, $rules);
        // if($validator->fails()) {
        //     return response()->json(['status'=> false, 'error'=> $validator->messages()],403);
        // }

        // $getInfo    = $this->getInfo($request)->original;
        
        // $dataRevenue= (object) $getInfo;
        // $data->merchants = $sorted;
        
        // $response = [   
        //     'status'    => true, 
        //     'message'   => 'Success',
        //     'data'      => $data,
        // ];

        // return response()->json($response, 200);

        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));

        $data = TransactionBJB::select('*');
        $data->where('proc_code', '==', '500000');
        // dd($request->get('search'));die();

        if($request->has('search') && $request->get('search')!=''){
            $data->where(function($query) use ($request)
            {
                $query->where('stan', 'like', '%' . $request->get('search') . '%')
                ->orWhere('additional_data', 'like', '%'.$request->get("search").'%')
                ->orWhere('responsecode', 'like', '%' . $request->get('search') . '%')
                ->orWhere('message_status', 'like', '%' . $request->get('search') . '%')
                ->orWhere('tx_pan', 'like', '%' . $request->get('search') . '%')
                ->orWhere('src_account', 'like', '%' . $request->get('search') . '%')
                ->orWhere('dst_account', 'like', '%' . $request->get('search') . '%');
            });
        }

        if($request->has('start_date') && $request->get('start_date')!=''){
            $data->where('tx_time', '>', $request->get('start_date').' 00:00:00');
        }

        if($request->has('end_date') && $request->get('end_date')!=''){
            $data->where('tx_time', '<=', $request->get('end_date').' 23:59:59');
        }

        if($request->has('responsecode') && $request->get('responsecode')!=''){
            $data->where('responsecode', '=', $request->get('responsecode'));
        }

        if($request->has('stan') && $request->get('stan')!=''){
            $data->where('stan', '=', $request->get('stan'));
        }

        if($request->has('additional_data') && $request->get('additional_data')!=''){
            $data->where('additional_data', '=', $request->get('additional_data'));
        }

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
                } else {
                    $data->orderBy('tx_time');
                }
            } else {
                if($request->has('order_by')){
                    $data->orderBy($request->get('order_by'), 'desc');
                }else{
                    $data->orderBy('tx_time', 'desc');
                }
            }
        } else {
            $data->orderBy('tx_time', 'desc');
        }

        $dataRevenue = Array();
        $dataRevenue['total_trx'] = $data->count();
        $dataRevenue['amount_trx']   = $data->sum('nominal');
        // $dataRevenue['amount_trx']   = $data->sum('tx_amount');

        $total = $data->count();
        //	dd($data->toSql());die();
        $data = $data->paginate(10);
        // dd($data->toSql());die();
        
        foreach($data as $item){
            if($item->responsecode == '00' && $item->tx_mti == '0200'){
                $item->status_text = 'Success';
            } else if($item->responsecode !== '00' && $item->tx_mti == '0200'){
                $item->status_text = 'Failed';
            }

            if($item->responsecode == '00' && $item->tx_mti == '0400'){
                $item->status_reversal = 'Reversal Success';
            } else if($item->responsecode !== '00' && $item->tx_mti == '0400'){
                $item->status_reversal = '-';
            }
        }

        // dd($dataRevenue); die();

        return view('apps.transactionSaleBjb.list')
                ->with('data', $data)
                ->with('dataRevenue', $dataRevenue);
    }

    public function updateBjb(TransactionSaleBJBUpdateRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);
            $transaction = TransactionLog::where('stan', $id);
            foreach($transaction as $trx){
                if($trx->proc_code == '500000') {
                    $reqData['tx_mti']               = '0400';
                    $reqData['rp_mti']               = '0410';

                    $data = $this->repository->update($reqData, $id);
        
                    if($data){    
                        DB::commit();
                        return Redirect::to('transactionSaleBJB')
                                            ->with('message', 'Status updated');
                    }else{
                        DB::rollBack();
                        return Redirect::to('transactionSaleBJB')
                                    ->with('error', $data->error)
                                    ->withInput();
                    }
                }
            }
        } catch (Exception $e) {
            DB::rollBack();
            return Redirect::to('transactionSaleBJB')
                        ->with('error', $e)
                        ->withInput();
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            return Redirect::to('transactionSaleBJB')
                        ->with('error', $e)
                        ->withInput();
        }
    }
        /**
     * Update the specified resource in storage.
     *
     * @param  TransactionSaleBJBUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
}
