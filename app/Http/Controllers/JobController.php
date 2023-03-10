<?php

namespace App\Http\Controllers;

use App\Models\Jobs;
use Illuminate\Http\Request;

class JobController extends Controller
{
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
}
