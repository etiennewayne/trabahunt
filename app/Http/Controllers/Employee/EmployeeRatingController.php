<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class EmployeeRatingController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('employee');
    }

    public function store(Request $req){

        CompanyRating::create([
            'company_id' => $req->company_id,
            'user_id' => $req->user_id,
            'job_post_id' => $req->job_post_id,
            'rating' => $req->rating,
        ]);

        return response()->json([
            'status' => 'submitted'
        ], 200);

    }

    
}
