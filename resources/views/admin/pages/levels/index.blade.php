@extends('admin.dashboard.includes.master')

@section('content')
<!-- Main Container -->
<main id="main-container">
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2">
                    Level Organize <small class="font-size-base font-w400 text-muted">{{ trans('students.quizzes_list') }}</small>
                </h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item" aria-current="page">
                            <a class="link-fx" href="/">{{ trans('main_trans.Dashboard_page') }}</a>
                        </li>
                        <li class="breadcrumb-item">Level Organize</li>
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

                <!-- start add button -->
                <button type="button" class="btn btn-success btn-sm mr-1 mb-3" data-toggle="modal" data-target="#modal-add-level">
                    <i class="fa fa-fw fa-plus mr-1"></i> New Level
                </button>
                <!-- END add button -->
                <!-- start add modal Content -->
                <div class="modal fade" id="modal-add-level" tabindex="-1" role="dialog" aria-labelledby="modal-block-large" aria-hidden="true">
                    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="block block-rounded block-themed block-transparent mb-0">
                                <div class="block-header bg-primary-dark">
                                    <h3 class="block-title">New Level</h3>
                                    <div class="block-options">
                                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close" id="closeModal">
                                            <i class="fa fa-fw fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="block-content font-size-sm">
                                    <form action="{{ route('quiz_levels.store') }}" method="POST">
                                        @csrf
                                        <div class="row classes_add_form" id="jsAddAnotherData">
                                            <div class="row my-block p-3">
                                                <div class="col-xl-12">
                                                    <div class="form-group">
                                                        <label for="level_name">Name</label>
                                                        <input type="text" class="form-control form-control-alt" id="level_name"
                                                                name="name" placeholder="{{ trans('students.quiz_name') }}">
                                                    </div>
                                                </div>
                                                <div class="col-xl-12">
                                                    <div class="form-group">
                                                        <label for="level_desc">Description</label>
                                                        <textarea class="form-control form-control-alt" id="level_desc" name="description"
                                                        rows="4" placeholder="{{ trans('students.quiz_text') }}"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="block-content text-left border-top">
                                                <div class="form-group">
                                                    <button type="button" class="btn btn-alt-primary mr-1" data-dismiss="modal">{{ trans('grades.cancel') }}</button>
                                                    <button type="submit" class="btn btn-md btn-primary">
                                                        <i class="fa fa-check fa-fw mr-2"></i>{{ trans('grades.save') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END add modal Content -->
                {{-- errors And Alerts --}}
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
                @if(session('error'))
                    <div class="alert alert-danger d-flex align-items-center animated fadeInDown" role="alert">
                        <div class="flex-00-auto">
                            <i class="far fa-sad-tear fa-fw"></i>
                        </div>
                        <div class="flex-fill ml-3">
                            <p class="mb-0 text-capitalize">{{ session('error') }}</p>
                        </div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                @endif
                {{-- end errors And Alerts --}}
                <div class="alertDiv"></div>
                <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
                <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 60px;">ID</th>
                            <th>Name</th>
                            <th style="width: 30%">Description</th>
                            <th style="width: 30%">{{ trans('grades.action') }}</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        @foreach ($quizLevels as $quizLevel)
                            <tr>
                                <td class="text-center font-size-sm">{{ $loop->iteration }}</td>
                                <td class="font-w600 font-size-sm">{{ $quizLevel->name }}</td>
                                <td class="font-w600 font-size-sm">{{ $quizLevel->description ?  $quizLevel->description : "No Description" }}</td>
                                <td>
                                    <div class="d-flex flex-xs-column flex-sm-column flex-md-row justify-content-start align-items-center">
                                        <a class="btn btn-sm btn-info m-1" href="{{ route('quiz_levels.show', $quizLevel->id) }}">
                                            <i class="fa fa-fw fa-eye fa-fw mr-1"></i>{{ trans('students.show') }}
                                        </a>
                                        <a class="btn btn-sm btn-primary" href="{{ route('quiz_levels.edit', $quizLevel) }}">
                                            <i class="fa fa-fw fa-edit fa-fw mr-1"></i>{{ trans('students.edit') }}
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger m-1" data-toggle="modal" data-target="#modal-delete-quizLevel{{$quizLevel->id}}">
                                            <i class="fa fa-fw fa-times mr-1"></i> {{ trans('students.delete') }}
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <!-- start delete modal Content -->
                            <div class="modal fade" id="modal-delete-quizLevel{{$quizLevel->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-block-large" aria-hidden="true">
                                <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="block block-rounded block-themed block-transparent mb-0">
                                            <div class="block-header bg-primary-dark">
                                                <h3 class="block-title">{{ trans('students.quiz_delete') }}</h3>
                                                <div class="block-options">
                                                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                                        <i class="fa fa-fw fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="block-content font-size-sm">
                                                {{-- start form --}}
                                                <form action="{{ route('quiz_levels.destroy', $quizLevel) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="row">
                                                        <div class="col-lg-12 col-xl-12">
                                                            <div class="form-group text-center">
                                                                <p>{{ trans('grades.before_delete_alert') }}</p>
                                                                <p><strong>{{$quizLevel->name}}</strong></p>
                                                            </div>
                                                        </div>
                                                        <div class="block-content text-center border-top">
                                                            <div class="form-group">
                                                                <button type="submit" class="btn btn-md btn-danger">
                                                                    <i class="fa fa-fw fa-times mr-1"></i> {{ trans('grades.yes') }}
                                                                </button>
                                                                <button type="button" class="btn btn-alt-primary mr-1" data-dismiss="modal">{{ trans('grades.no') }}</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                {{-- End form --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END delete modal Content -->
                        @endforeach
                    </tbody>
                </table>
                <!-- END Dynamic Table Full -->
            </div>
        </div>
    </div>

</main>
@endsection

