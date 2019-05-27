<?php

namespace App\Http\Controllers\Api\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function getUsers(){
        $user = Auth::user();
        $users = User::where('id','!=',$user->id)->get()->toArray();
        return response()->json($users);
    }
}
