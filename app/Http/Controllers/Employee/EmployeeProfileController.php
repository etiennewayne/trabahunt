<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
Use App\Models\User;


class EmployeeProfileController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('employee');
    }

    public function index(){
        $id = Auth::user()->user_id;
        return view('employee.employee-profile')
            ->with('id', $id); //blade.php
    }

    public function getUser($id){
        return User::with(['province', 'city', 'barangay'])
            ->where('user_id', $id)->first();
    }

    

}
