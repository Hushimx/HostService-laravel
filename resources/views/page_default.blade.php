@extends('admin.dashboard.includes.master')

@section('content')
    <!-- Main Container -->
    <main id="main-container">
        <!-- Hero -->
        <div class="bg-body-light">
            <div class="content content-full">
                <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                    <h1 class="flex-sm-fill h3 my-2">
                        Page Layout <small class="font-size-base font-w400 text-muted">Default</small>
                    </h1>
                    <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-alt">
                            <li class="breadcrumb-item">Layout</li>
                            <li class="breadcrumb-item">Page</li>
                            <li class="breadcrumb-item" aria-current="page">
                                <a class="link-fx" href="">Default</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- END Hero -->

        <!-- Page Content -->
        <div class="content">
            <div class="block block-rounded">
                <div class="block-content text-center">
                    <p>
                        Left Sidebar, right Side Overlay and a fixed Header.
                    </p>
                </div>
            </div>
        </div>
        <!-- END Page Content -->
    </main>
@endsection
