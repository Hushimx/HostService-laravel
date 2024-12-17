@extends('front.student.includes.student_dashboard_layout')
@section('pageTitle', 'Student Files | Mathematica')

@section('content')
  <x-headTitle>
    <x-slot name="title">{{ trans('students.This is where posts are shown!') }}</x-slot>
  </x-headTitle>

  {{-- All Files --}}
  <div class="all-posts p-0 bg-transparent">
    <h3 class="title mb-3 fw-bold" @if (App::getLocale() == 'ar') dir="rtl" data-aos="fade-right" @else data-aos="fade-left" @endif data-aos-delay="500">
      {{ trans('main_trans.attachments') }}
    </h3>
    <div class="row">
      @forelse ($gradeAttachments as $attachment)
        <div class="col-12 mb-3">
          <a class="text-decoration-none" href="{{ route('attachments.download', $attachment->id) }}">
            <div class="download-card border shadow-sm p-3 rounded">
              <h4>{{ $attachment->file_name }}</h4>
              <p class="mb-0">{{ $attachment->created_at }}</p>
            </div>
          </a>
        </div>
      @empty
        <p class="alert alert-info">There is no files to show right now !</p>
      @endforelse
    </div>

    {{-- Pagination --}}
    {{ $gradeAttachments->links() }}

  </div>
@endsection
