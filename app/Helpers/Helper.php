<?php

namespace App\Helpers;

use App\Models\Wallet;
use Psy\Exception\Exception;

class Helper
{
    public static function CreateWallet($id, $role, $wallet_code): bool
    {
        try {
            if ($role == 1) {
                Wallet::create(['user_id' => $id, 'wallet_code' => $wallet_code])->save();
            } else {
                Wallet::create(['manager_id' => $id, 'wallet_code' => $wallet_code])->save();
            }
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
