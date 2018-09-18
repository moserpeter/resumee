<?php

namespace App\Http\Controllers\API;

use App\Job;
use Illuminate\Http\Request;
use App\Http\Resources\JobResource;
use App\Http\Controllers\Controller;
use App\Responses\EmptyJsonResponse;
use App\Http\Middleware\AddUserToRequest;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return JobResource::collection(auth()->user()->jobs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'company_id' => 'required|integer|min:0',
            'title' => 'required|string|min:3|max:255',
            'description' => 'nullable|string'
        ]);

        $job = new Job($data);
        $job->save();

        return new JobResource($job);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function show(Job $job)
    {
        return new JobResource($job);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Job $job)
    {
        $data = $this->validate($request, [
            'user_id' => 'integer|min:0',
            'company_id' => 'integer|min:0',
            'title' => 'string|min:3|max:255',
            'description' => 'nullable|string'
        ]);

        $job->update($data);

        return new JobResource($job);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job)
    {
        $job->delete();

        return new EmptyJsonResponse();
    }
}
