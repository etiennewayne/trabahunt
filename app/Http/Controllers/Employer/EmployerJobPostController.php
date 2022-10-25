<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployerJobPostController extends Controller
{
    //


    public function __construct(){
        $this->middleware('auth');
    }

    public function index($companyId){
        return view('employer.employer-job-post');
    }

    

    public function store(Request $req){

        return $req;
    }
}
