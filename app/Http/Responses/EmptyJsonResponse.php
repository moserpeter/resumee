<?php

namespace App\Responses;

use Illuminate\Contracts\Support\Responsable;

class EmptyJsonResponse implements Responsable
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        return response()->json([], 204);
    }
}
