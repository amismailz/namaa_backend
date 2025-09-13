<?php

namespace App\Http\Controllers\API\V1;

use App\Enums\RoleTypeEnum;
use App\Http\Requests\API\MovementRequest;
use App\Services\API\HostingPlanService;
use App\Services\API\MovementService;
use App\Services\API\RangeService;
use App\Services\API\TripService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HostingPlans;
use App\Services\API\HomeService;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;


class HostingPlanController extends Controller
{
    use ResponseTrait;

    protected HostingPlanService $hostingPlanService;

    public function __construct(HostingPlanService $hostingPlanService)
    {
        $this->hostingPlanService = $hostingPlanService;
    }
        public function getAllHostingPlans()
    {
        return $this->hostingPlanService->getAllHostingPlans();
    }
    /**
     * Display a listing of the resource.
     */
    public function index() {}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MovementRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        return $this->tripService->getTripBySlug($slug);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
