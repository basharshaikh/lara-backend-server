<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rules\Password;

class UserManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all(['id', 'name', 'email']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|string|unique:users,email',
            'password' => [
                'required',
                'confirmed',
                Password::min(6)
            ]
        ]);

        $user = $request->user();
        if($user->can('Edit User')){
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password'])
            ]);
            return response("User added!", 200);
        }
        return response('You don\'t have permission yet!', 403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|string',
            'password' => [
                'required',
                'confirmed',
                Password::min(6)
            ]
        ]);

        $user = $request->user();
        if($user->can('Edit User')){
            User::find($id)->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password'])
            ]);
    
            return response("User Updated!", 200);
        }
        return response('You don\'t have permission yet!', 403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $user = $request->user();
        if($user->can('Delete User')){
            User::find($id)->delete();
            return response('User Deleted', 200);
        }
        return response('You don\'t have permission yet!', 403);
    }


    // Assign caps in role
    public function AssignCapsInRole(Request $request)
    {
        $user = $request->user();
        if($user->hasRole('Super-Admin')){
            $valid = $request->validate([
                'roleID' => 'required|integer',
                'caps' => 'nullable|array'
            ]);

            $data = [
                'roleID' => $valid['roleID'],
                'caps' => $valid['caps']
            ];

            $role = Role::find($data['roleID']);
            // remove all permission from role 
            $old_perms = $role->permissions()->get(['id', 'name']);
            $perms = [];
            foreach($old_perms as $perm){
                $perms[] = $perm->name;
            }
            $role->revokePermissionTo($perms);


            // and then assign new permissons are again
            $caps = [];
            foreach($data['caps'] as $cap){
                $caps[] = $cap['name'];
            }

            $role->givePermissionTo($caps);
            
            return response("Parmissions are assigned!", 200);
        }
        return response('You don\'t have permission', 403);
    }

    // Get permissions from role
    public function PermissionsFromRole(Request $request){
        $user = $request->user();
        $valid = $request->validate([
            'roleID' => 'required|integer',
        ]);
        $data = [
            'roleID' => $valid['roleID']
        ];

        $role = Role::find($data['roleID']);
        return $role->permissions()->get(['id', 'name']);
    }

    // Assign role on user
    public function AssignRoleOnUser(Request $request){
        $user = $request->user();
        if($user->hasRole('Super-Admin')){
            $valid = $request->validate([
                'userID' => 'required|integer',
                'roles' => 'nullable|array'
            ]);

            $data = [
                'userID' => $valid['userID'],
                'roles' => $valid['roles']
            ];

            $targetUser = User::find($data['userID']);

            // Remove old roles
            $roles = $targetUser->getRoleNames();
            foreach($roles as $role){
                $targetUser->removeRole($role);
            }

            // then assign all roles
            foreach($data['roles'] as $role){
                $targetUser->assignRole($role['name']);
            }
            
            return response("Roles are assigned!", 200);
        }
        return response('You don\'t have permission', 403);
    }

    // Roles from user
    public function RolesFromUser(Request $request){
        
        $valid = $request->validate([
            'userID' => 'required|integer',
        ]);
        $data = [
            'userID' => $valid['userID']
        ];

        $targetUser = User::find($data['userID']);
        return $targetUser->roles()->get(['id', 'name']);
    }

    // get current user data
    public function CurrentUserData(Request $request){
        $user = $request->user();
        $roles = $user->roles()->get(['id', 'name']);

        $userCaps = [];
        $userRoles = [];
        foreach($roles as $role){
            $userRoles[] = $role->name;

            $role = Role::find($role['id']);
            $permissions = $role->permissions()->get(['id', 'name']);
            foreach($permissions as $perm){
                $userCaps[] = $perm->name;
            }
        }
        return [
            "user" => [
                "data" => $user,
                "roles" => $userRoles,
                "capable" => $userCaps,
            ]
        ];
    }

    // Get total user count
    public function TotalUserCount(){
        return User::all()->count();
    }
}
