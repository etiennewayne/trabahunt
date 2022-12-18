<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Jobtype;
use App\Models\Category;
use App\Models\JobPost;
use App\Models\Qualification;
use App\Models\JobPostSkill;

class EmployerJobPostController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
    }

    public function index($companyId){
        $jobTypes = Jobtype::orderBy('jobtype')->get();
        $categories = Category::orderBy('category')->get();
        $qualifications = Qualification::orderBy('qualification_id')->get();

        return view('employer.employer-job-post')
            ->with('companyId', $companyId)
            ->with('jobtypes', $jobTypes)
            ->with('categories', $categories)
            ->with('qualifications', $qualifications);
    }

    public function show($id){
        return JobPost::with(['skills', 'province', 'city', 'barangay'])->find($id);
    }

    public function getJobPosts(Request $req){

        return JobPost::with(['company', 'jobtype', 'category', 'skills', 'province', 'city', 'barangay'])
            ->where('company_id', $req->cid)
            ->orderBy('job_post_id', 'desc')
            ->paginate($req->perpage);
    }

    public function store(Request $req){


        $req->validate([
            'title' => ['required'],
            'job_desc' => ['required'],
            'category_id' => ['required'],
            'minimum_experience' => ['required'],
            'minimum_qualification' => ['required'],
            'jobtype_id' => ['required'],
            'province' => ['required'],
            'city' => ['required'],
            'barangay' => ['required'],
        ], $message = [
            'jobtype_id.required' => 'Please select job type.',
            'category_id.required' => 'Please select category'
        ]);

        $jobPost = JobPost::create([
            'title' => strtoupper($req->title),
            'company_id' => $req->company_id,
            'jobtype_id' => $req->jobtype_id,
            'category_id' => $req->category_id,
            'job_desc' => $req->job_desc,
            'minimum_experience' => $req->minimum_experience,
            'minimum_qualification' => $req->minimum_qualification,
            'from_salary' => $req->from_salary,
            'to_salary' => $req->to_salary,
            'province' => strtoupper($req->province),
            'city' => strtoupper($req->city),
            'barangay' => strtoupper($req->barangay),
            'street' => strtoupper($req->street),
        ]);


        if($req->skills){
            $skills = [];

            foreach($req->skills as $skill){
                array_push($skills, [
                    'job_post_id' => $jobPost->job_post_id,
                    'job_post_skill' => $skill['skill']
                ]);
            }
            JobPostSkill::insert($skills);
        }


        return response()->json([
            'status' => 'saved'
        ], 200);
    }

    public function update(Request $req, $id){

        $req->validate([
            'title' => ['required'],
            'job_desc' => ['required'],
            'category_id' => ['required'],
            'jobtype_id' => ['required'],
            'minimum_experience' => ['required'],
            'minimum_qualification' => ['required'],
            'province' => ['required'],
            'city' => ['required'],
            'barangay' => ['required'],
        ]);

        $data = JobPost::find($id);
        $data->title = strtoupper($req->title);
        //$data->company_id = $req->company_id;
        $data->jobtype_id = $req->jobtype_id;
        $data->category_id = $req->category_id;
        $data->job_desc = $req->job_desc;
        $data->minimum_experience = $req->minimum_experience;
        $data->minimum_qualification = $req->minimum_qualification;
        $data->from_salary = $req->from_salary;
        $data->to_salary = $req->to_salary;
        $data->province = strtoupper($req->province);
        $data->city = strtoupper($req->city);
        $data->barangay = strtoupper($req->barangay);
        $data->street = strtoupper($req->street);
        $data->save();


        if($req->skills){
            $skills = [];

            foreach($req->skills as $skill){
                JobPostSkill::updateOrCreate(
                    ['job_post_id' => $id, 'job_post_skill' => $skill['skill']],
                    [
                        'job_post_id' => $id, 'job_post_skill' => $skill['skill']
                    ]
                );
            }

        }
        return response()->json([
            'status' => 'updated'
        ], 200);
    }

    public function destroy($id){
        JobPost::destroy($id);

        return response()->json([
            'status' => 'deleted'
        ], 200);
    }


    public function deleteSkill($skill, $job_post_id){
        JobPostSkill::where('job_post_skill', $skill)
            ->where('job_post_id', $job_post_id)->delete();
        return response()->json([
            'status' => 'deleted'
        ], 200);

    }
}
