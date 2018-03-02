<?php

namespace App\Http\Controllers;

use App\AuditTrails;
use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.role.role');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $users=auth()->user();
        if ($users->hasRole('developer')){
            $permissions = Permission::all();
        }else{
            $permissions = Permission::all()->where('restriction',0);
        }

        return view('admin.role.add_role', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $role = Role::create($request->except(['permissions', '_token']));
        if (!empty($request->permissions)){
            foreach ($request->permissions as $key => $value) {
                $role->attachPermission($value);

            }
        }

        return redirect()->route('role.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
        $user=auth()->user();
        if ($user->hasRole('developer')){
            $roles = Role::all();
        }else{
            $roles = Role::all()->where('name','!=','developer');
        }

        return DataTables::of($roles)->addColumn('action', function ($data) {
            return '<a href="' . route('role.edit', $data->id) . '" class="btn btn-info btn-sm"><i class="ti ti-pencil"></i></a> ' .
                '<a href="' . route('role.delete', $data->id) . '" class="btn btn-danger btn-sm"><i class="ti ti-trash"></i></a>';
        })->toJson();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
        $users=auth()->user();
        if ($users->hasRole('developer')){
            $permissions = Permission::all();
        }else{
            $permissions = Permission::all()->where('restriction',0);
        }

        $role_perms = $role->perms()->pluck('id', 'id')->toArray();
        return view('admin.role.edit_role', compact('role', 'permissions', 'role_perms'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        //
        $users=auth()->user();
        if ($users->hasRole('developer')){
            $role->name = $request->name;
        }

        $role->display_name = $request->display_name;
        $role->description = $request->description;
        $role->save();
        if (!empty($request->permissions)){
            DB::table('permission_role')->where('role_id', $role->id)->delete();
            foreach ($request->permissions as $key => $value) {
                $role->attachPermission($value);

            }
        }

        return redirect()->route('role.edit',  $role->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //

        $msg=\auth()->user()->username.' Deleted a Hospital in the system with name'.$role->display_name;
        $role->delete();

        session()->flash('pine-msg',['pine_title'=>'DELETED','pine_body'=>'You have successfully deleted Role','pine_type'=>'danger','pine_icon'=>'ti ti-check']);
        AuditTrails::create([
            'user_id'=>\auth()->id(),'date_made'=>date(now()),'activity'=>$msg
        ]);
        return redirect()->route('role.index');
    }
}
