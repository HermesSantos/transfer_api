<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

	public function UserTransfer(Request $request)
	{
		$data = $request->all();
		$has_balance = $this->UserVerifyBalance($data['owner_wallet_code']);
		if ($has_balance) {
			// subtract from wallet owner
			$balance = DB::table('wallets')->where('wallet_code', $data['owner_wallet_code'])->select('balance')->first();
			$new_owner_balance = $balance->balance - $data['amount'];
			if ($new_owner_balance < 0) {
				return response()->json('Transfer amount need to be less or equal of your amount value', 401);
			} else {
				$receiver_balance = DB::table('wallets')->where('wallet_code', $data['receiver_wallet_code'])->first();
				$new_receiver_balance = $data['amount'] + $receiver_balance->balance;
				DB::table('wallets')->where('wallet_code', $data['owner_wallet_code'])->update(['balance' => $new_owner_balance]);
				DB::table('wallets')->where('wallet_code', $data['receiver_wallet_code'])->update(['balance' => $new_receiver_balance]);
				return response()->json(200);
			}
		}
	}
	public function UserGetBalance(Request $request)
	{
		$data = $request->all();
		$balance = DB::table('wallets')->select('balance')->where('wallet_code', $data['wallet_code'])->first();
		return response()->json($balance);
	}

	public function UserGetWalletCode(Request $request)
	{
        $data = $request->all();
        
        $password_db = DB::table('common_users')->where('cpf', $data['cpf'])->select('password')->first();
        $password_data = $data['password'];

        $authorized = Hash::check($password_data, $password_db->password);
        if($authorized){
            $wallet_code = DB::table('common_users')->select('wallet_code')->where('cpf', $data['cpf'])->first();
            return response()->json($wallet_code, 200);
        }
        return response()->json('Unauthorized', 401);
	}

	private function UserVerifyBalance($wallet_code): bool
	{
		$balance = DB::table('wallets')->where('wallet_code', $wallet_code)->select('balance')->first();
		if ($balance->balance > 0) return true;
		return false;
	}
}
