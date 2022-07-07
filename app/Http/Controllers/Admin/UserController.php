<?php

namespace App\Http\Controllers\Admin;

use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Skpd;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;

class UserController extends \App\Http\Controllers\Controller
{
    //
    public function index(Request $request)
    {
        return view('users.index');
    }

    public function datatables(Request $request)
    {

        $datatables = DataTables::of(User::with('master_skpd', 'roles'))
            ->addIndexColumn()
            ->make(true);
        return $datatables;
    }

    public function create(Request $request)
    {
        $roles = Role::get();
        $skpd = Skpd::get();
        return view('users.form', [
            'roles' => $roles,
            'skpd' => $skpd
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|unique:users,username',
            // 'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'skpd' => 'required',
            'role' => 'required',
        ]);

        try {
            DB::beginTransaction();
            $user = User::create([
                'username' => $request->username,
                // 'email' => $request->email,
                'password' => Hash::make($request->password),
                'skpd_id' => $request->skpd,
                'avatar' => 'default-avatar.png',
            ]);

            $role = Role::findById($request->role);
            $user->assignRole($role);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response($e->getMessage(), 500);
        }

        return response("User Berhasil Ditambahkan");
    }

    public function edit(Request $request, $id)
    {
        $user = User::with('roles')->findOrFail($id);
        $role = $user->roles->first();
        $roles = Role::get();
        $skpd = Skpd::get();
        return view('users.form', [
            'edit' => $user,
            'role' => $role,
            'roles' => $roles,
            'skpd' => $skpd
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::with('roles')->findOrFail($id);
        $oldRole = $user->roles->first();
        $validations = [];
        if ($user->username != $request->username) {
            $validations['username'] = 'required|unique:users,username';
        }

        // if ($user->email != $request->email) {
        //     $validations['email'] = 'required|email|unique:users,email';
        // }

        if ($user->skpd_id != $request->skpd) {
            $validations['skpd'] = 'exists:master_skpd,id_skpd';
        }

        if ($user->roles->first()->id != $request->role) {
            $validations['role'] = 'required';
        }

        $this->validate($request, $validations);

        try {
            DB::beginTransaction();

            $user->username = $request->username;
            // $user->email = $request->email;
            if (!empty($request->password)) {
                $user->password = Hash::make($request->password);
            }
            $user->skpd_id = $request->skpd;
            $user->save();

            $role = Role::findById($request->role);
            $user->removeRole($oldRole);
            $user->assignRole($role);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response($e->getMessage(), 500);
        }

        return response("Update User Berhasil");
    }

    public function selfUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validations = [];

        if ($user->username != $request->username) {
            $validations['username'] = 'required|unique:users,username';
        }

        // if ($user->email != $request->email) {
        //     $validations['email'] = 'required|email|unique:users,email';
        // }

        // if ($user->skpd_id != $request->skpd) {
        //     $validations['skpd'] = 'exists:master_skpd,id_skpd';
        // }

        // if ($user->roles->first()->id != $request->role) {
        //     $validations['role'] = 'required';
        // }

        $this->validate($request, $validations);
        // dd($request->hasfile('avatar'));
        try {
            DB::beginTransaction();

            $user->username = $request->username;
            // $user->email = $request->email;
            if (!empty($request->password)) {
                $user->password = Hash::make($request->password);
            }
            if ($request->hasfile('avatar')) {
                $oldfile = $user->pluck('avatar');
                $newfile = $request->file('avatar')->getClientOriginalName();
                $user->avatar = $newfile;
                // dd($oldfile[0]);
                // foreach ($oldfile as $old) {
                if ($oldfile[0] != "default-avatar.png") {
                    if (File::exists(public_path('assets/avatar/' . $oldfile[0]))) {
                        File::delete(public_path('assets/avatar/' . $oldfile[0]));
                    }
                }
                // };
                $request->file('avatar')->move(public_path('assets/avatar'), $newfile);
                $newfile = $request->file('avatar')->getClientOriginalName();
                // dd($newfile);
                $user->avatar = $newfile;
            };
            dd($user->username, $user->password, $user->avatar);

            $user->save();

            // $user->skpd_id = $request->skpd;

            // $role = Role::findById($request->role);
            // $user->assignRole($role);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response($e->getMessage(), 500);
        }

        return response("Update User Berhasil");
    }

    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);

        try {
            $user->delete();
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }

        return response("User Berhasil Dihapus");
    }
}
