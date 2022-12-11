<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeDashboardController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('employee');
    }

    public function index(){

        $id = Auth::user()->user_id;

        $user = User::where('user_id', $id)
            ->with(['categories'])->first();

        return view('employee.employee-dashboard')
            ->with('user', $user); //blade.php
    }

    public function getRecommendedJob(Request $req){
        return $req;
        $categories = json_decode($req->categories);

        return $categories;
    }



}