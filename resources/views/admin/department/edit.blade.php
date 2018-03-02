@extends('layout.base')

@section('title')
    Add Department
@endsection

@push('stylesheet')
@endpush
@push('breadcramps')
    <ol class="breadcrumb">
        <li class=""><a href="{{route('department.index')}}">Department</a></li>
        <li class="active"><a href="{{route('department.create')}}">New Department</a></li>
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
        <form action="{{route('department.update',$department->id)}}" method="post">
            {{csrf_field()}}
            <div class="panel-heading">
                <h2>New Department</h2>
                <div class="panel-ctrls" style="padding-top: 10px;">

                </div>
            </div>
            <div class="panel-body">

                <div class="row">
                    <div class="form-group col-sm-4 ">
                        <label class="col-sm-12 control-label">name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" value="{{$department->acronym or old('acronym')}}" name="acronym"
                                   placeholder="Unique role name">
                        </div>
                    </div>

                    <div class="form-group col-sm-4 ">
                        <label class="col-sm-12 control-label">Description</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" value="{{$department->description or old('description')}}" name="description"
                                   placeholder="Description">
                        </div>
                    </div>


                </div>
            </div>
            <div class="panel-footer">
                <div class="form-group col-sm-12 text-center">
                    <input type="submit" class="btn btn-default" name="" id="" value="Submit">
                    <a href="{{route('department.index')}}" class="btn btn-orange" name="" id=""><i
                                class="ti ti-back-left"></i>Back</a>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')


@endpush