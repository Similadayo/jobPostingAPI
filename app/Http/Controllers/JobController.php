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

    public function search(Request $request)
    {
        $jobs = Jobs::query();

        if ($request->has('title')) {
            $jobs->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->has('location')) {
            $jobs->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->has('company')) {
            $jobs->where('company', 'like', '%' . $request->company . '%');
        }

        $jobs = $jobs->get();

        return response()->json([
            'jobs' => $jobs
        ]);
    }

    public function filterJobs(Request $request)
    {
        $query = Jobs::where('is_active', true);
    
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }
    
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }
    
        if ($request->has('salary')) {
            $salary = $request->salary;
            $query->where(function ($q) use ($salary) {
                $q->where('salary', '>=', $salary)
                    ->orWhereNull('salary');
            });
        }
    
        $jobs = $query->get();
    
        return response()->json($jobs);
    }
    
    
}