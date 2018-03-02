@extends('layout.base')

@section('title')
    Add Permission
@endsection

@push('stylesheet')
@endpush
@push('breadcramps')
    <ol class="breadcrumb">
        <li class=""><a href="{{route('permission.index')}}">Permission</a></li>
        <li class="active"><a href="{{route('permission.create')}}">New Permission</a></li>
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
        <form action="{{route('permission.store')}}" method="post">
            {{csrf_field()}}
            <div class="panel-heading">
                <h2>New Permission</h2>
                <div class="panel-ctrls" style="padding-top: 10px;">

                </div>
            </div>
            <div class="panel-body">

                <div class="row">
                    <div class="form-group col-sm-4 ">
                        <label class="col-sm-12 control-label">Unique permission name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" value="{{old('name')}}" name="name"
                                   placeholder="Unique role name">
                        </div>
                    </div>
                    <div class="form-group col-sm-4 ">
                        <label class="col-sm-12 control-label">Display Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" value="{{old('display_name')}}" name="display_name"
                                   placeholder="Display Name">
                        </div>
                    </div>
                    <div class="form-group col-sm-4 ">
                        <label class="col-sm-12 control-label">Description</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" value="{{old('description')}}" name="description"
                                   placeholder="Description">
                        </div>
                    </div>

                </div>
            </div>
            <div class="panel-footer">
                <div class="form-group col-sm-12 text-center">
                    <input type="submit" class="btn btn-default" name="" id="" value="Submit">
                    <a href="{{route('permission.index')}}" class="btn btn-orange" name="" id=""><i
                                class="ti ti-back-left"></i>Back</a>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')


@endpush