@extends('layouts.app')
@section('page_title')
    <h1>الاعدادات</h1>
@endsection


@section('content')
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">اعدادات الموقع </h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                        title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="box-body">
                <form action="{{ route('settings.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="facebook_link">رابط فيس بوك</label>
                        <input type="text" class="form-control @error('facebook_link') is-invalid @enderror"
                            id="facebook_link" name="facebook_link">
                        @error('facebook_link')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="twitter_link">رابط التويتر</label>
                        <input type="text" class="form-control  @error('twitter_link') is-invalid @enderror "
                            id="twitter_link" name="twitter_link">
                        @error('twitter_link')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="instagram_link"> رابط انستجرام</label>
                        <input type="text" class="form-control  @error('instagram_link') is-invalid @enderror"
                            id="instagram_link" name="instagram_link">
                        @error('instagram_link')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="youtube_link"> رابط يوتيوب</label>
                        <input type="text" class="form-control @error('youtube_link') is-invalid @enderror"
                            id="youtube_link" name="youtube_link">
                        @error('youtube_link')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="phone">رقم الهاتف</label>
                        <input type="text" class="form-control  @error('phone') is-invalid @enderror" id="phone"
                            name="phone">
                        @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="whatsapp">رقم الواتس</label>
                        <input type="text" class="form-control  @error('whatsapp') is-invalid @enderror" id="whatsapp"
                            name="whatsapp">
                        @error('whatsapp')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">الايميل</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="commission_details">العمولة</label>
                        <input type="text" class="form-control @error('commission_details') is-invalid @enderror" id="commission_details"
                            name="commission_details">
                        @error('commission_details')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- <div class="form-group">
                        <label for="about_app">عن التطبيق</label>
                        <input type="text" class="form-control @error('about_app') is-invalid @enderror" id="about_app"
                            name="about_app">
                        @error('about_app')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div> --}}
                    <div class="form-group">
                        <label for="banks">البنوك</label>
                        <input type="text" class="form-control @error('banks') is-invalid @enderror"
                            id="banks" name="banks">
                        @error('banks')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" id="submit-btn">
                    </div>
            </div>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
