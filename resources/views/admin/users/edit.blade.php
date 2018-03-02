@extends('layout.base')

@section('title')
    Edit Users
@endsection

@push('stylesheet')
@endpush
@push('breadcramps')
    <ol class="breadcrumb">
        <li class=""><a href="{{route('users.index')}}">Users</a></li>

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
        <form action="{{route('users.update',$users->id)}}" method="post">
            {{csrf_field()}}
            <div class="panel-heading">
                <h2>Edit User</h2>
                <div class="panel-ctrls" style="padding-top: 10px;">

                </div>
            </div>
            <div class="panel-body">

                <div class="row">
                    <div class="form-group col-sm-4 ">
                        <label class="col-sm-12 control-label">Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" value="{{$users->name or old('name')}}" name="name"
                                   placeholder="">
                        </div>
                    </div>
                    <div class="form-group col-sm-4 ">
                        <label class="col-sm-12 control-label">Gender</label>
                        <div class="col-sm-12">
                            <select name="gender" class="form-control" id="">
                                <option value="">-- Status --</option>
                                @if(!empty(old('gender')))
                                    @if(old('gender')=="Male")
                                        <option value="Male" selected>Male</option>
                                        <option value="Female" >Female</option>
                                    @elseif(old('gender')=="Female")
                                        <option value="Male" >Male</option>
                                        <option value="Female" selected>Female</option>
                                    @endif
                                @else
                                    @if(!empty($users))
                                    @if($users->gender=="Male")
                                    <option value="Male" selected>Male</option>
                                    <option value="Female" >Female</option>
                                    @elseif($users->gender=="Female")
                                    <option value="Male" >Male</option>
                                    <option value="Female" selected>Female</option>
                                    @endif
                                    @else
                                    <option value="Male" >Male</option>
                                    <option value="Female">Female</option>
                                    @endif
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-sm-4 ">
                        <label class="col-sm-12 control-label">Date of Birth</label>
                        <div class="col-sm-12">
                            <input type="date" class="form-control" value="{{$users->dob or old('dob')}}" name="dob"
                                   placeholder="">
                        </div>
                    </div>
                    <div class="form-group col-sm-4 ">
                        <label class="col-sm-12 control-label">Username</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" value="{{$users->username or old('username')}}" name="username"
                                   placeholder="">
                        </div>
                    </div>
                    <div class="form-group  col-sm-4 ">
                        <label class="col-sm-12 control-label">Password</label>
                        <div class=" col-sm-12">
                            <input type="password" class="form-control" value="" name="password" placeholder="">
                        </div>
                    </div>
                    <div class="form-group  col-sm-4 ">
                        <label class="col-sm-12 control-label">Confirm Password</label>
                        <div class=" col-sm-12">
                            <input type="password" class="form-control" value="" name="password_confirmation" placeholder="">
                        </div>
                    </div>
                    <div class="form-group col-sm-4 ">
                        <label class="col-sm-12 control-label">Email</label>
                        <div class="col-sm-12">
                            <input type="email" class="form-control" value="{{$users->email or old('email')}}" name="email"
                                   placeholder="">
                        </div>
                    </div>
                    <div class="form-group col-sm-4 ">
                        <label class="col-sm-12 control-label">Phone</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" value="{{$users->official_phone or old('official_phone')}}" name="official_phone"
                                   placeholder="">
                        </div>
                    </div>

                    <div class="form-group col-sm-4 ">
                        <label class="col-sm-12 control-label">Department</label>
                        <div class="col-sm-12">
                            <select name="department_id" class="form-control" id="">
                                <option value="">-- Select --</option>
                                @foreach($department as $item)
                                    @if(!empty(old('department_id')))
                                        @if(old('department_id')==$item->id)
                                            <option value="{{$item->id}}" selected>{{$item->description}}</option>
                                        @else
                                            <option value="{{$item->id}}">{{$item->description}}</option>
                                        @endif
                                    @else
                                        @if(!empty($users))
                                            @if($users->department_id==$item->id)
                                                <option value="{{$item->id}}" selected>{{$item->description}}</option>
                                            @else
                                                <option value="{{$item->id}}">{{$item->description}}</option>
                                            @endif
                                        @else
                                            <option value="{{$item->id}}">{{$item->description}}</option>
                                        @endif
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-sm-4 ">
                        <label class="col-sm-12 control-label">Role</label>
                        <div class="col-sm-12">
                            <select name="role" class="form-control" id="">
                                <option value="">-- Select --</option>
                                @foreach($role as $item)
                                    @if(!empty(old('role')))
                                        @if(old('role')==$item->id)
                                            <option value="{{$item->id}}" selected>{{$item->name}}</option>
                                        @else
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endif
                                    @else

                                        @if(!empty($users->roles->first()->id))
                                            @if($users->roles->first()->id==$item->id)
                                                <option value="{{$item->id}}" selected>{{$item->name}}</option>
                                            @else
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endif
                                        @else
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endif

                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>
            </div>
            <div class="panel-footer">
                <div class="form-group col-sm-12 text-center">
                    <input type="submit" class="btn btn-default" name="" id="" value="Submit">
                    <a href="{{route('users.index')}}" class="btn btn-orange" name="" id=""><i
                                class="ti ti-back-left"></i>Back</a>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')


@endpush