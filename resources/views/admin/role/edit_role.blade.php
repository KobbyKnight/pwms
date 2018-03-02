@extends('layout.base')

@section('title')
    Edit Roles
@endsection

@push('stylesheet')
@endpush
@push('breadcramps')
    <ol class="breadcrumb">
        <li class=""><a href="{{route('role.index')}}">Roles</a></li>
    </ol>
@endpush
@section('contents')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="panel panel-default">
        <form action="{{route('role.update',$role->id)}}" method="post">
            {{csrf_field()}}
            <div class="panel-heading">
                <h2>Edit Role</h2>
                <div class="panel-ctrls" style="padding-top: 10px;" >

                </div>
            </div>
            <div class="panel-body">

                <div class="row">
                    <div class="form-group col-sm-4 ">
                        <label class="col-sm-12 control-label">Unique role name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" value="{{$role->name or old('name')}}" name="name" placeholder="Unique role name">
                        </div>
                    </div>
                    <div class="form-group col-sm-4 ">
                        <label class="col-sm-12 control-label">Display Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" value="{{$role->display_name or old('display_name')}}" name="display_name" placeholder="Display Name">
                        </div>
                    </div>
                    <div class="form-group col-sm-4 ">
                        <label class="col-sm-12 control-label">Description</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" value="{{$role->description or old('description')}}" name="description" placeholder="Description">
                        </div>
                    </div>
                    <div class="form-group col-sm-12 ">
                        <label class="col-sm-12 control-label">Permissions</label>
                        <div class="col-sm-12">
                            @foreach($permissions->chunk(5) as $permission)
                                <div class="col-sm-4">
                                    @foreach($permission as $permissions)
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <input type="checkbox" {{in_array($permissions->id,$role_perms)?"checked":""}} class="form-control" value="{{$permissions->id}}"
                                                       name="permissions[]">
                                            </div>
                                            <div class="col-sm-9">
                                                {{$permissions->display_name}}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <div class="form-group col-sm-12 text-center">
                    <input type="submit" class="btn btn-default" name="" id="" value="Submit">
                    <a href="{{route('role.index')}}"  class="btn btn-orange" name="" id="" ><i class="ti ti-back-left"></i>Back</a>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')


@endpush