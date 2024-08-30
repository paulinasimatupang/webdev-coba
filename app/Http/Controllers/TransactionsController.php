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
use App\Exports\TransactionExport;

use App\Services\TransactionService;

use App\Entities\Merchant;
use App\Entities\PersenFee;
use App\Entities\Service;
use App\Entities\Transaction;
use App\Entities\TransactionStatus;
use App\Entities\TransactionFee;
use App\Entities\transactionPaymentStatus;
use App\Entities\Group;
use App\Entities\UserGroup;
use App\Entities\GroupSchema;
use App\Entities\GroupSchemaShareholder;
use App\Entities\TransactionBJB;
use App\Entities\TransactionLog;
use App\Entities\TransactionSaleBJB;
use App\Exports\TransactionSaleExport;
use App\Exports\TransactionFeeSaleExport;
use App\Http\Controllers\CoresController as Core;
use App\Http\Requests\TransactionBJBUpdateRequest;
use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as Pdf;

/**
 * Class TransactionsController.
 *
 * @package namespace App\Http\Controllers;
 */
class TransactionsController extends Controller
{
    /**
     * @var TransactionRepository
     */
    protected $repository;

    /**
     * @var TransactionValidator
     */
    protected $validator;
    protected $transactionService;


    /**
     * TransactionsController constructor.
     *
     * @param TransactionRepository $repository
     * @param TransactionValidator $validator
     */
    public function __construct(TransactionRepository $repository, TransactionValidator $validator, TransactionService $transactionService)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transactionService = $transactionService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
    
        // Membuat query untuk mendapatkan data transaksi
        $data = Transaction::select('*')
            ->with(['event','transactionStatus', 'user','service', 'merchant']);

        if ($request->has('search') && $request->get('search') != '') {
            $data->where('transaction_code', '=', $request->get('search'));
        } 

        if($request->has('start_date') && $request->get('start_date')!=''){
            $data->where('transaction_time', '>', $request->get('start_date'). ' 00:00:00.000');
        }

        if($request->has('end_date') && $request->get('end_date')!=''){
            $data->where('transaction_time', '<=', $request->get('end_date'). ' 23:59:59.999');
        }

        // if($request->has('service') && $request->get('service')!=''){
        //     $data->where('service', '=', $request->get('service'). ' 23:59:59.999');
        // }
    
        // Filter berdasarkan status
        if ($request->has('status') && $request->get('status') != '' && $request->get('status') != 'Select Status') {
            $status = $request->get('status');
            switch ($status) {
                case 'Success':
                    $data->where('transaction_status_id', 0);
                    break;
                case 'Failed':
                    $data->where('transaction_status_id', 1);
                    break;
                case 'Pending':
                    $data->where('transaction_status_id', 2);
                    break;
            }
        }
    
        // Order by handling
        $orderType = $request->get('order_type', 'desc');
        $orderBy = $request->get('order_by', 'transaction_time');
        $data->orderBy($orderBy, $orderType);

        $totalAmount = $data->sum('amount');
        $fee = TransactionFee::select('fee');
        $totalFee = $fee->sum('fee');

        $feeSelada = DB::connection('pgsql_billiton')->table('persen_fee')->where('id', 1)->value('persentase') / 100;
        $feeNTBS = DB::connection('pgsql_billiton')->table('persen_fee')->where('id', 2)->value('persentase') / 100;
        $feeAgent = DB::connection('pgsql_billiton')->table('persen_fee')->where('id', 3)->value('persentase') / 100;

        $dataRevenue = [
            'total_trx' => $data->count(),
            'amount_trx' => $totalAmount,
            'total_fee' => $totalFee,
            'total_fee_agent' => $totalFee * $feeAgent,
            'total_fee_ntbs' => $totalFee * $feeNTBS,
            'total_fee_selada' => $totalFee * $feeSelada,
            'total_fee_agent' => $totalFee * $feeAgent,
            'total_fee_ntbs' => $totalFee * $feeNTBS,
            'total_fee_selada' => $totalFee * $feeSelada,
        ];
    
        // Pagination
        $data = $data->paginate(10);
    
        $user = session()->get('user');
    
        return view('apps.transactions.list')
            ->with('data', $data)
            ->with('dataRevenue', $dataRevenue)
            ->with('username', $user->username);
    }
    
    public function getStatusText($statusId)
    {
        switch ($statusId) {
            case 0:
                return 'Success';
            case 1:
                return 'Failed';
            case 2:
                return 'Pending';
            default:
                return 'Unknown';
        }
    }


    public function export(Request $request)
    {

        if (!$request->has('status') && $request->get('status') == '') {
            $request->request->add([
                'status'  => 'Success'
            ]);
        }
        if (!$request->has('start_date') && $request->get('start_date') == '') {
            $request->request->add([
                'start_date'      => date("Y-m-d")
            ]);
        }
        if (!$request->has('end_date') && $request->get('end_date') == '') {
            $request->request->add([
                'end_date'      => date("Y-m-d")
            ]);
        }
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));

        return (new TransactionExport($request))->download('transaction_export_' . $request->get('start_date') . '_' . $request->get('end_date') . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function saleExport(Request $request)
    {

        if (!$request->has('status') && $request->get('status') == '') {
            $request->request->add([
                'status'  => 'Success'
            ]);
        }
        if (!$request->has('start_date') && $request->get('start_date') == '') {
            $request->request->add([
                'start_date'      => date("Y-m-d")
            ]);
        }
        if (!$request->has('end_date') && $request->get('end_date') == '') {
            $request->request->add([
                'end_date'      => date("Y-m-d")
            ]);
        }
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));

        return (new TransactionSaleExport($request))->download('transaction_sale_export_' . $request->get('start_date') . '_' . $request->get('end_date') . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function exportCSV(Request $request)
    {
        $query = Transaction::query(); 
        $choice = 1; // Menampilkan semua data
        return Excel::download(new TransactionsExport($query, $choice), 'transactions_all.xlsx');
    }
    
    public function exportCSVFeeOnly(Request $request)
    {
        $query = Transaction::query(); 
        $choice = 2; // Menampilkan fee, nama, dan status
        return Excel::download(new TransactionsExport($query, $choice), 'transactions_fee.xlsx');
    }
    
    public function exportCSVPaymentOnly(Request $request)
    {
        $query = Transaction::query(); 
        $choice = 3; // Menampilkan nama, amount, dan status
        return Excel::download(new TransactionsExport($query, $choice), 'transactions_payment.xlsx');
    }
    
    public function exportPDF(Request $request)
    {
        ini_set('memory_limit', '512M');
        set_time_limit(300);
        $query = Transaction::query();
        $viewType = 1; 
        $transactionsExport = new TransactionsExport($query, $viewType);
        $transactions = $transactionsExport->collection(); 
        $pdf = Pdf::loadView('pdf.transactions', ['transactions' => $transactions]);
        return $pdf->download('transactions.pdf');
    }

    public function feeExport(Request $request)
    {

        if (!$request->has('status') && $request->get('status') == '') {
            $request->request->add([
                'status'  => 'Success'
            ]);
        }
        if (!$request->has('start_date') && $request->get('start_date') == '') {
            $request->request->add([
                'start_date'      => date("Y-m-d")
            ]);
        }
        if (!$request->has('end_date') && $request->get('end_date') == '') {
            $request->request->add([
                'end_date'      => date("Y-m-d")
            ]);
        }
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));

        return (new TransactionFeeSaleExport($request))->download('transaction_fee_sale_export_' . $request->get('start_date') . '_' . $request->get('end_date') . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function update(TransactionUpdateRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);
            $transaction = Transaction::find($id);
            if ($transaction->status == 0 || $transaction->status == 1) {
                $reqData['status']               = 2;
            } else {
                $reqData['status']               = 1;
            }
            $data = $this->repository->update($reqData, $id);

            if ($data) {
                DB::commit();
                return Redirect::to('transaction')
                    ->with('message', 'Status updated');
            } else {
                DB::rollBack();
                return Redirect::to('transaction')
                    ->with('error', $data->error)
                    ->withInput();
            }
        } catch (Exception $e) {
            DB::rollBack();
            return Redirect::to('transaction')
                ->with('error', $e)
                ->withInput();
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            return Redirect::to('transaction')
                ->with('error', $e)
                ->withInput();
        }
    }

    public function updateStatus($id)
    {
        try {
            $transaction = Transaction::find($id);
            if ($transaction) {
                $msg_td = base64_encode($transaction->merchant->terminal->tid);
                $msg_dt = date("YmdHms");
                $theOtherKey = $transaction->merchant->terminal->tid . $msg_dt;
                $base64key = base64_encode($theOtherKey);

                $newEncrypter = new \Illuminate\Encryption\Encrypter($base64key, 'AES-256-CBC');
                $encrypted = $newEncrypter->encrypt($transaction->code);

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, "http://36.94.58.180/api/core/public/index.php/api/transactions/detail/" . $id);

                curl_setopt($ch, CURLOPT_HTTPHEADER, array(

                    'api-key: ' . $encrypted,
                    'msg-td: ' . $msg_td,
                    'msg-dt: ' . $msg_dt
                ));
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

                $output = curl_exec($ch);
                $err = curl_error($ch);
                curl_close($ch);

                if ($err) {
                    echo "cURL Error #:" . $err;
                } else {
                    return Redirect::back()->with('success', 'Status updated successfully');
                }
            }
        } catch (Exception $e) {
            return Redirect::to('transaction')
                ->with('error', $e)
                ->withInput();
        } catch (\Illuminate\Database\QueryException $e) {
            return Redirect::to('transaction')
                ->with('error', $e)
                ->withInput();
        }
    }

    public function updatebjb(TransactionBJBUpdateRequest $request, $id)
    {

        DB::beginTransaction();
        try {
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);
            list($stan, $date) = explode("_", $id);
            return Redirect::to('transaction')
                ->with('stan', $stan)
                ->with('date', $date);
            $transaction = TransactionLog::where('stan', '=', $stan)->first();

            foreach ($transaction as $trx) {
                if (strpos($trx->tx_time, $date) !== false) {
                    $reqData['tx_mti']               = '0400';
                    $reqData['rp_mti']               = '0410';

                    $data = $this->repository->update($reqData, $stan);

                    if ($data) {
                        DB::commit();
                        return Redirect::to('transaction')
                            ->with('message', 'Status updated');
                    } else {
                        DB::rollBack();
                        return Redirect::to('transaction')
                            ->with('error', $data->error)
                            ->withInput();
                    }
                }
            }
        } catch (Exception $e) {
            DB::rollBack();
            return Redirect::to('transaction')
                ->with('error', $e)
                ->withInput();
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            return Redirect::to('transaction')
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


            $groupSchema = GroupSchema::where('group_id', $group_id)
                ->where('schema_id', $schema_id)
                ->first();
            if ($groupSchema) {
                $revenue = $dataCalculate['revenue'] * $groupSchema->share / 100;

                if ($groupSchema->is_shareable ==  true) {
                    $shareholders = GroupSchemaShareholder::where('group_schema_id', $groupSchema->id)
                        ->with('shareholder')
                        ->get();
                    foreach ($shareholders as $sh) {
                        $sh->revenue = $sh->share / 100 * $revenue;
                    }
                } else {
                    $shareholders = [];
                }

                $response = [
                    'revenue'       => $revenue,
                    'total_trx'      => $dataCalculate['count'],
                    'amount_trx'     => $dataCalculate['amount'],
                    'shareholder'   => $shareholders
                ];
            } else {
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
        $count = Transaction::where('status', 1)
            ->count();
        $result['count'] = $count;

        // Sum
        $sum = Transaction::where('status', 1)
            ->sum('price');
        $result['amount'] = $sum;

        $fee = Transaction::where('status', 1)
            ->sum('fee');
        $result['total_fee'] = $fee;

        $result['total_hpp'] = $sum - $fee;

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
        $count = Transaction::where('status', 1)->where('is_development', '!=', 1)
            ->count();
        $result['count'] = $count;

        // Sum
        $sum = Transaction::where('status', 1)->where('is_development', '!=', 1)
            ->sum('price');
        $result['amount'] = $sum;

        $total_hpp = Transaction::where('status', 1)->where('is_development', '!=', 1)
            ->sum('vendor_price');
        $result['total_hpp'] = $total_hpp;

        $result['total_fee'] = $sum - $total_hpp;

        return $result;
    }

    public function rankTransactions()
    {
        $rankedTransactions = $this->transactionService->rankTransactionsByMerchantUser();
        return view('apps.transactions.rank', compact('rankedTransactions'));
    }

    public function reportFee()
    {
        $totalFees = TransactionFee::select('penerima', DB::raw('SUM(fee) as total_fee'))
            ->groupBy('penerima')
            ->get();

        return view('apps.transactions.list-fee', compact('totalFees'));
    }
}