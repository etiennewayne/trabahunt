<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Models\Applicant;

class ApplicantListController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth');
        $this->middleware('verified');

    }

    public function index(){
        return view('employer.applicant-list');
    }

    public function getApplicantList(Request $req){
     
        $user = Auth::user();
       
        $sort = explode('.', $req->sort_by);
       
        // $data = DB::table('applicants as a')
        //     ->join('job_posts as b', 'a.job_post_id', 'b.job_post_id')
        //     ->join('companies as c', 'b.company_id', 'c.company_id')
        //     ->join('users as d', 'a.user_id', 'd.user_id')
        //     ->where('c.user_id', $user->user_id)
        //     ->orderBy('a.applicant_id', 'desc')
        //     ->paginate($req->perpage);

        // return $data;

        $data = Applicant::with(['applicant', 'job_post'])
            ->addSelect(['total_rating' => function ($q){
                $q->selectRaw('sum(rating)')
                ->from('employee_ratings')
                ->whereColumn('user_id', 'applicants.user_id');
            }])
            ->addSelect(['total_raters' => function ($q){
                $q->selectRaw('count(*)')
                ->from('employee_ratings')
                ->whereColumn('user_id', 'applicants.user_id');
            }])
            ->selectRaw('(select(total_rating) / (select count(*) from employee_ratings where user_id = applicants.user_id)) as user_total_rating')
            ->where('employer_id', $user->user_id)
            ->orderBy('applicant_id', 'desc')
            ->paginate($req->perpage);


        return $data;


    }

    public function endContract($id){
        $data = Applicant::find($id);
        $data->is_end_contract = 1;
        $data->save();

        return response()->json([
            'status' => 'ended'
        ], 200);
    }



}
