@extends('admin.dashboard.includes.master')

@section('content')
<!-- Main Container -->
<main id="main-container">
  <!-- Hero -->
  <div class="bg-body-light">
    <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
        <h1 class="flex-sm-fill h3 my-2">
          {{ trans('videos.manageCourseVideos') }} <small class="font-size-base font-w400 text-muted">{{ $course->name }}</small>
        </h1>
        <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-alt">
            <li class="breadcrumb-item" aria-current="page">
              <a class="link-fx" href="/admin/dashboard">{{ trans('main_trans.Dashboard_page') }}</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
              <a class="link-fx" href="/courses">{{ trans('courses.course') }}</a>
            </li>
            <li class="breadcrumb-item">{{ trans('videos.manageCourseVideos') }}</li>
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
        <!-- start back button -->
        <a class="btn btn-success btn-sm mr-1 mb-3" href="/courses" id="goBackButton"
          data-toggle="tooltip" data-placement="top" title="Go Back"
        >
          <i class="fa fa-fw fa-arrow-right mr-1"></i>{{ trans('students.back') }}
        </a>
        <!-- start add button -->
        <button type="button" class="btn btn-success btn-sm mr-1 mb-3" data-toggle="modal" data-target="#modal-add-level">
          <i class="fa fa-fw fa-plus mr-1"></i> {{ trans('videos.addVideo') }}
        </button>
        <!-- END add button -->
        <!-- start add modal Content -->
        <div class="modal fade" id="modal-add-level" tabindex="-1" role="dialog" aria-labelledby="modal-block-large" aria-hidden="true">
          <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                  <h3 class="block-title">{{ trans('videos.addVideo') }}</h3>
                  <div class="block-options">
                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close" id="closeModal">
                      <i class="fa fa-fw fa-times"></i>
                    </button>
                  </div>
                </div>
                <div class="block-content font-size-sm py-0">
                  <form action="{{ route('videos.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                    <div class="row classes_add_form" id="jsAddAnotherData">
                      <div class="row my-block p-3">
                        {{-- video name --}}
                        <div class="col-xl-12">
                          <div class="form-group mb-3">
                            <label for="video_name">{{ trans('videos.name') }}</label>
                            <input type="text" class="form-control" id="video_name"
                              name="name" placeholder="{{ trans('videos.name') }}" value="{{ old('name') }}">
                            @error('name')
                              <div class="text-danger">{{ $message }}</div>
                            @enderror
                          </div>
                        </div>
                        {{-- video link --}}
                        <div class="col-xl-12">
                          <div class="form-group mb-3">
                            <label for="video_link">{{ trans('videos.link') }}</label>
                            <input type="text" class="form-control" id="video_link"
                              name="link" placeholder="{{ trans('videos.link') }}" value="{{ old('link') }}">
                            @error('link')
                              <div class="text-danger">{{ $message }}</div>
                            @enderror
                          </div>
                        </div>
                        {{-- video time --}}
                        <div class="col-xl-12">
                          <div class="form-group mb-3">
                            <label for="video_time">{{ trans('videos.time') }}</label>
                            <input type="text" class="js-masked-time form-control" value="{{ old('time') }}"
                              id="video_time" name="time" placeholder="00:00">
                            @error('time')
                              <div class="text-danger">{{ $message }}</div>
                            @enderror
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
        <div class="alertDiv">
          <x-alert />
        </div>
        {{-- end errors And Alerts --}}
        <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
        <table class="table table-responsive-xl table-bordered table-striped table-vcenter js-dataTable-full">
          <thead>
            <tr>
              <th class="text-center" style="width: 60px;">{{ trans('videos.order') }}</th>
              <th class="text-center" style="width: 60px;">ID</th>
              <th class="text-center">{{ trans('videos.name') }}</th>
              <th class="text-center">{{ trans('videos.link') }}</th>
              <th class="text-center">{{ trans('videos.time') }}</th>
              <th class="text-center" style="width: 180px;">{{ trans('courses.created_at') }}</th>
              <th class="text-center" style="width: 220px;">{{ trans('grades.action') }}</th>
            </tr>
          </thead>
          <tbody id="tbody">
            @php
              function formatDuration($seconds)
              {
                $minutes = floor($seconds / 60);
                $remainingSeconds = $seconds % 60;

                return sprintf('%02d:%02d', $minutes, $remainingSeconds);
              }
            @endphp
            @foreach ($course->videos as $video)

              <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">{{ $video->id }}</td>
                <td class="font-w600 font-size-sm">{{ $video->name }}</td>
                <td class="font-w600 font-size-sm">{{ $video->link }}</td>
                @if ($video->time)
                  <td class="font-w600 font-size-sm">{{ formatDuration($video->time) }}</td>
                @else
                  <td class="font-w600 font-size-sm">{{ trans('videos.noTime') }}</td>
                @endif
                <td class="font-w600 font-size-sm">
                  <span class="d-block">{{ $video->created_at->format('d/m/Y h:i A') }}</span>
                  <span>{{ $video->created_at->diffForHumans() }}</span>
                </td>
                <td>
                  <div class="d-flex flex-column justify-content-start align-items-stretch">
                    {{-- if there is question attached to the video show the add question button else show remove --}}
                    @if ($video->questions->count())
                      <a class="btn btn-sm btn-danger d-flex justify-content-start align-items-center mb-1"
                        data-toggle="tooltip" data-placement="left" title="Remove question from this video"
                        href="{{ route('videos.detachQuestion', $video->id) }}">
                        <i class="fa fa-fw fa-times mr-1"></i>
                        <span>{{ trans('students.remove_question_to_video') }}</span>
                      </a>
                    @else
                      <a class="btn btn-sm btn-success d-flex justify-content-start align-items-center mb-1"
                        data-toggle="tooltip" data-placement="left" title="Add question to this video"
                        href="{{ route('videos.questionList', $video->id) }}">
                        <i class="fa fa-fw fa-plus mr-1"></i>
                        <span>{{ trans('students.add_question_to_video') }}</span>
                      </a>
                    @endif
                    <a
                      class="btn btn-sm btn-primary d-flex justify-content-start align-items-center mb-1"
                      data-toggle="tooltip" data-placement="left" title="Edit this video"
                      href="{{ route('courses.videos.edit', [$course->id, $video->id]) }}">
                      <i class="fa fa-fw fa-edit mr-1"></i>
                      <span>{{ trans('students.edit') }}</span>
                    </a>
                    <button type="button" class="btn btn-sm btn-danger d-flex justify-content-start align-items-center"
                      data-toggle="modal" data-target="#modal-delete-video{{$video->id}}">
                      <i class="fa fa-fw fa-trash mr-1"></i>
                      <span>{{ trans('students.delete') }}</span>
                    </button>
                  </div>
                </td>
              </tr>
              <!-- start delete modal Content -->
              <div class="modal fade" id="modal-delete-video{{$video->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-block-large" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="block block-rounded block-themed block-transparent mb-0">
                      <div class="block-header bg-primary-dark">
                        <h3 class="block-title">{{ trans('videos.deleteVideo') }}</h3>
                        <div class="block-options">
                          <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                          </button>
                        </div>
                      </div>
                      <div class="block-content font-size-sm">
                        {{-- start form --}}
                        <form action="{{ route('courses.videos.destroy', [$course->id, $video->id]) }}" method="POST">
                          @csrf
                          @method('DELETE')
                          <div class="row">
                            <div class="col-lg-12 col-xl-12">
                              <div class="form-group text-center">
                                <p>{{ trans('grades.before_delete_alert') }}</p>
                                <p>{{ trans('videos.name') }} : <strong>{{$video->name}}</strong></p>
                                <p>{{ trans('courses.course') }} : <strong>{{$course->name}}</strong></p>
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

