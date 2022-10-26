<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Jobtype;
use App\Models\Category;
use App\Models\JobPost;


class EmployerJobPostController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
    }

    public function index($companyId){
        $jobTypes = Jobtype::orderBy('jobtype')->get();
        $categories = Category::orderBy('category')->get();


        return view('employer.employer-job-post')
            ->with('companyId', $companyId)
            ->with('jobtypes', $jobTypes)
            ->with('categories', $categories);
    }

    public function getJobPosts(Request $req){

        return JobPost::with(['company', 'jobtype', 'category'])
            ->where('company_id', $req->cid)
            ->paginate($req->perpage);
    }

    public function store(Request $req){
        //return $req;

        $validate = $req->validate([
            'title' => ['required'],
            'job_desc' => ['required'],
            'category' => ['required'],
            'job_type' => ['required'],
        ]);

        JobPost::create([
            'title' => strtoupper($req->title),
            'company_id' => $req->company_id,
            'jobtype_id' => $req->job_type,
            'category_id' => $req->category,
            'job_desc' => $req->job_desc,
            'salary' => $req->salary
        ]);

        return response()->json([
            'status' => 'saved'
        ], 200);
    }


}
