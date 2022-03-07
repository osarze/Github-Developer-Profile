<?php

namespace App\Http\Controllers;

use App\Events\Developers\NewDeveloperAddedEvent;
use App\Http\Requests\Developers\StoreDeveloperRequest;
use App\Http\Resources\Developers\DevelopersCollection;
use App\Models\Developer;
use App\Services\DeveloperGithubProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DeveloperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $developers = new DevelopersCollection(Developer::paginate());

        return $this->resourceSuccessResponse($developers, trans('message.success.get', ['resource' => 'Developers']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Developers\StoreDeveloperRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreDeveloperRequest $request)
    {
        try {
            $developer = DeveloperGithubProfileService::saveOrUpdateDeveloperDetails($request->username);

            return $this->successResponse($developer->toArray(), trans('message.success.new', ['resource' => 'Developer']));
        } catch (\Exception $e) {
            Log::error($e);
        }

        return $this->errorResponse(null, $e->getMessage());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Developer  $developer
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Developer $developer)
    {
        try {
            $developer = DeveloperGithubProfileService::saveOrUpdateDeveloperDetails($developer->username);
            return $this->successResponse($developer->toArray(), trans('message.success.update', ['resource' => 'Developer']));
        } catch (\Exception $e) {
            Log::error($e);
        }

        return $this->errorResponse(null, $e->getMessage());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Developer  $developer
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Developer $developer)
    {
        $developer->delete();

        return $this->successResponse(null, trans('message.success.delete', ['resource' => 'Developer']));
    }
}
