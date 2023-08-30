<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManageManagerWalletAccount extends Controller
{
    public function ManagerGetBalance (Request $request)
    {
        $data = $request->all();
        $balance = DB::table('wallets')->select('balance')->where('wallet_code', $data['wallet_code'])->first();
        return response()->json($balance);
    }
}
