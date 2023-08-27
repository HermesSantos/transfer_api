<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Manager;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ManagerController extends Controller
{
    public function CreateManager(Request $request)
    {
        try {
            $data = $request->all();
            $manager = new Manager();
            $manager->name = $data['name'];
            $manager->email = $data['email'];
            $manager->password = Hash::make($data['password']);
            $manager->cpf = $data['cpf'];
            $manager->wallet_code = Str::random(10);
            $manager->role = 2;
            $manager->save();

            $wallet_created = Helper::CreateWallet($manager->id, $manager->role, $manager->wallet_code);
            if ($wallet_created == true) {
                return response()->json('Manager created successfully', 200);
            } else {
                return response()->json('Erro when wallet id was created, please contact support so you can make transactions');
            }
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }
    public function GetAllManagers()
    {
        $managers = DB::table('managers')->get();
        return response()->json($managers);
    }
    public function GetManagerById(Request $request)
    {
        $data = $request->all();
        $manager = DB::table('managers')->where('id', $data['id'])->get();
        if (isset($manager)) {
            return response()->json($manager);
        } else {
            return response()->json('Not found', 404);
        }
    }
}
