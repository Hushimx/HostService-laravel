@extends('admin.dashboard.includes.master')

@section('content')
<!-- Main Container -->
<main id="main-container">
  <!-- Hero -->
  <div class="bg-body-light">
    <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
        <h1 class="flex-sm-fill h3 my-2">
          {{ trans('courses.courseManagement') }} <small class="font-size-base font-w400 text-muted">{{ $course->name }}</small>
        </h1>
        <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-alt">
            <li class="breadcrumb-item" aria-current="page">
              <a class="link-fx" href="/admin/dashboard">{{ trans('main_trans.Dashboard_page') }}</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
              <a class="link-fx" href="/courses">{{ trans('courses.courses') }}</a>
            </li>
            <li class="breadcrumb-item">{{ trans('courses.courseManagement') }}</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>

  <!-- Page Content -->
  <div class="content">
    <div class="block block-rounded">
      <div class="block-content block-content-full">
        {{-- errors And Alerts --}}
        <div class="alertDiv">
          <x-alert />
        </div>

        <!-- start add button -->
        <a class="btn btn-success btn-sm mr-1 mb-3" href="{{ route('courses.index') }}">
          <i class="fa fa-fw fa-arrow-right mr-1"></i>{{ trans('students.back') }}
        </a>

        <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
        <table class="table table-responsive-xl table-bordered table-striped table-vcenter js-dataTable-full">
          <thead>
            <tr>
              <th class="text-center" style="width: 60px;">ID</th>
              <th class="text-center">{{ trans('students.name') }}</th>
              <th class="text-center">{{ trans('students.email') }}</th>
              <th class="text-center">{{ trans('students.phone') }}</th>
              <th class="text-center">{{ trans('students.fullName') }}</th>
              <th class="text-center" style="width: 145px;">{{ trans('students.approve') }}</th>
              <th class="text-center">{{ trans('students.grade') }}</th>
              <th class="text-center" style="width: 180px;">{{ trans('students.created_at') }}</th>
              <th class="text-center">{{ trans('grades.action') }}</th>
            </tr>
          </thead>
          <tbody id="tbody">
            @foreach ($users as $user)
              <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="font-w600 font-size-sm">{{ $user->name }}</td>
                <td class="font-w600 font-size-sm">{{ $user->email }}</td>
                <td class="font-w600 font-size-sm">{{ $user->phone }}</td>
                <td class="font-w600 font-size-sm">{{ $user->fullName }}</td>
                <td class="font-w600 font-size-sm text-white text-center">
                  @if ($user->courses->contains($course->id)) {{-- if allowed to enroll in course --}}
                  <span class='bg-success p-1 rounded d-block'><i class="fa fa-fw fa-check-circle fa-fw mr-1"></i>{{ trans('students.enrolled') }}</span>
                  @else {{-- if not allowed to enroll in course --}}
                  <span class='bg-danger p-1 rounded d-block'><i class="fa fa-fw fa-times-circle fa-fw mr-1"></i>{{ trans('students.notEnrolled') }}</span>
                  @endif
                </td>
                <td class="font-w600 font-size-sm">{{ $user->grade->name }}</td>
                <td class="font-w600 font-size-sm">
                  <span class="d-block">{{ $course->created_at->format('d/m/Y h:i A') }}</span>
                  <span>{{ $course->created_at->diffForHumans() }}</span>
                </td>
                <td>
                  <div class="d-flex flex-xs-column flex-sm-column flex-md-row justify-content-start align-items-center">
                    @if ($user->courses->contains($course->id)) {{-- if allowed to enroll in course --}}
                      <a class="btn btn-sm btn-danger m-1 d-flex justify-content-between align-items-baseline"
                        href="{{ route('courses.deny', ['course_id' => $course->id, 'user_id' => $user->id]) }}">
                        <i class="fa fa-fw fa-times-circle fa-fw mr-1"></i>{{ trans('students.doNotAllow') }}
                      </a>
                    @else {{-- if not allowed to enroll in course --}}
                      <a class="btn btn-sm btn-success m-1 d-flex justify-content-between align-items-baseline"
                      href="{{ route('courses.allow', ['course_id' => $course->id, 'user_id' => $user->id]) }}">
                      <i class="fa fa-fw fa-check-circle fa-fw mr-1"></i>{{ trans('students.allow') }}
                      </a>
                    @endif
                  </div>
                </td>
              </tr>
              <!-- start delete modal Content -->
              <div class="modal fade" id="modal-delete-course{{$course->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-block-large" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="block block-rounded block-themed block-transparent mb-0">
                      <div class="block-header bg-primary-dark">
                        <h3 class="block-title">{{ trans('courses.deleteCourse') }}</h3>
                        <div class="block-options">
                          <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                          </button>
                        </div>
                      </div>
                      <div class="block-content font-size-sm">
                        {{-- start form --}}
                        <form action="{{ route('courses.destroy', $course) }}" method="POST">
                          @csrf
                          @method('DELETE')
                          <div class="row">
                            <div class="col-lg-12 col-xl-12">
                              <div class="form-group text-center">
                                <p>{{ trans('grades.before_delete_alert') }}</p>
                                <p><strong>{{$course->name}}</strong></p>
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

