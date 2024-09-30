@extends('layouts.app')
@section('page_title')
    اضف مدينة
@endsection


@section('content')
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">اضف مدينة جديدة </h3>
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
                <form action="{{ route('cities.store') }}" method="POST" id="governorate-form">
                    @csrf
                    <div class="form-group">
                        <label for="name">اسم المدينة</label>
                        <input type="text" class="form-control btn-margin @error('name') is-invalid @enderror"
                            id="name" name="name">
                            <br>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
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
