<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use Illuminate\Http\Request;

class JobHiringController extends Controller
{
    //

    public function getJobsHiring(Request $req){

        // $data = \DB::table('job_posts as a')
        //     ->join('categories as b',  'a.category_id', 'b.category_id')
        //     ->join('job_types as c', 'a.jobtype_id', 'c.jobtype_id')
        //     ->join('companies as d', 'a.company_id', 'd.company_id')

        //     ->join('provinces as e', 'a.province', 'e.provCode')
        //     ->join('cities as f', 'a.city', 'f.citymunCode')
        //     ->join('barangays as g', 'a.barangay', 'g.brgyCode')
            
        //     ->where(function ($query) use ($req) {
        //         $query->where('d.company', 'like', $req->key . '%')
        //             ->orWhere('a.title', 'like', '%' . $req->key . '%');
        //     })
        //     ->with(['skills' => function($q){
        //         $q->get();
        //     }])
        //     ->where('b.category', 'like', $req->category . '%')
        //     ->where('c.jobtype', 'like', $req->jobtype . '%')
        //     ->get();

        $data = JobPost::with(['category', 'jobtype', 'company', 'skills', 'province', 'city', 'barangay'])
            ->whereHas('category', function($q) use ($req){
                $q->where('category', 'like', $req->category . '%');
            })
            ->whereHas('jobtype', function($q) use ($req){
                $q->where('jobtype', 'like', $req->jobtype . '%');
            });

        return $data->get();
    }
}
