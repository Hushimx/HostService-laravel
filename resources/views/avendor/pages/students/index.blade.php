@extends('admin.dashboard.includes.master')

@section('content')
<!-- Main Container -->
<main id="main-container">
  <!-- Hero -->
  <x-hero>
    <x-slot name="title">
      {{ trans('main_trans.students') }} <small class="font-size-base font-w400 text-muted">{{ trans('main_trans.students_list') }}</small>
    </x-slot>
    <li class="breadcrumb-item" aria-current="page">
      <a class="link-fx" href="/admin">{{ trans('main_trans.Dashboard_page') }}</a>
    </li>
    <li class="breadcrumb-item">{{ trans('main_trans.students_list') }}</li>
  </x-hero>


  <!-- Page Content -->
  <div class="content">
    <div class="block block-rounded">
      <div class="block-content block-content-full">

        <!-- start add button -->
        <a class="btn btn-success btn-sm mr-1 mb-3" href="{{ route('students.create') }}">
          <i class="fa fa-fw fa-plus mr-1"></i>
          <span>{{ trans('students.add_new_student') }}</span>
        </a>

        <x-alert></x-alert> {{-- errors And Alerts --}}

        <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
        <table class="table table-responsive-xl table-hover table-bordered table-striped table-vcenter js-dataTable-full">
          <thead>
            <tr>
              <th class="text-center" style="width: 60px;">ID</th>
              <th>{{ trans('students.name') }}</th>
              <th>{{ trans('students.email') }}</th>
              <th>{{ trans('students.phone') }}</th>
              <th>{{ trans('students.account_type') }}</th>
              <th>{{ trans('courses.grade') }}</th>
              <th>{{ trans('courses.created_at') }}</th>
              <th style="width: 15%;">{{ trans('grades.action') }}</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($students as $student)
              <tr>
                <td class="text-center font-size-sm">{{ $loop->iteration }}</td>
                <td class="font-w600 font-size-sm">{{ $student->name }}</td>
                <td>{{ $student->email }}</td>
                <td class="font-size-sm">{{ $student->phone }}</td>
                <td class="font-size-sm">
                  @if ($student->role == 'admin')
                    <span class="text-capitalize bg-dark text-light p-2 rounded text-center font-weight-bold d-block">{{ $student->role }}</span>
                  @else
                    <span class="text-capitalize bg-success text-light p-2 rounded text-center font-weight-bold d-block">{{ $student->role }}</span>
                  @endif
                </td>
                <td class="font-w600 font-size-sm text-center">@if ($student->grade) {{ $student->grade->name }} @endif</td>
                <td class="font-w600 font-size-sm text-center">
                  @if ($student->created_at)
                    <p class="mb-0">{{ $student->created_at->format('M d Y') }} ({{ $student->created_at->diffForHumans() }})</p>
                  @else
                    {{ 'Unknown' }}
                  @endif
                </td>
                <td>
                  <div class="d-flex flex-xs-column flex-sm-column flex-md-row justify-content-start">
                    <a class="btn btn-sm btn-primary m-1" href="{{ route('students.edit', $student->id) }}"><i class="fa fa-fw fa-edit mr-1"></i> {{ trans('students.edit') }}</a>
                    <button type="button" class="btn btn-sm btn-danger m-1" data-toggle="modal" data-target="#modal-delete-student{{$student->id}}">
                      <i class="fa fa-fw fa-times mr-1"></i> {{ trans('students.delete') }}
                    </button>
                  </div>
                </td>
              </tr>
              <!-- start delete modal Content -->
              <div class="modal fade" id="modal-delete-student{{$student->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-block-large" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="block block-rounded block-themed block-transparent mb-0">
                      <div class="block-header bg-primary-dark">
                        <h3 class="block-title">{{ trans('myclass.delete_class') }}</h3>
                        <div class="block-options">
                          <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                          </button>
                        </div>
                      </div>
                      <div class="block-content font-size-sm">
                        {{-- start form --}}
                        <form action="{{ route('students.destroy', $student->id) }}" method="POST">
                          @csrf
                          @method('DELETE')
                          <div class="row">
                            <div class="col-lg-12 col-xl-12">
                              <div class="form-group text-center">
                                <p>{{ trans('grades.before_delete_alert') }}</p>
                                <p><strong>{{$student->name}}</strong></p>
                              </div>
                            </div>
                            <div class="block-content text-center border-top">
                              <div class="form-group">
                                <button type="submit" class="btn btn-md btn-danger">
                                  <i class="fa fa-fw fa-times mr-1"></i>
                                  <span>{{ trans('grades.yes') }}</span>
                                </button>
                                <button type="button" class="btn btn-alt-primary mr-1" data-dismiss="modal">
                                  <span>{{ trans('grades.no') }}</span>
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
            @endforeach
          </tbody>
        </table>

      </div>
    </div>
  </div>

</main>
@endsection
