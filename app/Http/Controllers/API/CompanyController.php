<?php

namespace App\Http\Controllers\API;

use App\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Responses\EmptyJsonResponse;
use App\Http\Resources\CompanyResource;
use App\Http\Middleware\AddUserToRequest;

class CompanyController extends Controller
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
        $copmanies = auth()->user()->companies;

        return CompanyResource::collection($copmanies);
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
            'name' => 'required|string|min:3|max:255',
            'user_id' => 'required|integer|min:0'
        ]);

        $company = new Company($data);
        $company->save();

        return new CompanyResource($company);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        return new CompanyResource($company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $data = $this->validate($request, [
            'name' => 'string|min:5|max:255',
            'user_id' => 'integer|min:0',
        ]);

        $company->update($data);

        return new CompanyResource($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $company->delete();

        return new EmptyJsonResponse;
    }
}
