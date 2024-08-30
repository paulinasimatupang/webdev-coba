<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class TransactionService
{
    public function rankTransactionsByMerchantUser(): Collection
    {
        $transactions = DB::connection('pgsql_billiton')->table('transaction')
            ->select('account_number', DB::raw('COUNT(transaction_code) as transaction_count'))
            ->where('account_number', '!=', '') 
            ->whereNotNull('account_number')
            ->groupBy('account_number')
            ->get(); 

        $merchants = DB::connection('pgsql')->table('merchants')
            ->select('no', 'user_id', 'name', 'address', 'email', 'mid') // Pastikan kolom tambahan diambil
            ->get()
            ->keyBy('no'); 

        $users = DB::connection('pgsql')->table('users')
            ->select('id', 'username')
            ->get()
            ->keyBy('id'); 

        $rankedTransactions = $transactions->map(function ($transaction) use ($merchants, $users) {
            $account_number = $transaction->account_number;
            $merchant = $merchants->get($account_number);

            if ($merchant) {
                $merchant_name = $merchant->name;
                $address = $merchant->address;
                $email = $merchant->email;
                $mid = $merchant->mid;
                $username = 'Unknown';

                $user = $users->get($merchant->user_id);
                if ($user) {
                    $username = $user->username;
                }

                return (object)[
                    'account_number' => $account_number,
                    'merchant_name' => $merchant_name,
                    'address' => $address,
                    'email' => $email,
                    'mid' => $mid,
                    'username' => $username,
                    'transaction_count' => $transaction->transaction_count,
                ];
            }

            return null;
        })->filter(); 

        $rankedTransactions = $rankedTransactions->sortByDesc('transaction_count');

        return $rankedTransactions;
    }
}
