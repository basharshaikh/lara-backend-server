<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Role::all(['id', 'name']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request->user();
        if($user->can('Edit Role')){
            $valid = $request->validate([
                'name' => 'required|string|max:1000'
            ]);
            Role::create(['name' => $valid['name'], 'guard_name' => 'web']);
            return response("Role added!", 200);
        }
        return response('You don\'t have permission yet!', 403);
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
        $user = $request->user();
        if($user->can('Edit Role')){
            $valid = $request->validate([
                'name' => 'required|string|max:1000'
            ]);
            $data = [
                'name' => $valid['name'],
                'guard_name' => 'web'
            ];
            Role::find($id)->update($data);
    
            return response("Role Updated", 200);
        }
        return response('You don\'t have permission yet!', 403);
    }

    /**
     * Remove the the role from db
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $user = $request->user();
        if($user->can('Delete Role')){
            Role::find($id)->delete();
            return response("Role deleted successfully.", 200);
        }
        return response('You don\'t have permission yet!', 403);
    }
}
