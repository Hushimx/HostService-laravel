@extends('admin.dashboard.includes.master')

@section('content')
<!-- Main Container -->
<main id="main-container">
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2">
                    {{ trans('main_trans.results') }} <small class="font-size-base font-w400 text-muted">{{ trans('main_trans.results_list') }}</small>
                </h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item" aria-current="page">
                            <a class="link-fx" href="/">{{ trans('main_trans.Dashboard_page') }}</a>
                        </li>
                        <li class="breadcrumb-item">{{ trans('main_trans.results') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
        <div class="block block-rounded">
            <div class="block-content block-content-full">

                {{-- errors And Alerts --}}
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger alert-dismissable" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <p class="mb-0">{{ $error }}</p>
                        </div>
                    @endforeach
                @endif
                @if(session('success'))
                    <div class="alert alert-success d-flex align-items-center ANIMATED FADEINDOWN" role="alert">
                        <div class="flex-00-auto">
                            <i class="fa fa-fw fa-check"></i>
                        </div>
                        <div class="flex-fill ml-3">
                            <p class="mb-0 text-capitalize">{{ session('success') }}</p>
                        </div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                @endif
                {{-- end errors And Alerts --}}

                <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
                <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 60px;">ID</th>
                            <th>{{ trans('main_trans.name') }}</th>
                            <th style="width: 30%;">{{ trans('main_trans.email') }}</th>
                            <th class="d-none d-sm-table-cell">{{ trans('main_trans.phone') }}</th>
                            <th style="width: 15%;">{{ trans('grades.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td class="text-center font-size-sm">{{$loop->iteration}}</td>
                                <td class="font-w600 font-size-sm">{{$student->name}}</td>
                                <td class="font-w600 font-size-sm">{{$student->email}}</td>
                                <td class="d-none d-sm-table-cell font-size-sm">{{$student->phone}}</td>
                                <td>
                                    <div class="d-flex flex-xs-column flex-sm-column flex-md-row justify-content-start">
                                        <a class="btn btn-primary btn-sm" href="{{ route('quiz.quizzes', ['user_id' => $student->id]) }}"><i class="fa fa-check fa-fw mr-2"></i>His Quizzes</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- END Dynamic Table Full -->
            </div>

        </div>
    </div>

</main>
@endsection
