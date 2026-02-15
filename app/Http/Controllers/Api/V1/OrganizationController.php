<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use App\Models\Organization;
use App\Http\Requests\StoreOrganizationRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class OrganizationController extends Controller
{
    use ApiResponse;

    public function store(StoreOrganizationRequest $request)
    {
        $organization = Organization::create([
            'name' => $request->name,
            'owner_id' => auth()->id(),
        ]);

        $organization->users()->attach(auth()->id(), [
            'role' => 'owner']);

        return $this->success([
            'organization' => $organization
        ], 'Organization Created');
    }

    public function index()
    {
        $organizations = auth()->user()->organization()->get();

        return response()->json($organizations);
    }
}
