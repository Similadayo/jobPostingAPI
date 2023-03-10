<?php

namespace App\Http\Controllers;

use App\Models\Jobs;
use Illuminate\Http\Request;

class JobController extends Controller
{

    public function index()
    {
        $jobs = Jobs::all();

        return response()->json(['data' => $jobs]);
    }

    // Get a specific job posting by ID
    public function show($id)
    {
        $job = Jobs::findOrFail($id);

        return response()->json(['data' => $job]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'location' => 'required|string',
            'salary' => 'nullable|integer',
            'type' => 'nullable|string',
            'category' => 'nullable|string',
            'company' => 'nullable|string',
        ]);

        $job = new Jobs([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'location' => $request->input('location'),
            'salary' => $request->input('salary'),
            'type' => $request->input('type'),
            'category' => $request->input('category'),
            'company' => $request->input('company'),
            'user_id' => auth()->id(),
        ]);

        $job->save();

        return response()->json([
            'message' => 'Job created successfully',
            'data' => $job,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'location' => 'required|string',
            'salary' => 'nullable|integer',
            'type' => 'nullable|string',
            'category' => 'nullable|string',
            'company' => 'nullable|string',
        ]);

        $job = Jobs::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        $job->title = $request->input('title');
        $job->description = $request->input('description');
        $job->location = $request->input('location');
        $job->salary = $request->input('salary');
        $job->type = $request->input('type');
        $job->category = $request->input('category');
        $job->company = $request->input('company');

        $job->save();

        return response()->json([
            'message' => 'Job updated successfully',
            'data' => $job,
        ], 200);
    }

    public function delete($id)
    {
        $job = Jobs::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        $job->delete();

        return response()->json([
            'message' => 'Job deleted successfully',
        ], 200);
    }
}
