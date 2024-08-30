<?php
// Connect to ARDI

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;
use Carbon\Carbon;
use Validator;
use Redirect;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\TransactionCreateRequest;
use App\Http\Requests\TransactionUpdateRequest;
use App\Repositories\TransactionRepository;
use App\Validators\TransactionValidator;
use Ixudra\Curl\Facades\Curl;

use App\Entities\Merchant;
use App\Entities\Service;
use App\Entities\Transaction;
use App\Entities\TransactionStatus;
use App\Entities\transactionPaymentStatus;
use App\Entities\Group;
use App\Entities\UserGroup;
use App\Entities\GroupSchema;
use App\Entities\GroupSchemaShareholder;
use App\Entities\TransactionBJB;
use App\Entities\TransactionLog;
use App\Entities\TransactionSaleBJB;
use App\Exports\TransactionExport;
use App\Exports\TransactionSaleExport;
use App\Exports\TransactionFeeSaleExport;
use App\Http\Controllers\CoresController as Core;
use App\Http\Requests\TransactionBJBUpdateRequest;
use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

/**
 * Class TransactionsController.
 *
 * @package namespace App\Http\Controllers;
 */
class TransactionBJBsController extends Controller
{
    /**
     * @var TransactionRepository
     */
    protected $repository;

    /**
     * @var TransactionValidator
     */
    protected $validator;

    /**
     * TransactionsController constructor.
     *
     * @param TransactionRepository $repository
     * @param TransactionValidator $validator
     */
    public function __construct(TransactionRepository $repository, TransactionValidator $validator)
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
        // $request->request->add([
        //     'group_id'  => 1,
        //     'date'      => date("Y-m-d H:i:s"),
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

        if(!$request->has('status') && $request->get('status')==''){
            $request->request->add([
                'status'  => 'Success'
            ]);
        }
        if(!$request->has('start_date') && $request->get('start_date')==''){
            $request->request->add([
                'start_date'      => date("m-d-Y")
            ]);
        }
        if(!$request->has('end_date') && $request->get('end_date')==''){
            $request->request->add([
                'end_date'      => date("m-d-Y")
            ]);
        }

        // $getInfo     = $this->getInfo($request)->original;
        // // $dataRevenue = (object) $getInfo;


        // $dataCalculate  = $this->calculateOnly();
        
        // $response = [   
        //     'status'    => true, 
        //     'message'   => 'Success',
        //     'data'      => $dataRevenue,
        // ];

        // return response()->json($response, 200);

        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));

        $data = TransactionBJB::select('*');
        $data = $data->with(['merchant.terminal','merchant.user','service.product.provider.category','transactionStatus','transactionPaymentStatus']);

        // if($request->has('search') && $request->get('search')!=''){
        //     $data->where('code', 'like', '%'.$request->get('code').'%');
        // }

        if(session()->get('user')->role_id == 2) {
            // $data = $data->where('terminal_id', '=', $request->get('tid'));
            $data->whereHas('merchant',function($query) use ($request)
                {
                    $query->where('terminal_id', '=', session()->get('user')->username);
                });
        }

        if($request->has('start_date') && $request->get('start_date')!=''){
            $data->where('created_at', '>', $request->get('start_date').' 00:00:00');
        }

        if($request->has('end_date') && $request->get('end_date')!=''){
            $data->where('created_at', '<=', $request->get('end_date').' 23:59:59');
        }


        if($request->has('tid') && $request->get('tid')!=''){
            $data->whereHas('merchant',function($query) use ($request)
                {
                    $query->where('terminal_id', '=', $request->get('tid'));
                });
            // $data->whereHas('merchant.terminal.tid', '=', $request->get('tid'));
        }
        if($request->has('mid') && $request->get('mid')!=''){
            // $data->where('merchant.mid', '=', $request->get('mid'));
            $data->whereHas('merchant',function($query) use ($request)
                {
                    $query->where('mid', '=', $request->get('mid'));
                });
        }
        if($request->has('agent_name') && $request->get('agent_name')!=''){
            // $data->where('merchant.name', '=', $request->get('agent_name'));
            $data->whereHas('merchant',function($query) use ($request)
                {
                    $query->where('name', '=', $request->get('agent_name'));
                });
        }
        if($request->has('status') && $request->get('status')!='' && $request->get('status')!='Select Status'){
            $status = $request->get('status');
            if ($status == 'Pending'){
                $data->where('status', '=', 0);
            }
            else if ($status == 'Success'){
                $data->where('status', '=', 1);
                
            } else if ($status == 'Failed'){
                $data->where('status', '=', 2);
            }
            
        }
        if($request->has('stan') && $request->get('stan')!=''){
            $data->where('stan', '=', $request->get('stan'));
        }
        // if($request->has('service') && $request->get('service')!=''){
        //     $data->where('service.product.name', '=', $request->get('service'));
        // }
    
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
        $data->where('is_development','!=',1);
        $data->where('is_marked_as_failed','!=',1);

        $dataRevenue = Array();
        $dataRevenue['total_trx'] = $data->count();
        $dataRevenue['amount_trx']   = $data->sum('price');
        $dataRevenue['total_fee']   = $data->sum('price') - $data->sum('vendor_price');
        $dataRevenue['total_fee_agent']   = $dataRevenue['total_fee'] * 0.6;
        $dataRevenue['total_fee_bjb']   = $dataRevenue['total_fee'] * 0.2;
        $dataRevenue['total_fee_selada']   = $dataRevenue['total_fee'] * 0.2;

        $total = $data->count();

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

        $data = $data->paginate(10);
        // dd($data->toSql());die();
        
        foreach($data as $item){
            if($item->status == 0){
                $item->status_text = 'Pending';
            }

            if($item->status == 1){
                $item->status_text = 'Success';
            }

            if($item->status == 2){
                $item->status_text = 'Failed';
            }

            $item->fee = $item->price - $item->vendor_price;

            if($item->is_suspect == 0){
                $item->status_suspect = 'False';
            }

            if($item->is_suspect == 1){
                $item->status_suspect = 'True';
            }
        }

        $user = session()->get('user');

        return view('apps.transactionsBJB.list')
                ->with('data', $data)
                // ->with('dataRevenue', $dataRevenue);
                ->with('dataRevenue', $dataRevenue)
                ->with('username', $user->username);
    }

    public function export(Request $request)
    {

        if(!$request->has('status') && $request->get('status')==''){
            $request->request->add([
                'status'  => 'Success'
            ]);
        }
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
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));

        return (new TransactionExport($request))->download('transaction_export_'.$request->get('start_date').'_'.$request->get('end_date').'.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function saleExport(Request $request)
    {

        if(!$request->has('status') && $request->get('status')==''){
            $request->request->add([
                'status'  => 'Success'
            ]);
        }
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
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));

        return (new TransactionSaleExport($request))->download('transaction_sale_export_'.$request->get('start_date').'_'.$request->get('end_date').'.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function exportCSV(Request $request)
    {

        if(!$request->has('status') && $request->get('status')==''){
            $request->request->add([
                'status'  => 'Success'
            ]);
        }
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
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));

        return (new TransactionExport($request))->download('transaction_export_'.$request->get('start_date').'_'.$request->get('end_date').'.csv', \Maatwebsite\Excel\Excel::CSV,[
                'Content-Type' => 'text/csv'
        ]);
    }

   public function exportPDF(Request $request)
    {

        if(!$request->has('status') && $request->get('status')==''){
            $request->request->add([
                'status'  => 'Success'
            ]);
        }
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
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));

        return (new TransactionExport($request))->download('transaction_export_'.$request->get('start_date').'_'.$request->get('end_date').'.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }

    public function feeExport(Request $request)
    {

        if(!$request->has('status') && $request->get('status')==''){
            $request->request->add([
                'status'  => 'Success'
            ]);
        }
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
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));

	    return (new TransactionFeeSaleExport($request))->download('transaction_fee_sale_export_'.$request->get('start_date').'_'.$request->get('end_date').'.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function reversal(Request $request)
    {
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

        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));

        $data = TransactionLog::whereNotNull('responsecode');
        $data->where('tx_mti', '=', '0200');
        $data->where('proc_code', '=', '500000');

        if($request->has('start_date') && $request->get('start_date')!=''){
            $data->where('tx_time', '>', $request->get('start_date').' 00:00:00');
        }

        if($request->has('end_date') && $request->get('end_date')!=''){
            $data->where('tx_time', '<=', $request->get('end_date').' 23:59:59');
        }

        if($request->has('stan') && $request->get('stan')!=''){
            $data->where('stan', $request->get('stan'));
        }

        $dataLog = TransactionLog::select('stan')->whereNotNull('responsecode');
        $dataLog->where('tx_mti', '=', '0200');
        $dataLog->where('proc_code', '=', '500000');

        if($request->has('start_date') && $request->get('start_date')!=''){
            $dataLog->where('tx_time', '>', $request->get('start_date').' 00:00:00');
        }

        if($request->has('end_date') && $request->get('end_date')!=''){
            $dataLog->where('tx_time', '<=', $request->get('end_date').' 23:59:59');
        }

        if($request->has('stan') && $request->get('stan')!=''){
            $dataLog->where('stan', $request->get('stan'));
        }

        $dataPpob = Transaction::select('stan');
        if($request->has('start_date') && $request->get('start_date')!=''){
            $dataPpob->where('created_at', '>', $request->get('start_date').' 00:00:00');
        }

        if($request->has('end_date') && $request->get('end_date')!=''){
            $dataPpob->where('created_at', '<=', $request->get('end_date').' 23:59:59');
        }

        if($request->has('stan') && $request->get('stan')!=''){
            $dataPpob->where('stan', $request->get('stan'));
        }
        // $data = $data->paginate(10);

        $dataLog = $dataLog->get();
        $dataPpob = $dataPpob->get();

        $arrayLength = $dataLog->count();
        $ppobSize = $dataPpob->count();
        
        $array = array();
        $i = 0;
        $count = 0;
        for ($i = 0; $i < $arrayLength; $i++){
            $isIdentical = false;
            try {
                for ($j = 0; $j < $ppobSize; $j++){
                    if($dataLog[$i]->stan == $dataPpob[$j]->stan){
                        $isIdentical = true;
                    }
                }
            } catch (Exception $e){
                // echo $e;
            }

            if($isIdentical){
                //verified
                // echo 'isIdentical ';
            } else {
                $array[$count] = $dataLog[$i]->stan;
                $count++;
                // $data->orWhere('stan', "'".$dataLog[$i]->stan."'");
                // echo 'NotIdentical '.$dataLog[$i]->stan . ' ';
            }
        }
        
        // if(substr($array, strlen($array)-1, 1) == ','){
        //     $array = substr($array, 0, strlen($array)-1); 
        // }

        $data->whereIn('stan', $array);

        $data = $data->paginate(10);

        return view('apps.transactionsBJB.reversal')
                ->with('data', $data);
    }

    public function postReversal(Request $request, $additional_data)
    {

        DB::beginTransaction();
        try {
            $dateTime = date("YmdHms");

            $data = TransactionLog::select('stan')->where('additional_data', $additional_data)->first();

            $ch = curl_init();
                // $authorization = "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8zNi45NC41OC4xODBcL2FwaVwvY29yZVwvcHVibGljXC9pbmRleC5waHBcL2FwaVwvYXV0aFwvbG9naW4iLCJpYXQiOjE2MjAyNzQ1MDMsImV4cCI6MTYyMTE0MzMwMywibmJmIjoxNjIwMjc0NTAzLCJqdGkiOiJndXRUaVprZElOb3c5RkVwIiwic3ViIjoiZTZhZTkwOWEtY2YzNC00ZDc2LWE5ZWQtMjJkOWJhNzU4ZmIwIiwicHJ2IjoiZjkzMDdlYjVmMjljNzJhOTBkYmFhZWYwZTI2ZjAyNjJlZGU4NmY1NSJ9.B8mm2IFt-TlYtvnmk8gctiBfAxnF5op0plemFJW6D_k";
                // $method_request = "transaction_code=".$transaction->code;
                // curl_setopt($ch, CURLOPT_URL, "http://36.94.58.180/api/core/public/index.php/api/transactions/checkStatus?".$method_request);
                curl_setopt($ch, CURLOPT_URL, "http://36.94.58.182:8080/ARRest/api");
                // SSL important
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: text/plain'));
                // curl_setopt($ch, CURLOPT_POSTFIELDS, ['msg'=>'{
                //                                     "msg_id": "'. $additional_data . $dateTime . '",
                //                                     "msg_ui": "'. $additional_data .'",
                //                                     "msg_si": "R82561",
                //                                     "msg_dt": "'. $data->stan .'",
                //                                 }']);
                
                curl_setopt($ch, CURLOPT_POSTFIELDS, [ 'msg' => '{
                                                    "msg_id": "'. substr($additional_data, 0, 16) . $dateTime . '",
                                                    "msg_ui": "'. substr($additional_data, 0, 16) .'",
                                                    "msg_si": "R82561",
                                                    "msg_dt": "'. $data->stan .'"
                                                }'] );
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
                curl_setopt($ch, CURLOPT_POST,           1 );

                $output = curl_exec($ch);
                $err = curl_error($ch);
                curl_close($ch);

                $value = '{ msg: {
                                                    "msg_id": "'. substr($additional_data, 0, 16) . $dateTime . '",
                                                    "msg_ui": "'. substr($additional_data, 0, 16) .'",
                                                    "msg_si": "R82561",
                                                    "msg_dt": "'. $data->stan .'"
                                                } }';

                echo $output . $value;die;
                
                if ($err) {
                    echo "cURL Error #:" . $err;
                } else {
                    // print_r(json_decode($output));
                    return Redirect::to('transactionBJB')
                        ->with('message', 'Reversal berhasil dikirim');
                    // return redirect()->route('transaction')
                    //             ->with('success','Status updated successfully');
                }

            // if($data){
            //     $reqData = [
            //         'msg'                   => '{
            //                                         "msg_id": "'. $additional_data . $dateTime . '",
            //                                         "msg_ui": "'. $additional_data .'",
            //                                         "msg_si": "R82561",
            //                                         "msg_dt": "'. $data->stan .'",
            //                                     }',
            //     ];

            //     //  $reqData = [
            //     //     'msg_id'                   => $additional_data . $dateTime,
            //     //     'msg_ui'                   => $additional_data,
            //     //     'msg_si'                   => 'R82561',
            //     //     'msg_dt'                   => $data->stan,
            //     // ];

            //     $responseCurl = Curl::to(config('app.url_reversal'))
            //                         ->withData($reqData)
            //                         ->asJson()
            //                         ->post();
                
            //     if($responseCurl->status == true){   
            //         DB::commit();
            //         return Redirect::to('transaction/reversal')
            //             ->with('message', 'Reversal berhasil dikirim');
            //     }else{
            //         DB::rollBack();
            //         return Redirect::to('transaction/reversal')
            //             ->with('error', 'Failed to save mireta')
            //             ->withInput();
            //     }
            // }
        } catch (Exception $e) {
            DB::rollBack();
            return Redirect::to('transactionBJB/reversal')
                        ->with('error', $e)
                        ->withInput();
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            return Redirect::to('transactionBJB/reversal')
                        ->with('error', $e)
                        ->withInput();
        }
    }

    public function edit($id)
    {
        $transaction = TransactionBJB::find($id);
        if($transaction){
            return view('apps.transactionsBJB.edit')
                ->with('transaction', $transaction);
        }else{
            return Redirect::to('transactionBJB')
                            ->with('error', 'Data not found');
        }
    }

    public function update(TransactionUpdateRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);
            $transaction = TransactionBJB::find($id);
                if ($transaction->status == 0 || $transaction->status == 1) {
                    $reqData['status']               = 2;
                } else {
                    $reqData['status']               = 1;
                }
                $data = $this->repository->update($reqData, $id);
            
            if($data){    
                DB::commit();
                return Redirect::to('transactionBJB')
                                    ->with('message', 'Status updated');
            }else{
                DB::rollBack();
                return Redirect::to('transactionBJB')
                            ->with('error', $data->error)
                            ->withInput();
            }
        } catch (Exception $e) {
            DB::rollBack();
            return Redirect::to('transactionBJB')
                        ->with('error', $e)
                        ->withInput();
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            return Redirect::to('transactionBJB')
                        ->with('error', $e)
                        ->withInput();
        }
    }

    public function updateStatus($id)
    {
        try {
            $transaction = TransactionBJB::find($id);
            if ($transaction) {
                $msg_td = base64_encode($transaction->merchant->terminal->tid);
                $msg_dt = date("YmdHms");
                $theOtherKey = $transaction->merchant->terminal->tid.$msg_dt;
                $base64key = base64_encode($theOtherKey);

                $newEncrypter = new \Illuminate\Encryption\Encrypter($base64key, 'AES-256-CBC');
                $encrypted = $newEncrypter->encrypt($transaction->code);

                // echo $msg_td."||".$msg_dt."||".$encrypted."||".$base64key; die;
                $ch = curl_init();
                // $authorization = "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8zNi45NC41OC4xODBcL2FwaVwvY29yZVwvcHVibGljXC9pbmRleC5waHBcL2FwaVwvYXV0aFwvbG9naW4iLCJpYXQiOjE2MjAyNzQ1MDMsImV4cCI6MTYyMTE0MzMwMywibmJmIjoxNjIwMjc0NTAzLCJqdGkiOiJndXRUaVprZElOb3c5RkVwIiwic3ViIjoiZTZhZTkwOWEtY2YzNC00ZDc2LWE5ZWQtMjJkOWJhNzU4ZmIwIiwicHJ2IjoiZjkzMDdlYjVmMjljNzJhOTBkYmFhZWYwZTI2ZjAyNjJlZGU4NmY1NSJ9.B8mm2IFt-TlYtvnmk8gctiBfAxnF5op0plemFJW6D_k";
                // $method_request = "transaction_code=".$transaction->code;
                // curl_setopt($ch, CURLOPT_URL, "http://36.94.58.180/api/core/public/index.php/api/transactions/checkStatus?".$method_request);
                curl_setopt($ch, CURLOPT_URL, "http://36.94.58.180/api/core/public/index.php/api/transactions/detail/".$id);
                // SSL important
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    // $authorization,
                    // 'msg-td: '.$msg_td,
                    'api-key: '.$encrypted,
                    'msg-td: '.$msg_td,
                    'msg-dt: '.$msg_dt));
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

                $output = curl_exec($ch);
                $err = curl_error($ch);
                curl_close($ch);
                
                if ($err) {
                    echo "cURL Error #:" . $err;
                } else {
                    // print_r(json_decode($output));
                    return Redirect::back()->with('success','Status updated successfully');
                    // return redirect()->route('transaction')
                    //             ->with('success','Status updated successfully');
                }
            }
        } catch (Exception $e) {
            return Redirect::to('transactionBJB')
                        ->with('error', $e)
                        ->withInput();
        } catch (\Illuminate\Database\QueryException $e) {
            return Redirect::to('transactionBJB')
                        ->with('error', $e)
                        ->withInput();
        }
    }

    public function updatebjb(TransactionBJBUpdateRequest $request, $id)
    {
        // list($stan, $date) = explode("|", $id);
        // $transaction = DB::table('transaction_log')
        //                 ->select('*')
        //                 ->where('stan', '=', $stan)
        //                 ->where('tx_time', '>', $date . ' 00:00:00')
        //                 ->get();

        // $data = DB::table('transaction_log')
        //                     ->updateOrInsert(
        //                         ['tx_mti' => '0400', 'rp_mti' => '0410']
        //                     );

        // if($data){
        //     return Redirect::to('transaction')
        //     ->with('success', 'Data berhasil di rubah');
        // } else {
        //     return Redirect::to('transaction')
        //     ->with('error', 'Data not found');
        // }

        DB::beginTransaction();
        try {
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);
            list($stan, $date) = explode("_", $id);
            return Redirect::to('transactionBJB')
                ->with('stan', $stan)
                ->with('date', $date);
             $transaction = TransactionLog::where('stan', '=', $stan)->first();
            // $transaction = DB::table('transaction_log')
            //             ->select('*')
            //             ->where('stan', '=', $stan)
            //             ->where('tx_time', '>', $date . ' 00:00:00')
            //             ->get();

                foreach($transaction as $trx){
                    if(strpos($trx->tx_time, $date) !== false){
                        $reqData['tx_mti']               = '0400';
                        $reqData['rp_mti']               = '0410';

                        $data = $this->repository->update($reqData, $stan);
            
                        if($data){    
                            DB::commit();
                            return Redirect::to('transactionBJB')
                                                ->with('message', 'Status updated');
                        }else{
                            DB::rollBack();
                            return Redirect::to('transactionBJB')
                                        ->with('error', $data->error)
                                        ->withInput();
                        }

                        // if($type == 'Reversal') {
                        //     $reqData['tx_mti']               = 0400;
                        //     $reqData['rp_mti']               = 0410;

                        //     $data = DB::table('transaction_log')
                        //     ->updateOrInsert(
                        //         ['tx_mti' => '0400', 'rp_mti' => '0410']
                        //     );

                        //     if($data){    
                        //         DB::commit();
                        //         return Redirect::to('transaction')
                        //                             ->with('message', 'Status updated');
                        //     }else{
                        //         DB::rollBack();
                        //         return Redirect::to('transaction')
                        //                     ->with('error', $data->error)
                        //                     ->withInput();
                        //     }
                        // } else {
                        //     //skip
                        // }
                    }
                }
            
        } catch (Exception $e) {
            DB::rollBack();
            return Redirect::to('transactionBJB')
                        ->with('error', $e)
                        ->withInput();
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            return Redirect::to('transactionBJB')
                        ->with('error', $e)
                        ->withInput();
        }
    }

    private function getInfo(Request $request)
    {
        DB::beginTransaction();
        try {
            $date           = $request->date;
            $group_id       = $request->group_id;
            $schema_id      = $request->schema_id;
            $dataCalculate  = $this->calculate($group_id, $date);
            
            // Check 
            $groupSchema = GroupSchema::where('group_id', $group_id)
                                        ->where('schema_id', $schema_id)
                                        ->first();
            if($groupSchema){
                $revenue = $dataCalculate['revenue'] * $groupSchema->share/100;

                // Check if this group is shareable
                if($groupSchema->is_shareable ==  true){
                    $shareholders = GroupSchemaShareholder::where('group_schema_id', $groupSchema->id)
                                                        ->with('shareholder')
                                                        ->get();
                    foreach($shareholders as $sh){
                        $sh->revenue = $sh->share/100 * $revenue;
                    }
                }else{
                    $shareholders = [];
                }

                $response = [
                    'revenue'       => $revenue,
                    'total_trx'      => $dataCalculate['count'],
                    'amount_trx'     => $dataCalculate['amount'],
                    'shareholder'   => $shareholders
                ];
            }else{
                return response()->json([
                    'status'    => false, 
                    'error'     => 'Group has not schema'
                ], 404);
            }

            DB::commit();
            return response()->json($response, 200);
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

    private function calculate($group_id, $date)
    {
        $groups = Group::where('parent_id', $group_id)->get();
        $result = [];
        $result['revenue']  = 0;
        $result['count']    = 0;
        $result['amount']   = 0;
        $result['total_fee']   = 0;
        $result['total_hpp']   = 0;
        // Count
        $count = TransactionBJB::where('status',1)
        ->count();
        $result['count'] = $count;

        // Sum
        $sum = TransactionBJB::where('status',1)
                ->sum('price');
        $result['amount'] = $sum;

        $fee = TransactionBJB::where('status',1)
                ->sum('fee');
        $result['total_fee'] = $fee;

        $result['total_hpp'] = $sum-$fee;
        // foreach ($groups as $item){
        //     // Check if id is leaf or not
        //     $check = Group::where('parent_id', $item->id)->first();
        //     if($check){
        //         $result = $this->calculate($item->id, $date);
        //     }else{
        //         // Count amount of transactions
        //         $userGroups = UserGroup::where('group_id', $item->id)->get();
        //         foreach($userGroups as $userGroup){
        //             $merchant = Merchant::where('user_id', $userGroup->user_id)->first();
        //             if($merchant){
        //                 $revenues = Transaction::where('merchant_id', $merchant->id)
        //                                 // ->whereDate('date', $date)
        //                                 ->where('status', 1)
        //                                 ->get();
        //                 // Revenue
        //                 foreach($revenues as $revenue){
        //                     $result['revenue'] = $result['revenue'] + ($revenue->price - $revenue->vendor_price);
        //                 }

        //                 // Count
        //                 $count = Transaction::where('merchant_id', $merchant->id)
        //                                     ->where('status',1)
        //                                     ->count();
        //                 $result['count'] = $result['count'] + $count;

        //                 // Sum
        //                 $sum = Transaction::where('merchant_id', $merchant->id)
        //                                     ->where('status',1)
        //                                     ->sum('price');
        //                 $result['amount'] = $result['amount'] + $sum;

        //             }
        //         }
        //     }
        // }
        return $result;
    }

    private function calculateOnly()
    {
        $result = [];
        $result['revenue']  = 0;
        $result['count']    = 0;
        $result['amount']   = 0;
        $result['total_fee']   = 0;
        $result['total_hpp']   = 0;
        // Count
        $count = TransactionBJB::where('status',1)->where('is_development','!=',1)
        ->count();
        $result['count'] = $count;

        // Sum
        $sum = TransactionBJB::where('status',1)->where('is_development','!=',1)
                ->sum('price');
        $result['amount'] = $sum;

        $total_hpp = TransactionBJB::where('status',1)->where('is_development','!=',1)
                ->sum('vendor_price');
        $result['total_hpp'] = $total_hpp;
        
        $result['total_fee'] = $sum-$total_hpp;

        // foreach ($groups as $item){
        //     // Check if id is leaf or not
        //     $check = Group::where('parent_id', $item->id)->first();
        //     if($check){
        //         $result = $this->calculate($item->id, $date);
        //     }else{
        //         // Count amount of transactions
        //         $userGroups = UserGroup::where('group_id', $item->id)->get();
        //         foreach($userGroups as $userGroup){
        //             $merchant = Merchant::where('user_id', $userGroup->user_id)->first();
        //             if($merchant){
        //                 $revenues = Transaction::where('merchant_id', $merchant->id)
        //                                 // ->whereDate('date', $date)
        //                                 ->where('status', 1)
        //                                 ->get();
        //                 // Revenue
        //                 foreach($revenues as $revenue){
        //                     $result['revenue'] = $result['revenue'] + ($revenue->price - $revenue->vendor_price);
        //                 }

        //                 // Count
        //                 $count = Transaction::where('merchant_id', $merchant->id)
        //                                     ->where('status',1)
        //                                     ->count();
        //                 $result['count'] = $result['count'] + $count;

        //                 // Sum
        //                 $sum = Transaction::where('merchant_id', $merchant->id)
        //                                     ->where('status',1)
        //                                     ->sum('price');
        //                 $result['amount'] = $result['amount'] + $sum;

        //             }
        //         }
        //     }
        // }
        return $result;
    }
}
