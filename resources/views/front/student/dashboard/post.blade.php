@extends('front.student.includes.student_dashboard_layout')
@section('pageTitle', 'Post | Mathematica')

@section('content')
  <x-headTitle>
    <x-slot name="title">{{ trans('students.Your Post Content') }}</x-slot>
  </x-headTitle>

  <button class="btn border mb-3 rounded-1 btn-back" onclick="history.back()">
    <i class="fa fa-chevron-left me-1"></i><span>Back</span>
  </button>

  {{-- post full view --}}
  <div class="post p-3">
    <h3 class="title mb-3 fw-bold text-center" data-aos="fade-right" data-aos-delay="500">
      {{ $post->title }}
    </h3>
    <div class="mb-4">
      @if ($post->thumbnail && Storage::disk('posts_images')->exists($post->thumbnail))
      <img class="img-fluid d-block mx-auto rounded"  src="{{ url('storage/posts_images/', $post->thumbnail) }}" alt="{{$post->title}}">
      @else
      <img class="img-fluid d-block mx-auto rounded" src="{{ url('storage/posts_images/photo22.jpg') }}" alt="{{$post->title}}">
      @endif
    </div>
    <div class="row justify-content-center overflow-hidden">
      <div class="col-sm-8">
        {!! $post->content !!}
      </div>
    </div>
  </div>
@endsection
