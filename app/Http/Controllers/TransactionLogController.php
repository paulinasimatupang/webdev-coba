<?php

namespace App\Http\Controllers;

use App\Entities\TransactionLog;
use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;

class TransactionLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $transactionlog = TransactionLog::where('proc_code', '=', '500000');
        //
        if($request->has('stan') && $request->get('stan')!=''){
            $transactionlog->where('stan', '=', $request->get('stan'));
        }
        if($request->has('additional_data') && $request->get('additional_data')!=''){
            $transactionlog->where('additional_data', '=', $request->get('additional_data'));
        }
  
        $transactionlog = $transactionlog->latest()->paginate(5);
        return view('apps.transactionlog.index',compact('transactionlog'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('apps.transactionlog.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'stan' => 'required',
            'proc_code' => 'required',
            'responsecode' => 'required',
            'tx_mti' => 'required',
            'rp_mti' => 'required',
            'tx_amount' => 'required',
            'transaction_id' => 'required',
            'additional_data' => 'required',
        ]);
  
        TransactionLog::create($request->all());
   
        return redirect()->route('transactionl_og')
                        ->with('success','Transaction Log created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TransactionLog  $transactionLog
     * @return \Illuminate\Http\Response
     */
    public function show(TransactionLog $transactionLog)
    {
        //
        echo $transactionLog->stan;
        return view('apps.transactionlog.show',compact('transactionLog'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TransactionLog  $transactionLog
     * @return \Illuminate\Http\Response
     */
    public function edit($stan)
    {
        //
        $data = TransactionLog::where('additional_data', '=', $stan)
                                ->orderBy('tx_time', 'desc')
                                ->first();
        return view('apps.transactionlog.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TransactionLog  $transactionLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $transactionLog)
    {
        //
        $request->validate([
            'tx_mti' => 'required',
            'rp_mti' => 'required',
        ]);

        $data = TransactionLog::where('additional_data', $transactionLog)
              ->update(['tx_mti' => $request->get('tx_mti'),
                        'rp_mti' => $request->get('rp_mti')]);
  
        // $transactionLog->update($request->all());
  
        if($data){
            return redirect()->route('transaction_log')
                        ->with('success','Transaction Log updated successfully');
        } else {
            echo "gagal update";
        }
        
    }

    public function updateStatus(Request $request, $additional_data)
    {

        DB::beginTransaction();
        try {
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);
            $transaction = TransactionLog::where('additional_data', '=', $additional_data);
                if ($transaction->tx_mti == '0200' || $transaction->rp_mti == '0210') {
                    $reqData['tx_mti']               = '0400';
                    $reqData['rp_mti']               = '0410';
                }
                $data = $this->repository->update($reqData, $additional_data);
            
            if($data){    
                DB::commit();
                return Redirect::to('transaction_log')
                                    ->with('message', 'Status updated');
            }else{
                DB::rollBack();
                return Redirect::to('transaction_log')
                            ->with('error', $data->error)
                            ->withInput();
            }
        } catch (Exception $e) {
            DB::rollBack();
            return Redirect::to('transaction_log')
                        ->with('error', $e)
                        ->withInput();
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            return Redirect::to('transaction_log')
                        ->with('error', $e)
                        ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TransactionLog  $transactionLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransactionLog $transactionLog)
    {
        //
        $transactionLog->delete();
  
        return redirect()->route('transaction_log')
                        ->with('success','Transaction Log deleted successfully');
    }
}
