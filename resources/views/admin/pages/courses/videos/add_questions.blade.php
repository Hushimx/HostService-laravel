@extends('admin.dashboard.includes.master')

@section('css_adds')
  <style>
    .img-thumb {
      max-height: 155px;
      box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 1px 3px 1px;
      border-radius: 6px;
    }
  </style>
@endsection

@section('content')
<!-- Main Container -->
<main id="main-container">
  <!-- Hero -->
  <x-hero>
    <x-slot name="title">
      {{ trans('students.add_question_to_video') }} <small class="font-size-base font-w400 text-muted">
        <span class="text-primary text-capitalize">video name : </span>{{ $video->name }} <fa class="fa fa-arrow-right mx-2"></fa>
        <span class="text-primary text-capitalize">course: </span>{{ $video->course->name }}
      </small>
    </x-slot>
    <li class="breadcrumb-item" aria-current="page">
      <a class="link-fx" href="/">{{ trans('main_trans.Dashboard_page') }}</a>
    </li>
    <li class="breadcrumb-item">{{ trans('students.quiz_list') }}</li>
  </x-hero>

  <!-- Page Full Content -->
  <x-page-full-content>

    <!-- go Back Button -->
    <a class="btn btn-success btn-sm mr-1 mb-3" href="{{ route('videos.show', $course->id) }}" id="goBackButton">
      <i class="fa fa-fw fa-arrow-right mr-1"></i>{{ trans('students.back') }}
    </a>

    <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
    <table id="datatable" class="table table-responsive-xl table-bordered table-striped table-vcenter js-dataTable-full">
      <thead>
        <tr>
          <th class="text-center" style="width: 60px;">ID</th>
          <th>{{ trans('students.quiz_text') }}</th>
          <th class="d-none d-sm-table-cell">{{ trans('students.quiz_image') }}</th>
          <th class="d-none d-sm-table-cell">{{ trans('students.grade') }}</th>
          <th style="width: 15%">{{ trans('grades.action') }}</th>
        </tr>
      </thead>
      <tbody id="tbody">
      @foreach ($questions as $question)
        <tr>
          <td class="text-center font-size-sm">{{ $loop->iteration }}</td>
          <td class="font-w600 font-size-sm">{{ $question->text }}</td>
          <td class="font-w600 font-size-sm">
            @if ($question->image)
              <a href="{{ url('storage/'.$question->image) }}" class="img-link img-link-zoom-in d-block mx-auto mag-img">
                <img class="img-thumb d-block mx-auto" src="{{ url('storage/'.$question->image) }}" alt="{{ $question->text }}">
              </a>
            @else
              <a href="{{ url('storage/no-image.png') }}" class="img-link img-link-zoom-in d-block mx-auto mag-img">
                <img class="img-thumb d-block mx-auto" src="{{ url('storage/no-image.png') }}" alt="{{ $question->text }}">
              </a>
            @endif
          </td>
          <td class="d-none d-sm-table-cell font-size-sm">
            <span class="btn btn-dark btn-sm d-block">{{ $question->grade->name }}</span>
          </td>
          <td>
            <div class="d-flex flex-column justify-content-start">
              <a class="btn btn-sm btn-success text-left"
                href="{{ route('videos.attachQuestion', [$video->id, $question->id]) }}"
                data-toggle="tooltip" data-placement="left" title="Add Question To The Video Selected"
              >
                <i class="fa fa-check fa-fw mr-1"></i>
                <span>{{ trans('students.add_question') }}</span>
              </a>
            </div>
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </x-page-full-content>

</main>
@endsection

@section('scripts')
  <script>
    $(document).ready(function() {
      $('.mag-img').magnificPopup({type:'image'});
    });
  </script>
@endsection
