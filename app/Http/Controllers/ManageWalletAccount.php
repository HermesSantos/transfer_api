<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManageWalletAccount extends Controller
{
    public function UserAddBalance(Request $request)
    {
        $data = $request->all();
        $balance = DB::table('wallets')->where('user_id', $data['id'])->update(['balance' => $data['balance']]);
        if ($balance) return response()->json('Balance was updated successfully', 200);
    }
}
