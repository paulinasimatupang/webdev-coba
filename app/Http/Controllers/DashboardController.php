<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;

use App\Entities\Revenue;
use App\Entities\Transaction;
use App\Entities\Merchant;
use App\Entities\Group;
use App\Entities\GroupSchema;
use App\Entities\GroupSchemaShareholder;
use App\Entities\UserGroup;
use App\Entities\UserChild;
use App\Entities\TransactionBJB;
use App\Entities\TransactionLog;
use App\Entities\TransactionFeeSale;
use App\Entities\TransactionFeeLakupandai;
use App\Entities\TransactionSaleBJB;
use App\Entities\ReportFee;
use Charts;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $request->request->add([
            'group_id'  => 1,
            'date'      => date("Y-m-d H:i:s"),
            'schema_id' => 1,
        ]);

        $credentials = $request->only('group_id', 'date', 'schema_id');
        $rules = [
            'group_id'  => 'required',
            'schema_id' => 'required',
            'date'      => 'required',
        ];

        if(!$request->has('start_date') && $request->get('start_date')==''){
            $request->request->add([
                'start_date'      => date("F Y")
            ]);
        }
        if(!$request->has('end_date') && $request->get('end_date')==''){
            $request->request->add([
                'end_date'      => date("F Y")
            ]);
        }
        
        $validator = Validator::make($credentials, $rules);
        if($validator->fails()) {
            return response()->json(['status'=> false, 'error'=> $validator->messages()],403);
        }

        //All Fee
        $fee_all = ReportFee::select('terminal_id', 
                                        'merchant_id',	
                                        'agent_name');
        $fee_all->selectRaw('SUM(CAST(total_amount_fee as int)) as total_amount_fee');
        $fee_all->selectRaw('sum(CAST(fee_agen as int)) as fee_agen');
        $fee_all->selectRaw('sum(CAST(fee_bjb as int)) as fee_bjb');
        $fee_all->selectRaw('sum(CAST(fee_selada as int)) as fee_selada');
        $fee_all->selectRaw('sum(CAST(buffer as int)) as buffer');
        $fee_all->selectRaw('SUM(CAST(total_amount_transaction as int)) as total_amount_transaction');
        $fee_all->selectRaw('count(*) as total_transaction');
        $fee_all->groupBy('terminal_id', 'merchant_id', 'agent_name');
        $fee_all->orderBy('total_amount_fee', 'desc');

        if($request->has('start_date') && $request->get('start_date')!=''){
            $date=date_create($request->get('start_date'));
            $fee_all->where('tx_time', '>', date_format($date, 'Y-m-d').' 00:00:00');
        }

        if($request->has('end_date') && $request->get('end_date')!=''){
            $date=date_create($request->get('end_date'));
            $fee_all->where('tx_time', '<', date_format($date, 'Y-m-t').' 23:59:59');
        }

        $fee_all = $fee_all->first();
        
        $data = ReportFee::select('terminal_id', 
                                        'merchant_id',	
                                        'agent_name');
        $data->selectRaw('SUM(CAST(total_amount_fee as int)) as total_amount_fee');
        $data->selectRaw('sum(CAST(fee_agen as int)) as fee_agen');
        $data->selectRaw('sum(CAST(fee_bjb as int)) as fee_bjb');
        $data->selectRaw('sum(CAST(fee_selada as int)) as fee_selada');
        $data->selectRaw('sum(CAST(buffer as int)) as buffer');
        $data->selectRaw('SUM(CAST(total_amount_transaction as int)) as total_amount_transaction');
        $data->selectRaw('count(*) as total_transaction');
        $data->whereIn('product_name', array('E82560', 'E82561'));
        $data->groupBy('terminal_id', 'merchant_id', 'agent_name');
        $data->orderBy('total_amount_fee', 'desc');

        if($request->has('start_date') && $request->get('start_date')!=''){
            $date=date_create($request->get('start_date'));
            $data->where('tx_time', '>', date_format($date, 'Y-m-d').' 00:00:00');
        }

        if($request->has('end_date') && $request->get('end_date')!=''){
            $date=date_create($request->get('end_date'));
            $data->where('tx_time', '<', date_format($date, 'Y-m-t').' 23:59:59');
        }

        $data = $data->first();

        //Lakupandai Fee
        $fee_lakupandai = ReportFee::select('terminal_id', 
                                        'merchant_id',	
                                        'agent_name');
        $fee_lakupandai->selectRaw('SUM(CAST(total_amount_fee as int)) as total_amount_fee');
        $fee_lakupandai->selectRaw('sum(CAST(fee_agen as int)) as fee_agen');
        $fee_lakupandai->selectRaw('sum(CAST(fee_bjb as int)) as fee_bjb');
        $fee_lakupandai->selectRaw('sum(CAST(fee_selada as int)) as fee_selada');
        $fee_lakupandai->selectRaw('sum(CAST(buffer as int)) as buffer');
        $fee_lakupandai->selectRaw('SUM(CAST(total_amount_transaction as int)) as total_amount_transaction');
        $fee_lakupandai->selectRaw('count(*) as total_transaction');
        $fee_lakupandai->whereNotIn('product_name', array('E82560', 'E82561'));
        $fee_lakupandai->groupBy('terminal_id', 'merchant_id', 'agent_name');
        $fee_lakupandai->orderBy('total_amount_fee', 'desc');

        if($request->has('start_date') && $request->get('start_date')!=''){
            $date=date_create($request->get('start_date'));
            $fee_lakupandai->where('tx_time', '>', date_format($date, 'Y-m-d').' 00:00:00');
        }

        if($request->has('end_date') && $request->get('end_date')!=''){
            $date=date_create($request->get('end_date'));
            $fee_lakupandai->where('tx_time', '<', date_format($date, 'Y-m-t').' 23:59:59');
        }

        $fee_lakupandai = $fee_lakupandai->first();


        //Agent Reward
        $reward_agent = ReportFee::select('terminal_id', 
                                        'merchant_id',	
                                        'agent_name');
        $reward_agent->selectRaw('sum(CAST(fee_agen as int)) as fee_agen');
        $reward_agent->selectRaw('sum(CAST(buffer as int)) as buffer');
        $reward_agent->selectRaw('CASE
                                        WHEN sum(CAST(buffer as int)) > 450000
                                        THEN sum(CAST(buffer as int)) - 450000
                                        ELSE 0
                                        END as reward_total');
        $reward_agent->groupBy('terminal_id', 'merchant_id', 'agent_name');
        $reward_agent->orderBy('buffer', 'desc');

        if($request->has('start_date') && $request->get('start_date')!=''){
            $date=date_create($request->get('start_date'));
            $reward_agent->where('tx_time', '>', date_format($date, 'Y-m-d').' 00:00:00');
        }

        if($request->has('end_date') && $request->get('end_date')!=''){
            $date=date_create($request->get('end_date'));
            $reward_agent->where('tx_time', '<', date_format($date, 'Y-m-t').' 23:59:59');
        }

        $reward_agent = $reward_agent->get();
        $is_reward = false;

        foreach($reward_agent as $item){
            if($item->reward_total > 0){
                $is_reward = true;
                break;
            }
        }

        //Fee Total
        $fee_total = ReportFee::selectRaw('sum(CAST(fee_agen as int)) as fee_agen');
        $fee_total->selectRaw('sum(CAST(fee_bjb as int)) as fee_bjb');
        $fee_total->selectRaw('sum(CAST(fee_selada as int)) as fee_selada');

        if($request->has('start_date') && $request->get('start_date')!=''){
            $date=date_create($request->get('start_date'));
            $fee_total->where('tx_time', '>', date_format($date, 'Y-m-d').' 00:00:00');
        }

        if($request->has('end_date') && $request->get('end_date')!=''){
            $date=date_create($request->get('end_date'));
            $fee_total->where('tx_time', '<', date_format($date, 'Y-m-t').' 23:59:59');
        }

        $fee_total = $fee_total->first();

        //All Transaction
        $all_trx = ReportFee::selectRaw('count(*) as total_transaction');
        $all_trx->selectRaw('SUM(CAST(total_amount_transaction as int)) as total_amount_transaction');

        if($request->has('start_date') && $request->get('start_date')!=''){
            $date=date_create($request->get('start_date'));
            $all_trx->where('tx_time', '>', date_format($date, 'Y-m-d').' 00:00:00');
        }

        if($request->has('end_date') && $request->get('end_date')!=''){
            $date=date_create($request->get('end_date'));
            $all_trx->where('tx_time', '<', date_format($date, 'Y-m-t').' 23:59:59');
        }

        $all_trx = $all_trx->first();

        //Ppob Transaction
        $ppob_trx = ReportFee::selectRaw('count(*) as total_transaction');
        $ppob_trx->selectRaw('SUM(CAST(total_amount_transaction as int)) as total_amount_transaction');
        $ppob_trx->whereIn('product_name', array('E82560', 'E82561'));

        if($request->has('start_date') && $request->get('start_date')!=''){
            $date=date_create($request->get('start_date'));
            $ppob_trx->where('tx_time', '>', date_format($date, 'Y-m-d').' 00:00:00');
        }

        if($request->has('end_date') && $request->get('end_date')!=''){
            $date=date_create($request->get('end_date'));
            $ppob_trx->where('tx_time', '<', date_format($date, 'Y-m-t').' 23:59:59');
        }

        $ppob_trx = $ppob_trx->first();

        //Lakupandai Transaction
        $lakupandai_trx = ReportFee::selectRaw('count(*) as total_transaction');
        $lakupandai_trx->selectRaw('SUM(CAST(total_amount_transaction as int)) as total_amount_transaction');
        $lakupandai_trx->whereNotIn('product_name', array('E82560', 'E82561'));

        if($request->has('start_date') && $request->get('start_date')!=''){
            $date=date_create($request->get('start_date'));
            $lakupandai_trx->where('tx_time', '>', date_format($date, 'Y-m-d').' 00:00:00');
        }

        if($request->has('end_date') && $request->get('end_date')!=''){
            $date=date_create($request->get('end_date'));
            $lakupandai_trx->where('tx_time', '<', date_format($date, 'Y-m-t').' 23:59:59');
        }

        $lakupandai_trx = $lakupandai_trx->first();

        $start_month = date_create($request->get('start_date'));
        $end_month = date_create($request->get('end_date'));
        $start_month = date_format($start_month, 'F');
        $end_month = date_format($end_month, 'F');
        $month = "(" . $start_month . " - " . $end_month . " Period)";

        if($start_month == $end_month){
            $month = "(" . $start_month . " Period)";
        }

        $getInfo    = $this->getInfo($request)->original;
        $data_2       = (object) $getInfo;
        $getInfoBJB = $this->getInfoBJB($request)->original;
        $dataBJB    = (object) $getInfoBJB;
        // $merchants  = $this->calcRevenue($request->group_id, $request->date, $request->schema_id);
        // $merchants  = collect($merchants);
        // $sorted     = $merchants->sortByDesc('id')->values()->all();
        
        // $data->merchants = $sorted;
        // return $data;

        $totalRevenue = $data_2->revenue + $dataBJB->revenue;
        $totalTrx     = $data_2->total_trx + $dataBJB->total_trx;
        $amountTrx    = $data_2->amount_trx + $dataBJB->amount_trx;
        // $totalMerchant= $this->calcMerchant($request->group_id);
        $totalPpobTransaction = $this->calcAvgPpobTransaction();
        $totalLakupandaiTransaction = $this->calcAvgLakupandaiTransaction();
        $totalMerchant= $this->calcMerchantTotal();
        $totalMerchantActive = $this->calcMerchantActive();
        $totalMerchantResign = $this->calcMerchantResign();

        // Check 
        $groupSchema = GroupSchema::where('group_id', $request->group_id)
                                    ->where('schema_id', $request->schema_id)
                                    ->first();
        if($groupSchema){
            $revenue = $totalRevenue * $groupSchema->share/100;

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
        }else{
            return response()->json([
                'status'    => false, 
                'error'     => 'Group has not schema'
            ], 404);
        }

        // $response = [   
        //     'status'        => true, 
        //     'message'       => 'Success',
        //     'total_revenue' => $totalRevenue,
        //     'total_trx'     => $totalTrx,
        //     'amount_trx'    => $amountTrx,
        //     'total_merchant'=> $totalMerchant,
        //     'shareholders'  => $shareholders
        // ];

        $dataResponse = Array();
        $dataResponse['total_revenue'] = $totalRevenue;
        $dataResponse['total_trx'] = $totalTrx;
        $dataResponse['amount_trx'] = $amountTrx;
        $dataResponse['total_merchant'] = $totalMerchant;
        $dataResponse['shareholders'] = $shareholders;

        // return response()->json($response, 200);

        if($data_2){
            return view('apps.dashboard.list')
                ->with('fee_all', $fee_all)
                ->with('data', $data)
                ->with('fee_lakupandai', $fee_lakupandai)
                ->with('reward_agent', $reward_agent)
                ->with('is_reward', $is_reward)
                ->with('fee_agen', $fee_total->fee_agen)
                ->with('fee_bjb', $fee_total->fee_bjb)
                ->with('fee_selada', $fee_total->fee_selada)
                ->with('all_total_transaction', $all_trx->total_transaction)
                ->with('ppob_total_transaction', $ppob_trx->total_transaction)
                ->with('lakupandai_total_transaction', $lakupandai_trx->total_transaction)
                ->with('all_total_amount_transaction', $all_trx->total_amount_transaction)
                ->with('ppob_total_amount_transaction', $ppob_trx->total_amount_transaction)
                ->with('lakupandai_total_amount_transaction', $lakupandai_trx->total_amount_transaction)
                ->with('month', $month)
                ->with('total_revenue', $totalRevenue)
                ->with('total_trx', $totalTrx)
                ->with('amount_trx', $amountTrx)
                ->with('total_merchant', $totalMerchant)
                ->with('total_merchant_active', $totalMerchantActive)
                ->with('total_merchant_resign', $totalMerchantResign)
                ->with('shareholders', $shareholders);

            // $chart = " ";
            // return view('charts.echarts', ['chart' => $chart]);
        }
        $response = [   
            'status'    => true, 
            'message'   => 'Success',
            'data'      => $data,
        ];

        return response()->json($response, 200);
    }

    public function agentReward(Request $request)
    {
        if(!$request->has('start_date') && $request->get('start_date')==''){
            $request->request->add([
                'start_date'      => date("F Y")
            ]);
        }
        if(!$request->has('end_date') && $request->get('end_date')==''){
            $request->request->add([
                'end_date'      => date("F Y")
            ]);
        }

        $reward_agent = ReportFee::select('terminal_id', 
                                        'merchant_id',	
                                        'agent_name');
        $reward_agent->selectRaw('sum(CAST(fee_agen as int)) as fee_agen');
        $reward_agent->selectRaw('sum(CAST(buffer as int)) as buffer');
        $reward_agent->selectRaw('CASE
                                        WHEN sum(CAST(buffer as int)) > 450000
                                        THEN sum(CAST(buffer as int)) - 450000
                                        ELSE 0
                                        END as reward_total');
        $reward_agent->groupBy('terminal_id', 'merchant_id', 'agent_name');
        $reward_agent->orderBy('buffer', 'desc');

        if($request->has('start_date') && $request->get('start_date')!=''){
            $date=date_create($request->get('start_date'));
            $reward_agent->where('tx_time', '>', date_format($date, 'Y-m-d').' 00:00:00');
        }

        if($request->has('end_date') && $request->get('end_date')!=''){
            $date=date_create($request->get('end_date'));
            $reward_agent->where('tx_time', '<', date_format($date, 'Y-m-t').' 23:59:59');
        }

        $start_month = date_create($request->get('start_date'));
        $end_month = date_create($request->get('end_date'));
        $start_month = date_format($start_month, 'F');
        $end_month = date_format($end_month, 'F');
        $month = "(" . $start_month . " - " . $end_month . " Period)";

        if($start_month == $end_month){
            $month = "(" . $start_month . " Period)";
        }

    
        $reward_agent = $reward_agent->paginate(10);

        return view('dashboard.dashboardv1')
                ->with('month', $month)
                ->with('data', $reward_agent);
    }

    public function detailDashboardAll(Request $request)
    {
        if(!$request->has('start_date') && $request->get('start_date')==''){
            $request->request->add([
                'start_date'      => date("F Y")
            ]);
        }
        if(!$request->has('end_date') && $request->get('end_date')==''){
            $request->request->add([
                'end_date'      => date("F Y")
            ]);
        }

        $data = ReportFee::select('terminal_id', 
                                        'merchant_id',	
                                        'agent_name');
        $data->selectRaw('SUM(CAST(total_amount_fee as int)) as total_amount_fee');
        $data->selectRaw('sum(CAST(fee_agen as int)) as fee_agen');
        $data->selectRaw('sum(CAST(fee_bjb as int)) as fee_bjb');
        $data->selectRaw('sum(CAST(fee_selada as int)) as fee_selada');
        $data->selectRaw('sum(CAST(buffer as int)) as buffer');
        $data->selectRaw('SUM(CAST(total_amount_transaction as int)) as total_amount_transaction');
        $data->selectRaw('count(*) as total_transaction');
        
        $data->groupBy('terminal_id', 'merchant_id', 'agent_name');
        $data->orderBy('total_amount_fee', 'desc');

        if($request->has('start_date') && $request->get('start_date')!=''){
            $date=date_create($request->get('start_date'));
            $data->where('tx_time', '>', date_format($date, 'Y-m-d').' 00:00:00');
        }

        if($request->has('end_date') && $request->get('end_date')!=''){
            $date=date_create($request->get('end_date'));
            $data->where('tx_time', '<', date_format($date, 'Y-m-t').' 23:59:59');
        }

        $data = $data->paginate(10);

        $start_month = date_create($request->get('start_date'));
        $end_month = date_create($request->get('end_date'));
        $start_month = date_format($start_month, 'F');
        $end_month = date_format($end_month, 'F');
        $month = "(" . $start_month . " - " . $end_month . " Period)";

        if($start_month == $end_month){
            $month = "(" . $start_month . " Period)";
        }

        return view('dashboard.dashboardv2')
                ->with('month', $month)
                ->with('data', $data);
    }

    public function detailDashboardPpob(Request $request)
    {
        if(!$request->has('start_date') && $request->get('start_date')==''){
            $request->request->add([
                'start_date'      => date("F Y")
            ]);
        }
        if(!$request->has('end_date') && $request->get('end_date')==''){
            $request->request->add([
                'end_date'      => date("F Y")
            ]);
        }

        $data = ReportFee::select('terminal_id', 
                                        'merchant_id',	
                                        'agent_name');
        $data->selectRaw('SUM(CAST(total_amount_fee as int)) as total_amount_fee');
        $data->selectRaw('sum(CAST(fee_agen as int)) as fee_agen');
        $data->selectRaw('sum(CAST(fee_bjb as int)) as fee_bjb');
        $data->selectRaw('sum(CAST(fee_selada as int)) as fee_selada');
        $data->selectRaw('sum(CAST(buffer as int)) as buffer');
        $data->selectRaw('SUM(CAST(total_amount_transaction as int)) as total_amount_transaction');
        $data->selectRaw('count(*) as total_transaction');
        $data->whereIn('product_name', array('E82560', 'E82561'));

        $data->groupBy('terminal_id', 'merchant_id', 'agent_name');
        $data->orderBy('total_amount_fee', 'desc');

        if($request->has('start_date') && $request->get('start_date')!=''){
            $date=date_create($request->get('start_date'));
            $data->where('tx_time', '>', date_format($date, 'Y-m-d').' 00:00:00');
        }

        if($request->has('end_date') && $request->get('end_date')!=''){
            $date=date_create($request->get('end_date'));
            $data->where('tx_time', '<', date_format($date, 'Y-m-t').' 23:59:59');
        }

        $data = $data->paginate(10);

        $start_month = date_create($request->get('start_date'));
        $end_month = date_create($request->get('end_date'));
        $start_month = date_format($start_month, 'F');
        $end_month = date_format($end_month, 'F');
        $month = "(" . $start_month . " - " . $end_month . " Period)";

        if($start_month == $end_month){
            $month = "(" . $start_month . " Period)";
        }

        return view('dashboard.dashboardv2')
                ->with('month', $month)
                ->with('data', $data);
    }

    public function detailDashboardLakupandai(Request $request)
    {
        if(!$request->has('start_date') && $request->get('start_date')==''){
            $request->request->add([
                'start_date'      => date("F Y")
            ]);
        }
        if(!$request->has('end_date') && $request->get('end_date')==''){
            $request->request->add([
                'end_date'      => date("F Y")
            ]);
        }

        $data = ReportFee::select('terminal_id', 
                                        'merchant_id',	
                                        'agent_name');
        $data->selectRaw('SUM(CAST(total_amount_fee as int)) as total_amount_fee');
        $data->selectRaw('sum(CAST(fee_agen as int)) as fee_agen');
        $data->selectRaw('sum(CAST(fee_bjb as int)) as fee_bjb');
        $data->selectRaw('sum(CAST(fee_selada as int)) as fee_selada');
        $data->selectRaw('sum(CAST(buffer as int)) as buffer');
        $data->selectRaw('SUM(CAST(total_amount_transaction as int)) as total_amount_transaction');
        $data->selectRaw('count(*) as total_transaction');
        $data->whereNotIn('product_name', array('E82560', 'E82561'));
        
        $data->groupBy('terminal_id', 'merchant_id', 'agent_name');
        $data->orderBy('total_amount_fee', 'desc');

        if($request->has('start_date') && $request->get('start_date')!=''){
            $date=date_create($request->get('start_date'));
            $data->where('tx_time', '>', date_format($date, 'Y-m-d').' 00:00:00');
        }

        if($request->has('end_date') && $request->get('end_date')!=''){
            $date=date_create($request->get('end_date'));
            $data->where('tx_time', '<', date_format($date, 'Y-m-t').' 23:59:59');
        }

        $start_month = date_create($request->get('start_date'));
        $end_month = date_create($request->get('end_date'));
        $start_month = date_format($start_month, 'F');
        $end_month = date_format($end_month, 'F');
        $month = "(" . $start_month . " - " . $end_month . " Period)";

        if($start_month == $end_month){
            $month = "(" . $start_month . " Period)";
        }

        $data = $data->paginate(10);

        return view('dashboard.dashboardv2')
                ->with('month', $month)
                ->with('data', $data);
    }

    public function agentAll(Request $request) {
        $data = Merchant::select('*');
        $data->where('terminal_id', 'like', "1413%")->orWhere('terminal_id', 'like', "1513%");

        
        $total = $data->count();

        $data = $data->get();

        foreach($data as $merchant) {
            if($merchant->status_agen == 0){
                $merchant->status_text = 'Pending';
            } else if ($merchant->status_agen == 1){
                $merchant->status_text = 'Active';
            } else {
                $merchant->status_text = 'Resign';
            }

            if($merchant->active_at == null || $merchant->active_at == ''){
                $merchant->active_at = '-';
            }

            if ($merchant->resign_at == null || $merchant->resign_at == ''){
                $merchant->resign_at = '-';
            }
        }

        $user = session()->get('user');
        // echo $user->username; die;

        return view('apps.merchants.list')
                ->with('data', $data)
                ->with('username', $user->username);
    }

    public function agentActive(Request $request) {
        $data = Merchant::select('*');
	    $data = $data->where('status_agen', '1');
        $data->where('terminal_id', 'like', "1413%")->orWhere('terminal_id', 'like', "1513%");

        
        $total = $data->count();

        $data = $data->get();

        foreach($data as $merchant) {
            if($merchant->status_agen == 0){
                $merchant->status_text = 'Pending';
            } else if ($merchant->status_agen == 1){
                $merchant->status_text = 'Active';
            } else {
                $merchant->status_text = 'Resign';
            }

            if($merchant->active_at == null || $merchant->active_at == ''){
                $merchant->active_at = '-';
            }

            if ($merchant->resign_at == null || $merchant->resign_at == ''){
                $merchant->resign_at = '-';
            }
        }

        $user = session()->get('user');
        // echo $user->username; die;

        return view('apps.merchants.list')
                ->with('data', $data)
                ->with('username', $user->username);
    }

    public function agentResign(Request $request) {
        $data = Merchant::select('*');
	    $data = $data->where('status_agen', '2');
        $data->where('terminal_id', 'like', "1413%")->orWhere('terminal_id', 'like', "1513%");

        
        $total = $data->count();

        $data = $data->get();

        foreach($data as $merchant) {
            if($merchant->status_agen == 0){
                $merchant->status_text = 'Pending';
            } else if ($merchant->status_agen == 1){
                $merchant->status_text = 'Active';
            } else {
                $merchant->status_text = 'Resign';
            }

            if($merchant->active_at == null || $merchant->active_at == ''){
                $merchant->active_at = '-';
            }

            if ($merchant->resign_at == null || $merchant->resign_at == ''){
                $merchant->resign_at = '-';
            }
        }

        $user = session()->get('user');
        // echo $user->username; die;

        return view('apps.merchants.list')
                ->with('data', $data)
                ->with('username', $user->username);
    }

    private function getInfo(Request $request)
    {
        DB::beginTransaction();
        try {
            $date           = $request->date;
            $group_id       = $request->group_id;
            $schema_id      = $request->schema_id;
            $dataCalculate  = $this->calculate($group_id, $date);
            
            $response = [
                'revenue'        => $dataCalculate['revenue'],
                'total_trx'      => $dataCalculate['count'],
                'amount_trx'     => $dataCalculate['amount']
            ];

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

    private function getInfoBJB(Request $request)
    {
        DB::beginTransaction();
        try {
            $date           = $request->date;
            $group_id       = $request->group_id;
            $schema_id      = $request->schema_id;
            $dataCalculate  = $this->calculateBJB($group_id, $date);
            
            $response = [
                'revenue'       => $dataCalculate['revenue'],
                'total_trx'     => $dataCalculate['count'],
                'amount_trx'    => $dataCalculate['amount'],
            ];
            
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

    private function calculateBJB($group_id, $date)
    {
        $groups = Group::where('parent_id', $group_id)->get();
        $result = [];
        $result['revenue']  = 0;
        $result['count']    = 0;
        $result['amount']   = 0;
        // foreach ($groups as $item){
        //     // Check if id is leaf or not
        //     $check = Group::where('parent_id', $item->id)->first();
        //     if($check){
        //         $result = $this->calculateBJB($item->id, $date);
        //     }else{
        //         // Count amount of transactions
        //         $userGroups = UserGroup::where('group_id', $item->id)->get();
        //         foreach($userGroups as $userGroup){
        //             $merchant = Merchant::where('user_id', $userGroup->user_id)->first();
        //             if($merchant){
        //                 $revenues = TransactionBJB::where('merchant_id', $merchant->mid)
        //                                 // ->whereDate('tx_time', $date)
        //                                 ->where('status', '00')
        //                                 ->get();
        //                 // Revenue
        //                 foreach($revenues as $revenue){
        //                    $result['revenue'] = $result['revenue'] + $revenue->fee;
        //                 }

        //                 // Count
        //                 $count = TransactionBJB::where('mid', $merchant->mid)
        //                                     ->where('status','00')
        //                                     ->count();
        //                 $result['count'] = $result['count'] + $count;

        //                 // Sum
        //                 $sum = TransactionBJB::where('mid', $merchant->mid)
        //                                     ->where('status','00')
        //                                     ->sum('total');
        //                 $result['amount'] = $result['amount'] + $sum;
        //             }
        //         }
        //     }
        // }
        return $result;
    }

    private function calcMerchantResign()
    {
        $merchant = Merchant::where('status_agen', '2');
        $merchant->where('terminal_id', 'like', "1413%")
        ->orWhere('terminal_id', 'like', "1513%")->get();
        return $merchant->count();
    }

    private function calcAvgLakupandaiTransaction()
    {
        $transaction = TransactionLog::where('tx_mti', '0200')->count();
        return $transaction;
    }

    private function calcAvgPpobTransaction()
    {
        $transaction = Transaction::count();
        return $transaction;
    }
    
    private function calcMerchantActive()
    {
        $merchant = Merchant::where('status_agen', '1');
        $merchant->where('terminal_id', 'like', "1413%")->orWhere('terminal_id', 'like', "1513%")->get();
        return $merchant->count();
    }

    private function calcMerchantTotal()
    {
        $merchant = Merchant::where('terminal_id', 'like', "1413%")
        ->orWhere('terminal_id', 'like', "1513%")->get();
        return $merchant->count();
    }

    private function calcMerchant($group_id)
    {
        $groups = Group::where('parent_id', $group_id)->get();
        $result = 0;
        foreach ($groups as $item){
            // Check if id is leaf or not
            $check = Group::where('parent_id', $item->id)->first();
            if($check){
                $result = $this->calcMerchant($item->id);
            }else{
                // Count amount of transactions
                $userGroups = UserGroup::where('group_id', $item->id)->get();
                foreach($userGroups as $userGroup){
                    $merchant = Merchant::where('user_id', $userGroup->user_id)->count();
                    $result = $result + $merchant;
                }
            }
        }
        return $result;
    }

    private function endsWith( $haystack, $needle ) {
        $length = strlen( $needle );
        if( !$length ) {
            return true;
        }
        return substr( $haystack, -$length ) === $needle;
    }
}
