@extends('layouts.app')
@inject('model', 'App\Models\User')
@inject('role', 'Spatie\Permission\Models\Role')
<?php $roles = $role->pluck('name', 'id')->toArray(); ?>
@section('page_title')
    انشاء مستخدم
@endsection


@section('content')
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">اضف مستخدم جديد </h3>
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
                <form action="{{ route('user.store') }}" method="POST" id="user-form" multiple="multiple">
                    @csrf
                    <div class="form-group">
                        <label for="name">الاسم</label>
                        <input type="text" class="form-control btn-margin @error('name') is-invalid @enderror"
                            id="name" name="name">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong class="text-danger">{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">البريد الالكتروني</label>
                        <input type="email" class="form-control btn-margin @error('email') is-invalid @enderror"
                            id="email" name="email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong class="text-danger">{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">كلمة المرور</label>
                        <input type="password" class="form-control btn-margin @error('password') is-invalid @enderror"
                            id="password" name="password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong class="text-danger">{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">تأكيد كلمة المرور</label>
                        <input type="password"
                            class="form-control btn-margin @error('password_confirmation') is-invalid @enderror"
                            id="password_confirmation" name="password_confirmation">
                        @error('password_confirmation')
                            <span class="invalid-feedback" role="alert">
                                <strong class="text-danger">{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="roles_list">رتبة المستخدم</label>
                        <select name="roles_list[]" id="roles_list" class="form-control btn-margin" multiple>
                            @foreach ($roles as $id => $role)
                                <option value="{{ $id }}">{{ $role }}</option>
                            @endforeach
                        </select>
                        @error('roles_list')
                            <span class="invalid-feedback" role="alert">
                                <strong class="text-danger">{{ $message }}</strong>
                            </span>
                        @enderror
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
