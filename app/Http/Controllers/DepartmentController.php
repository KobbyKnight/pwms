<?php

namespace App\Http\Controllers;

use App\Department;
use App\Hospital;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.department.show');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.department.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'acronym' => 'required|unique:departments',
            'description' => 'required'
        ]);
        $users=auth()->user();
        $department=Department::create($request->except('_token'));


        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Department $department
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = auth()->user();
        if ($user->hasRole('developer')) {
            $department = Department::all();
        } else {
            $department = Department::all()->where('hospital_id', $user->hospital->id);

        }
        return DataTables::of($department)->addColumn('action', function ($data) {

            return '<a href="' . route('department.edit', $data->id) . '" title="edit details of department" class="btn btn-info btn-sm"><i class="ti ti-pencil"></i></a> ' .
                '<a href="' . route('department.delete', $data->id) . '" title="Delete department" class="btn btn-danger btn-sm"><i class="ti ti-trash"></i></a>';

        })->toJson();

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Department $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {

        //
        return view('admin.department.edit',compact('department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Department $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        $this->validate($request, [
            'acronym' => 'required',
            'description' => 'required'
        ]);
        $users = auth()->user();
        $department->acronym = $request->input('acronym');
        $department->description = $request->input('description');

        $department->save();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        //
        $department->delete();
        return redirect()->back();
    }
}
