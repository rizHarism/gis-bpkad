<?php

namespace App\Http\Controllers\Admin;

use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserController extends \App\Http\Controllers\Controller
{
    //
    public function index(Request $request)
    {
        return view('users.index');
    }

    public function datatables(Request $request)
    {
        $users = User::query();
        return datatables()->eloquent($users)->toJson();
    }

    public function create(Request $request)
    {
        $roles = Role::get();
        return view('users.form', [
            'roles' => $roles
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'role' => 'required',
        ]);

        try {
            DB::beginTransaction();
            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'skpd_id' => $request->skpd,
            ]);

            $role = Role::findById($request->role);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response($e->getMessage(), 500);
        }

        return response("User has been created successfully");
    }
}
