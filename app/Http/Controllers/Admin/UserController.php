<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
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
}
