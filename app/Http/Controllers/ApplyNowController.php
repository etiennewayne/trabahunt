<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Applicant;
use Auth;


class ApplyNowController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth');
    }
    public function applyNow($id){

        return view('apply-now')
            ->with('job_post_id', $id);
    }

    public function store(Request $req){

        $id = Auth::user()->user_id;
        $pdfPath = $req->file('dropFiles');
        $path = '';

        if($pdfPath){
            $validate = $req->validate([
                'dropFiles' => ['mimes:pdf'],
            ], $message = [
                'dropFiles.mimes' => 'Type of the file must be a pdf file.'
            ]);
        }
        if($pdfPath){
            $pathFile = $pdfPath->store('public/applications'); //get path of the file
            $pdfPath = explode('/', $pathFile); //split into array using /
            $path = $pdfPath[2];
        }

        $exists = Applicant::where('job_post_id', $req->job_post_id)
            ->where('user_id', $id)
            ->exists();

        if($exists){
            return response()->json([
                'errors' => 'exists'
            ], 422);
        }

        Applicant::create([
            'pitch' => $req->pitch,
            'job_post_id' => $req->job_post_id,
            'user_id' => $id,
            'resume_path' => $path,
        ]);

        return response()->json([
            'status' => 'saved'
        ], 200);
    }
}
