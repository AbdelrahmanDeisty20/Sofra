@extends('layouts.app')
@section('page_title')
    اضافة صلاحية
@endsection


@section('content')
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">اضافة صلاحية جديدة</h3>
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
                <form action="{{ route('permissions.store') }}" method="POST" id="permission-form" class="form-horizontal">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">اسم الصلاحية</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" placeholder="ادخل اسم الصلاحية">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="routes" class="col-sm-2 control-label">المسارات (Routes)</label>
                        <div class="col-sm-10">
                            <textarea class="form-control @error('routes') is-invalid @enderror" id="routes"
                                name="routes" placeholder="ادخل المسارات مفصولة بفاصلة (مثال: categories.index,categories.create)"></textarea>
                            @error('routes')
                                <span class="invalid-feedback" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
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
