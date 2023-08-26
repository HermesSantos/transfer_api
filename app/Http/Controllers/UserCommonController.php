<?php

namespace App\Http\Controllers;

use App\Models\CommonUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserCommonController extends Controller
{
    public function CreateCommonUser(Request $request): JsonResponse
    {
        $data = $request->all();
        $user = new CommonUser;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->cpf = $data['cpf'];
        $user->password = $data['password'];
        $user->role = 1;
        $user->wallet_id = Str::random(10);
        $user->save();
        return response()->json($user);
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
            return response()->json('Not found', 404);
        }
    }

    public function DeletCommonUser(Request $request): JsonResponse
    {
        $user = $this->GetCommonUserById($request);
        if (isset($user)) {
            return response()->json('Deleted successfuly', 200);
        } else {
            return response()->json('Not Found', 404);
        }
    }
}
