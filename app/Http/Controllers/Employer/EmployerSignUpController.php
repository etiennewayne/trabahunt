<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployerSignUpController extends Controller
{
    //

    public function __construct(){

    }


    public function index(){
        return view('employer.employer-signup');
    }

    
}
