@extends('layouts.app')
@inject('client', 'App\Models\Client')
@inject('categories', 'App\Models\Category')
@inject('user', 'App\Models\User')
@inject('regions', 'App\Models\Street')
@inject('contact', 'App\Models\Contact')
@inject('comment', 'App\Models\Comment')
@inject('cities', 'App\Models\City')
@inject('restaurants', 'App\Models\Restaurant')
@inject('products', 'App\Models\Product')
@inject('orders', 'App\Models\Order')
@inject('offers', 'App\Models\Offer')
@inject('payments', 'App\Models\Payment')

@section('page_title')
    Dashboard
@endsection

@section('small_title')
    statistics
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-user"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">clients</span>
                        <span class="info-box-number">{{ $client->count() }}</span>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-cutlery" aria-hidden="true"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">restaurants</span>
                        <span class="info-box-number">{{ $restaurants->count() }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-lemon-o" aria-hidden="true"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">products</span>
                        <span class="info-box-number">{{ $products->count() }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-list" aria-hidden="true"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">categories</span>
                        <span class="info-box-number">{{ $categories->count() }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">regions</span>
                        <span class="info-box-number">{{ $regions->count() }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-flag" aria-hidden="true"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">cities</span>
                        <span class="info-box-number">{{ $cities->count() }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-users" aria-hidden="true"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">users</span>
                        <span class="info-box-number">{{ $user->count() }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-cart-plus" aria-hidden="true"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">orders</span>
                        <span class="info-box-number">{{ $orders->count() }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-calendar" aria-hidden="true"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">offers</span>
                        <span class="info-box-number">{{ $offers->count() }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-money" aria-hidden="true"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">payments</span>
                        <span class="info-box-number">{{ $payments->count() }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-comment-o" aria-hidden="true"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">contacts</span>
                        <span class="info-box-number">{{ $contact->count() }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-star-half-o"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">comments</span>
                        <span class="info-box-number">{{ $comment->count() }}</span>
                    </div>
                </div>
            </div>

            <!-- Default box -->
            {{-- <div class="box"> --}}
            {{-- <div class="box-header with-border">
                <h3 class="box-title">Title</h3>

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
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                You are logged in!
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                Footer
            </div>
            <!-- /.box-footer-->
        </div> --}}
            <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
