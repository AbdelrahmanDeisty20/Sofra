@extends('layouts.app')
@section('page_title')
    <h1>الأراء والتقييمات</h1>
@endsection


@section('content')
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">كل التقييمات والأراء </h3>

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
                        {{ session('success') }}
                    </div>
                @endif
                @if (count($records))
                    <div class="table-responsive">
                        <table class="table table-bordered" style="margin-top: 10px">
                            <thead>
                                <th class="text-center">#</th>
                                <th class="text-center">الاسم</th>
                                <th class="text-center">المطعم</th>
                                <th class="text-center">التقييم</th>
                                <th class="text-center">الرأي</th>
                                <th class="text-center">حذف</th>
                            </thead>
                            <tbody>
                                @foreach ($records as $record)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $record->client->name }}</td>
                                        <td class="text-center">{{ $record->restaurant->name }}</td>
                                        <td class="text-center">{{ $record->rate }}</td>
                                        <td class="text-center">{{ $record->comment }}</td>
                                        <td class="text-center">
                                            <form action="{{ route('comments.destroy', $record->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('هل أنت متأكد من حذف هذه الفئة؟')"><i
                                                        class="fa fa-trash-o"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-danger" role="alert">
                        لايوجد بيانت
                    </div>
                @endif
            </div>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
