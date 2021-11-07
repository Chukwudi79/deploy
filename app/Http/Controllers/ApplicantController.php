<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Applicant;
use Illuminate\Http\Request;

class ApplicantController extends Controller
{

    public function store(Request $request, $job)
    {
        // return $job;
        $rules = [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'location' => 'nullable',
                'cv' => 'required|mimes:pdf,docx,doc|max:512',
        ];

        $this->validate($request, $rules);

        if ($request->hasFile('cv')) {
            $extension = $request->file('cv')->getClientOriginalExtension();
            $name = 'cv-' . rand(time(), 9999999) . '.' . $extension;
            $cv = $request->file('cv')->storeAs('public/documents', $name);
        }

        $job = Job::find($job);
        $applicant = new Applicant;
        $applicant->job_id = $job->id;
        $applicant->first_name = $request->first_name;
        $applicant->last_name = $request->last_name;
        $applicant->email = $request->email;
        $applicant->phone = $request->phone;
        $applicant->location = $request->location;
        $applicant->cv = $cv;
        $applicant->save();

        return response()->json(['status' => 'success', 'message' => 'Application successfully Submitted'], 200);

    }

}
