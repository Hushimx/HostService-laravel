@extends('admin.dashboard.includes.master')

@section('content')
<!-- Main Container -->
<main id="main-container">
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2">
                    Edit Level Organize <small class="font-size-base font-w400 text-muted">{{ trans('students.quizzes_list') }}</small>
                </h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item" aria-current="page">
                            <a class="link-fx" href="/">{{ trans('main_trans.Dashboard_page') }}</a>
                        </li>
                        <li class="breadcrumb-item">Edit Level Organize</li>
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
                <a class="btn btn-success btn-sm mr-1 mb-3" href="#" id="goBackButton">
                    <i class="fa fa-fw fa-arrow-right mr-1"></i>{{ trans('students.back') }}
                </a>
                <!-- END back button -->

                <form action="{{ route('quiz_levels.update', $quizLevel) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <h2 class="content-heading mb-4">{{ trans('students.quiz_info') }}</h2>
                    <div class="form-row my-3">
                        <div class="col">
                            <label for="name">Level Name</label>
                            <input id="name" type="text" name="name" class="form-control" value="{{ $quizLevel->name }}">
                            @error('name')
                                <div class="alert alert-danger my-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-xl-12 mb-3">
                            <label for="text">{{trans('students.quiz_text')}}</label>
                            <textarea class="form-control" name="description" id="text" cols="30" rows="4">{{ $quizLevel->description }}</textarea>
                            @error('description')
                                <div class="alert alert-danger my-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-md" type="submit"><i class="fa fa-check fa-fw mr-1"></i>{{ trans('students.update') }}</button>
                    </div>
                </form>

            </div>

        </div>
    </div>

</main>
@endsection

@section('scripts')
    <script>
        document.getElementById("goBackButton").addEventListener("click", function() {
            history.back();
        });
    </script>
@endsection
