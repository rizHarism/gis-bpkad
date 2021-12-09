<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class RoleController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('roles.index');
    }

    public function datatables()
    {
        $roles = Role::query();
        return datatables()->eloquent($roles)->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::get();

        $permissionsFormatted = [];

        if ($permissions) {
            foreach ($permissions as $permission) {
                $_permission = explode(".", $permission->name);
                if (count($_permission) == 2) {
                    $permissionsFormatted[$_permission[0]][] = [
                        'name' => $_permission[1],
                        'value' => $permission->id
                    ];
                }
            }
        }
        return view('roles.form', [
            'permissions' => $permissions,
            'permissionsFormatted' => $permissionsFormatted
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $role = Role::create(['name' => $request->input('name')]);
            $role->syncPermissions($request->input('permission'));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response($e->getMessage(), 501);
        }

        return response('Role has been created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();

        $permissionsFormatted = [];

        if ($permissions) {
            foreach ($permissions as $permission) {
                $_permission = explode(".", $permission->name);
                if (count($_permission) == 2) {
                    $permissionsFormatted[$_permission[0]][] = [
                        'name' => $_permission[1],
                        'value' => $permission->id
                    ];
                }
            }
        }

        return view('roles.form',[
            'role' => $role,
            'permissions' => $permissions,
            'permissionsFormatted' => $permissionsFormatted,
            'rolePermissions' => $rolePermissions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $role = Role::find($id);
            $role->name = $request->input('name');
            $role->save();
            $role->syncPermissions($request->input('permission'));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response('Failed to update the role.', 500);
        }

        return response('The role has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        try {
            DB::beginTransaction();

            $role->syncPermissions([]);
            $role->delete();

            DB:: commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response($e->getMessage(), 501);
        }

        return response("Role has been deleted successfully");
    }
}
