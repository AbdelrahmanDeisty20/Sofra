@extends('layouts.app')
@section('page_title')
    اضافة دفعات
@endsection


@section('content')
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">اضف دفعة جديدة</h3>
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
                <form action="{{ route('payments.store') }}" method="POST" id="governorate-form">
                    @csrf
                    <div class="form-group">
                        <label for="restaurant_id">المطعم</label>
                        <select class="form-control btn-margin @error('restaurant_id') is-invalid @enderror" id="region"
                            name="restaurant_id">
                            <option value="">اختار المطعم</option>
                            @foreach ($restaurants as $restaurant)
                                <option value="{{ $restaurant->id }}">{{ $restaurant->name }}</option>
                            @endforeach
                        </select>
                        <br>
                        @error('restaurant_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="pay">السعر</label>
                        <input type="text" class="form-control btn-margin @error('pay') is-invalid @enderror"
                            id="pay" name="pay">
                        <br>
                        @error('pay')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="date">التاريخ</label>
                        <input type="date" class="form-control btn-margin @error('date') is-invalid @enderror"
                            id="date" name="date">
                        <br>
                        @error('date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="details">التفاصيل</label>
                        <input type="text" class="form-control btn-margin @error('details') is-invalid @enderror"
                            id="details" name="details">
                        <br>
                        @error('details')
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
