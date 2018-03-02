<?php

namespace App\Http\Controllers;

use App\AuditTrails;
use App\Branch;
use App\Department;
use App\Hospital;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{

    //
    public function index()
    {
        return view('admin.users.show');
    }
    public function indexsupervisor()
    {
        return view('admin.users.supervisor.show');
    }
    public function indexstudent()
    {
        return view('admin.users.student.show');
    }

    public function create()
    {

//        $brunch=Branch::all();

        $users=auth()->user();
        if ($users->hasRole('developer')){

            $role=Role::all();
            $department=Department::all();
        }else{

            $role=Role::all()->where('name','!=','developer');
            $department=Department::all();
        }
        return view('admin.users.add',compact('hospital','role','department'));
    }

    public function store(Request $request)
    {
        $users=auth()->user();
        if ($users->hasRole('developer')) {
            $this->validate($request, [
                'name' => 'required',
                'gender' => 'required',
                'dob' => 'required',
                'username' => 'required|unique:users',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed',
                'official_phone' => 'required',
                'department_id' => 'sometimes',
                'role' => 'required',
            ]);
        }else{
            $this->validate($request, [
                'name' => 'required',
                'gender' => 'required',
                'dob' => 'required',
                'username' => 'required|unique:users',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed',
                'official_phone' => 'required',
                'department_id' => 'required',
                'role' => 'required',
            ]);
        }
        $user = User::create([
            'name'=>$request->input('name'),
            'password'=>bcrypt($request->input('password')),
            'username'=>$request->input('username'),
            'email'=>$request->input('email'),
            'gender'=>$request->input('gender'),
            'dob'=>$request->input('dob'),
            'official_phone'=>$request->input('official_phone'),
            'department_id'=>$request->input('department_id'),
//
            'created_by'=>auth()->user()->username
        ]);
$user->attachRole($request->input('role'));
        $msg=\auth()->user()->username.' Added a User to the system with name'.$user->name;

        session()->flash('pine-msg',['pine_title'=>'Created','pine_body'=>'You have successfully added User','pine_type'=>'success','pine_icon'=>'ti ti-check']);
        AuditTrails::create([
            'user_id'=>\auth()->id(),'date_made'=>date(now()),'activity'=>$msg
        ]);
        return redirect()->route('users.create');
    }

    public function edit(User $users)
    {
        $user=auth()->user();
        if ($user->hasRole('developer')){

            $role=Role::all();
            $department=Department::all();
        }else{

            $role=Role::all()->where('name','!=','developer');
            $department=Department::all();
        };

        return view('admin.users.edit', compact('users','hospital','role','department'));
    }

    public function update(Request $request, User $user)
    {
        $users=auth()->user();

        if ($users->hasRole('developer')) {
            $this->validate($request, [
                'name' => 'required',
                'gender' => 'required',
                'dob' => 'required',
                'username' => 'required|unique:users',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed',
                'official_phone' => 'required',
                'department_id' => 'sometimes',
                'role' => 'required',
            ]);
        }else{
            $this->validate($request, [
                'name' => 'required',
                'gender' => 'required',
                'dob' => 'required',
                'username' => 'required|unique:users',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed',
                'official_phone' => 'required',
                'department_id' => 'required',
                'role' => 'required',
            ]);
        }

        $user->name = $request->input('name');
        $user->username =$request->input('username');
        $user->gender =$request->input('gender');
        $user->dob =$request->input('dob');
        $user->email = $request->input('email');
        $user->official_phone = $request->input('official_phone');

        $user->department_id = $request->input('department_id');
//        $users->pharmacy_id = $request->input('pharmacy');
        if (!empty($request->input('password'))){
            $user->password =  bcrypt($request->input('password'));
        }
//        dd($request->input('role'));
        $user->roles()->sync($request->input('role'));

        $msg=\auth()->user()->username.' Updated a User in the system with name'.$user->name;
        $user->save();
        session()->flash('pine-msg',['pine_title'=>'Updated','pine_body'=>'You have successfully Updated a User','pine_type'=>'warning','pine_icon'=>'ti ti-check']);
        AuditTrails::create([
            'user_id'=>\auth()->id(),'date_made'=>date(now()),'activity'=>$msg
        ]);
        return redirect()->route('users.edit', $user->id);
    }

    public function delete(User $user)
    {
        $msg=\auth()->user()->username.' Deleted a User in the system with name'.$user->name;

        session()->flash('pine-msg',['pine_title'=>'Deleted','pine_body'=>'You have successfully Deleted a User','pine_type'=>'danger','pine_icon'=>'ti ti-check']);
        AuditTrails::create([
            'user_id'=>\auth()->id(),'date_made'=>date(now()),'activity'=>$msg
        ]);
        $user->delete();
        return redirect()->route('users.index');

    }

    public function show()
    {
        $user=auth()->user();
        if ($user->hasRole('developer')){
            $users = User::all();
        }else{
            $users = User::all();
        }

        return DataTables::of($users)->addColumn('action', function ($data) {
            return '<a href="' . route('users.edit', $data->id) . '" class="btn btn-info btn-sm"><i class="ti ti-pencil"></i></a> ' .
                '<a href="' . route('users.delete', $data->id) . '" class="btn btn-danger btn-sm"><i class="ti ti-trash"></i></a>';
        })->editColumn('is_locked',function($data){
            if ($data->is_locked){
                return '<span class="label label-danger"><i class="ti ti-lock"></i> </span>';
            }else{
                return '<span class="label label-success"><i class="ti ti-unlock"></i></span>';
            }
        })->editColumn('is_login',function($data){
            if ($data->is_login){
                return '<span class="label label-success">on </span>';
            }else{
                return '<span class="label label-danger">off</span>';
            }
        })->editColumn('department_id',function($data){
            if (!empty($data->department)){
                return $data->department->description;
            }else{
                return "Null";
            }
        })->rawColumns(['action','is_locked','is_login','on_shift','hospital_id','department_id'])->toJson();
    }
}
