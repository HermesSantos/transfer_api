<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\CommonUser;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserCommonController extends Controller
{
    public function CreateCommonUser(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $user = new CommonUser;
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->cpf = $data['cpf'];
            $user->password = Hash::make($data['password']);
            $user->role = 1;
            $user->wallet_code = Str::random(10);
            $user->save();

            $helper_response = Helper::CreateWallet($user->id, $user->role, $user->wallet_code);
            if ($helper_response == true) {
                return response()->json('User created!', 200);
            } else {
                return response()->json('Erro when wallet id was created, please contact support so you can make transactions');
            }
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function GetAllCommonUsers(): JsonResponse
    {
        $users = DB::table('common_users')->get();
        return response()->json($users);
    }

    public function GetCommonUserById(Request $request): JsonResponse
    {
        $request = $request->all();
        $user = DB::table('common_users')->where('id', $request['id'])->first();
        if (isset($user)) {
            return response()->json($user);
        } else {
            return response()->json(404);
        }
    }

    public function DeleteCommonUser(Request $request): JsonResponse
    {
        $user = $this->GetCommonUserById($request);
        if ($user->original != 404) {
            DB::table('common_users')->where('id', $user->original->id)->delete();
            return response()->json('Deleted successfuly', 200);
        } else {
            return response()->json('Not Found', 404);
        }
    }
}
