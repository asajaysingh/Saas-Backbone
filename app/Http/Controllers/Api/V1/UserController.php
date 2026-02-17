<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // Validate and create user logic here
            $authUser = auth()->user();
            //assume first organization for now
            $organization = $authUser->organizations()->first();
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            //attach to organization
            $organization->users()->attach($user->id);

             // Assign default role to the user
             $defaultRole = Role::where('organization_id', $organization->id)
             ->where('slug', 'user')->first();
             if($defaultRole) {
                $user->roles()->attach($defaultRole->id);
             }
            DB::commit();

            return $this->success([
                'user' => $user
            ], 'User Created');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error('Something went wrong', 500, $e->getMessage());
        }
    }
}
