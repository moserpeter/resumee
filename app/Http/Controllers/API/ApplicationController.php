<?php

namespace App\Http\Controllers\API;

use App\Application;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Responses\EmptyJsonResponse;
use App\Http\Middleware\AddUserToRequest;
use App\Http\Resources\ApplicationResource;

class ApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware(AddUserToRequest::class)->only(['store']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ApplicationResource::collection(auth()->user()->applications);
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
            'user_id' => 'required|integer|min:0',
            'company_id' => 'nullable|integer|min:0'
        ]);

        $application = new Application($data);
        $application->save();

        return new ApplicationResource($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function show(Application $application)
    {
        return new ApplicationResource($application);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Application $application)
    {
        $data = $this->validate($request, [
            'send_at' => 'nullable',
            'company_id' => 'nullable|integer|min:0'
        ]);

        $application->update($data);

        return new ApplicationResource($application);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function destroy(Application $application)
    {
        $application->delete();

        return response()->json([], 204);
    }

    /**
     * send and application per mail 
     * 
     * @param  Application $application 
     * @return \App\Resources\ApplicationRessource                   
     */
    public function send(Application $application)
    {
        $application->send();

        return new ApplicationResource($application);
    }
}
