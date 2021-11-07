<?php

namespace App\Http\Controllers;

use App\Models\Selectoption\Workcondition;
use Illuminate\Http\Request;

class WorkconditionController extends Controller
{
    public function index()
    {
        $workcondition = Workcondition::all();

        return response()->json(['data' => $workcondition]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required'
        ]);

        Workcondition::create($request->all());

        return response()->json(['status' => 'success', 'message' => 'Work Condition Successfully Created']);
    }

    public function show(Workcondition $workcondition)
    {
        return response()->json(['data' => $workcondition]);
    }


    public function update(Workcondition $workcondition, Request $request)
    {
        $request->validate(['type' => 'required']);

        $workcondition->update($request->all());
        return response()->json(['status' => 'success', 'message' => 'Work Condition Successfully Updated']);
    }

    public function destroy(Workcondition $workcondition)
    {
        $workcondition->delete();
        return response()->json(['status' => 'success', 'message' => 'Work Condition Successfully Deleted']);
    }
}
