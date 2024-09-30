@extends('layouts.app')
@inject('permissions', 'Spatie\Permission\Models\Permission')
@section('page_title')
    تعديل الرتبة
@endsection


@section('content')
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
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
                <form action="{{ route('roles.update', $model->id) }}" method="POST" id="governorate-form">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">الرتبة</label>
                        <input type="text" name="name" value="{{ $model->name }}" class="form-control">
                        @error('name')
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="permission_list" class="col-sm-2 control-label">الصلاحيات</label>
                        <div class="row">
                            @foreach ($permissions->all() as $permission)
                                <div class="col-sm-3">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="permission_list[]"
                                                value="{{ $permission->id }}"
                                                {{ $model->permissions->contains($permission) ? 'checked' : '' }}>
                                                >
                                                {{ $permission->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" id="submit-btn">
                        </div>
                </form>
            </div>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
