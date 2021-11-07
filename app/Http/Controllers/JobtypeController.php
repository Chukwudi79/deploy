<?php

namespace App\Http\Controllers;

use App\Models\Selectoption\Jobtype;
use Illuminate\Http\Request;

class JobtypeController extends Controller
{
    public function index()
    {
        $jobtype = Jobtype::all();

        return response()->json(['data' => $jobtype]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required'
        ]);

        Jobtype::create($request->all());

        return response()->json(['status' => 'success', 'message' => 'Jobtype Successfully Created']);
    }

    public function show(Jobtype $jobtype)
    {
        return response()->json(['data' => $jobtype]);
    }


    public function update(Jobtype $jobtype, Request $request)
    {
        $request->validate(['type' => 'required']);

        $jobtype->update($request->all());
        return response()->json(['status' => 'success', 'message' => 'Jobtype Successfully Updated']);
    }

    public function destroy(Jobtype $jobtype)
    {
        $jobtype->delete();
        return response()->json(['status' => 'success', 'message' => 'Jobtype Successfully Deleted']);
    }
}
