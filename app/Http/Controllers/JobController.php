<?php

namespace App\Http\Controllers;

// use Auth;
use App\Models\Job;
use App\Models\Applicant;
use Illuminate\Http\Request;
use App\Http\Resources\JobResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobs = Job::all();

        return response()->json(['data' =>$jobs], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required',
            'location' => 'required',
            'salary' => 'nullable',
            'description' => 'required',
            'benefits' => 'nullable',
            'category' => 'nullable',
            'type' => 'required',
            'work_condition' => 'required',
        ];

        $this->validate($request, $rules);
        $str = 'ABCDEFGHIJKLMOPQRSTUVWXYZ';
        $id = strtoupper(substr($request->title, 0, 1) . 'JB-' . substr(rand(time(), 999), 0 , 6) .'-'. substr(str_shuffle($str), 0 , 2));

           $job = new Job;
           $job->id = $id;
           $job->title = $request->title;
           $job->company = Auth::guard()->user()->name;
           $job->company_logo = Auth::guard()->user()->avatar;
           $job->location = $request->location;
           $job->salary = $request->salary;
           $job->description = $request->description;
           $job->benefits = $request->benefits;
           $job->type = $request->type;
           $job->category = $request->category;
           $job->work_condition = $request->work_condition;
           $job->save();

           $job->users()->sync(Auth::guard()->user()->id);

           return response()->json(['status' => 'success', 'message' => 'Job successfully created'], 200);
    }

    public function user($user)
    {
        $this->users()->attach($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function show($job)
    {
        $job = Job::find($job);

        return response()->json(['data' => $job], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $job)
    {
        $rules = [
            'title' => 'required',
            'location' => 'required',
            'salary' => 'nullable',
            'description' => 'required',
            'benefits' => 'nullable',
            'category' => 'nullable',
            'type' => 'required',
            'work_condition' => 'required',
        ];

        $this->validate($request, $rules);

        $job = Job::find($job);
        $job->title = $request->title;
        $job->company = Auth::guard()->user()->name;
        $job->company_logo = Auth::guard()->user()->avatar;
        $job->location = $request->location;
        $job->salary = $request->salary;
        $job->description = $request->description;
        $job->benefits = $request->benefits;
        $job->type = $request->type;
        $job->category = $request->category;
        $job->work_condition = $request->work_condition;
        $job->save();

        return response()->json(['status' => 'success', 'message' => 'Job successfully updated.'], 200);
    }

    /**
     * @param Job $job_id
     * return Applicant Resource
     */
    public function applications($job_id)
    {
       $jobs = Applicant::where('job_id', $job_id)->paginate(20);

        $data = $jobs->items();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]->cv =  env('APP_URL') . Storage::disk('local')->url($data[$i]->cv);
        }

        $data = collect($data);
        $data->merge($jobs);

        return response()->json($jobs);
    }


    /**
     * @param Job $keyword
     * return Applicant Resource
     */
    public function search(Request $request)
    {
        $key = $request->get('q');

        $jobs = Job::where('title', 'LIKE', '%' . $key . '%')
                    ->orWhere('description', 'LIKE', '%' . $key . '%')
                    ->orWhere('company', 'LIKE', '%' . $key . '%')
                    ->orWhere('location', 'LIKE', '%' . $key . '%')
                    ->orWhere('benefits', 'LIKE', '%' . $key . '%')
                    ->orWhere('type', 'LIKE', '%' . $key . '%')
                    ->orWhere('category', 'LIKE', '%' . $key . '%')
                    ->orWhere('work_condition', 'LIKE', '%' . $key . '%')
                    ->orWhere('salary', 'LIKE', '%' . $key . '%')->get();

         return response()->json($jobs);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function destroy($job)
    {
        $job = Job::find($job)->delete();
        return response()->json(['status' => 'success', 'message' => 'Job successfully deleted'], 200);
    }
}
