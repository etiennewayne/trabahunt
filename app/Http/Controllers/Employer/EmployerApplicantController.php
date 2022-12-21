<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Applicant;

class EmployerApplicantController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth');
    }
    
    public function index($job_post_id){

        return view('employer.applicants')
            ->with('job_post_id', $job_post_id);
    }

    public function getApplicants($job_post_id){
        $data = Applicant::with(['applicant'])->where('job_post_id', $job_post_id)
            ->get();

        return $data;
    }
}
