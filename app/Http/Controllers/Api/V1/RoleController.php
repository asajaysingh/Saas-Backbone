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
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{   
    // List all roles for the authenticated user's organization   
    public function index(Request $request, $organizationId)
    {
        
     
        $roles =Role::where('organization_id', $organizationId)->get();
        return $this->success($roles);
    }

    // Create a new role
    public function store(Request $request, $organizationId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:roles,slug',
            ]); 
            //return response()->json(['organization_id' => $organizationId]);
        $role = Role::create([
            'organization_id' => $organizationId,
            'name' => $request->name,
            'slug' => strtolower($request->slug),
        ]);
        return response()->json([
            'message' => 'Role created successfully',
             'role' => $role],
              201);
    }

    //update a role     
    public function update(Request $request, $id)
    {
        $role = Role::where('id', $id)->where('organization_id', auth()->user()->organization_id)->firstOrFail();
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:roles,slug,' . $role->id,
        ]);
        $role->update([
            'name' => $request->name,
            'slug' => strtolower($request->slug),
        ]);
        return response()->json([
            'message' => 'Role updated successfully',
             'role' => $role],
              200);
    }

    // delete a role
    public function destroy($id)
    {
        $role = Role::where('id', $id)->where('organization_id', auth()->user()->organization_id)->firstOrFail();
        $role->delete();
        return response()->json([
            'message' => 'Role deleted successfully',
             'role' => $role],
              200);
    }

}