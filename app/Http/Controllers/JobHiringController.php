<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use Illuminate\Http\Request;

class JobHiringController extends Controller
{
    //

    public function getJobsHiring(Request $req){

        $data = \DB::table('job_posts as a')
            ->join('categories as b',  'a.category_id', 'b.category_id')
            ->join('job_types as c', 'a.jobtype_id', 'c.jobtype_id')
            ->join('companies as d', 'a.company_id', 'd.company_id')
            ->where(function ($query) use ($req) {
                $query->where('d.company', 'like', $req->key . '%')
                    ->orWhere('a.title', 'like', '%' . $req->key . '%');
            })
            ->where('b.category', 'like', $req->category . '%')
            ->where('c.jobtype', 'like', $req->jobtype . '%')
            ->get();

        return $data;
    }
}
