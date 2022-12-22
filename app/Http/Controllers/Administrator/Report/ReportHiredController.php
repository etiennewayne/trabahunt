<?php

namespace App\Http\Controllers\Administrator\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Applicant;

class ReportHiredController extends Controller
{
    //

    public function index(){

        $data = Applicant::where('is_accepted', 1)
            ->with(['applicant', 'job_post'])
            ->get();

        return view('administrator.report.hired-list')
            ->with('data', $data);
    }
}
