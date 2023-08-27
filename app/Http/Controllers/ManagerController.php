<?php

namespace App\Http\Controllers;

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
            $manager->wallet_id = Str::random(10);
            $manager->role = 2;
            $manager->save();
            return response()->json('Manager created successfully', 200);
        } catch (Exception $e) {
            return response()->json($e->errorInfo[1] == 1062 ? 'Manager already exists' : $e, 500);
        }
    }
    public function GetAllManagers(Request $request)
    {
        $managers = DB::table('managers')->get();
        return response()->json($managers);
    }
    public function GetManagerById(Request $request)
    {
    }
}
