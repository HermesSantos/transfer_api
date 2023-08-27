<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManageWalletAccount extends Controller
{
    static $manager_role = 2;
    static $user_role = 1;
    public function UserAddBalance(Request $request)
    {
        $data = $request->all();
        $balance = DB::table('wallets')->where('user_id', $data['id'])->update(['balance' => $data['balance']]);
        if ($balance) return response()->json('Balance was updated successfully', 200);
    }
    public function ManagerAddBalance(Request $request)
    {
        $data = $request->all();
        $balance = DB::table('wallets')->where('manager_id', $data['id'])->update(['balance' => $data['balance']]);
        if ($balance) return response()->json('Balance was updated successfully', 200);
    }
    public function UserTransfer(Request $request)
    {
        $data = $request->all();
        $has_balance = $this->VerifyBalance($data['owner_id'], self::$user_role);
        if ($has_balance) {
            // subtract from wallet owner
            $balance = DB::table('wallets')->where('user_id', $data['owner_id'])->select('balance')->first();
            $new_owner_balance = $balance->balance - $data['amount'];
            if ($new_owner_balance < 0) {
                return response()->json('Transfer amount need to be less or equal of your amount value', 401);
            } else {
                $receiver_balance = DB::table('wallets')->where('wallet_code', $data['receiver_wallet_code'])->first();
                $new_receiver_balance = $data['amount'] + $receiver_balance->balance;
                DB::table('wallets')->where('user_id', $data['owner_id'])->update(['balance' => $new_owner_balance]);
                DB::table('wallets')->where('wallet_code', $data['receiver_wallet_code'])->update(['balance' => $new_receiver_balance]);
                return response()->json(200);
            }
        }
    }
    private function VerifyBalance($id, $role): bool
    {
        if ($role == 1) {
            $balance = DB::table('wallets')->where('user_id', $id)->select('balance')->first();
            if ($balance->balance > 0) return true;
            return false;
        } else {
            $balance = DB::table('wallets')->where('user_id', $id)->select('balance')->first();
            if ($balance->balance > 0) return true;
            return false;
        }
    }
}
