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


class OrganizationController extends Controller
{
    use ApiResponse;

    public function store(StoreOrganizationRequest $request)
    {
       
        DB::beginTransaction();

        try {

            // create organization
            $organization = Organization::create([
                'name' => $request->name,
                'owner_id' => auth()->id(),
            ]);
    
            // attach user to organization with owner role
            $organization->users()->attach(auth()->id());

           // $adminRole = Role::where('organization_id', $organization->id)->where('slug', 'admin')->first();
            $adminRole = new Role();
            $adminRole->organization_id = $organization->id;
            $adminRole->name = 'Admin';
            $adminRole->slug = 'admin';
            $adminRole->save();
            // create default roles and permissions for the organization
            // $adminRole = Role::create([
            //     'organization_id' => $organization->id,
            //     'name' => 'Admin',
            //     'slug' => 'admin',
            // ]);
    
            // Role::create([
            //     'organization_id' => $organization->id,
            //     'name' => 'Member',
            //     'slug' => 'member',
            // ]);
    
            // Role::create([
            //     'organization_id' => $organization->id,
            //     'name' => 'User',
            //     'slug' => 'user',
            // ]);
    
            // Assign Admin role to the owner
            // if($adminRole) {
            //     auth()->user()->roles()->attach($adminRole->id);
            // }

            // $allPermisiions = Permission::pluck('id');
            // $adminRole->permissions()->sync($allPermisiions);
            DB::commit();
    
            return $this->success([
                'organization' => $organization
            ], 'Organization Created');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), 'Organization Creation Failed', 500);
        }
    }

    public function index()
    {
        $organizations = auth()->user()->organization()->get();

        return response()->json($organizations);
    }
}
