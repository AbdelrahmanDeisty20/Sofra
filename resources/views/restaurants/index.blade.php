@extends('layouts.app')
@section('page_title')
    <h1>المطاعم</h1>
@endsection


@section('content')
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">كل المطاعم </h3>

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
                                <th class="text-center">اسم المطعم</th>
                                <th class="text-center">الايميل</th>
                                <th class="text-center">الهاتف</th>
                                <th class="text-center">الواتسب</th>
                                <th class="text-center">محل السكن</th>
                                <th class="text-center">الحد الأدنى</th>
                                <th class="text-center">الصورة</th>
                                <th class="text-center">التوصيل</th>
                                <th class="text-center">الحالة</th>
                                {{-- <th class="text-center">Edit</th> --}}
                                <th class="text-center">حذف</th>
                            </thead>
                            <tbody>
                                @foreach ($records as $record)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $record->name }}</td>
                                        <td class="text-center">{{ $record->email }}</td>
                                        <td class="text-center">{{ $record->phone }}</td>
                                        <td class="text-center">{{ $record->whatsapp }}</td>
                                        <td class="text-center">{{ $record->region->name }}</td>
                                        <td class="text-center">{{ $record->minimum_order }}</td>
                                        <td class="text-center">{{ $record->image }}</td>
                                        <td class="text-center">{{ $record->delivery_fees }}</td>
                                        <td class="text-center">
                                            {{ $record->status ? 'مفتوح' : 'مغلق' }}
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('restaurants.destroy', $record->id) }}" method="post">
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
