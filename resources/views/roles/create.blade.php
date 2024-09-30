@extends('layouts.app')
@inject('model', 'Spatie\Permission\Models\Role')
@inject('permissions', 'Spatie\Permission\Models\Permission')
@section('page_title')
    اضافة رتبة
@endsection


@section('content')
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">اضافة رتبة جديدة</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                        title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif
                <br>
                <br>
                <form action="{{ route('roles.store') }}" method="POST" id="role-form" class="form-horizontal">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">الرتبة</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" placeholder="ادخل الرتبة">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="permission_list" class="col-sm-2 control-label">الصلاحيات</label>
                        <div class="row">
                            @foreach ($permissions->all() as $permission)
                                <div class="col-sm-3">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="permission_list[]"
                                                value="{{ $permission->id }}">{{ $permission->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @error('permission_list')
                            <span class="invalid-feedback" role="alert">
                                <strong class="text-danger">{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" class="btn btn-primary" id="submit-btn" value="اضافة">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
