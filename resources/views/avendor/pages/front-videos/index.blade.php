@extends('admin.dashboard.includes.master')

@section('content')
<!-- Main Container -->
<main id="main-container">
  <!-- Hero -->
  <x-hero>
    <x-slot name="title">
      {{ trans('posts.posts') }} <small class="font-size-base font-w400 text-muted">{{ trans('posts.manage') }}</small>
    </x-slot>
    <li class="breadcrumb-item" aria-current="page">
      <a class="link-fx" href="/admin/dashboard">{{ trans('main_trans.Dashboard_page') }}</a>
    </li>
    <li class="breadcrumb-item">{{ trans('posts.manage') }} {{ trans('main_trans.frontVideos') }}</li>
  </x-hero>

  <!-- Page Content -->
  <div class="content">
    <div class="block block-rounded">
      <div class="block-content block-content-full">
        <!-- start create post button -->
        <a class="btn btn-success btn-sm mr-1 mb-3" data-toggle="modal" data-target="#modal-add-video">
          <i class="fa fa-fw fa-plus mr-1"></i>{{ trans('videos.addVideo') }}
        </a>
        <!-- start add modal Content -->
        <div class="modal fade" id="modal-add-video" tabindex="-1" role="dialog" aria-labelledby="modal-block-large" aria-hidden="true">
          <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                  <h3 class="block-title">{{ trans('main_trans.newvideo') }}</h3>
                  <div class="block-options">
                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close" id="closeModal">
                      <i class="fa fa-fw fa-times"></i>
                    </button>
                  </div>
                </div>
                <div class="block-content font-size-sm py-0">
                  <form action="{{ route('frontvideos.store') }}" method="POST">
                    @csrf
                    <div class="row">
                      <div class="row my-block p-3">
                        {{-- video url --}}
                        <div class="col-xl-12">
                          <div class="form-group mb-3">
                            <label for="url">{{ trans('videos.link') }}</label>
                            <input type="text" class="form-control form-control-alt" id="url"
                              name="url" placeholder="{{ trans('videos.link') }}" value="{{ old('url') }}">
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

        <x-alert /> {{-- errors And Alerts --}}

        <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
        <table class="table table-responsive-xl table-bordered table-striped table-vcenter js-dataTable-full">
          <thead>
            <tr>
              <th class="text-center" style="width: 60px;">ID</th>
              <th class="text-center">{{ trans('videos.link') }}</th>
              <th class="text-center">{{ trans('posts.created_at') }}</th>
              <th class="text-center">{{ trans('posts.updated_at') }}</th>
              <th class="text-center" style="width: 180px;">{{ trans('posts.action') }}</th>
            </tr>
          </thead>
          <tbody id="tbody">
            @foreach ($videos as $video)
              <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="font-w600 font-size-sm">
                  <iframe class="rounded d-block mx-auto"
                    width="auto" height="auto"
                    src="https://www.youtube.com/embed/{{ $video->url }}"
                    title="Mr Mathematica" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin"allowfullscreen>
                  </iframe>
                </td>
                <td class="font-w600 font-size-sm">
                  <span class="d-block">{{ $video->created_at->format('d/m/Y h:i A') }}</span>
                  <span>{{ $video->created_at->diffForHumans() }}</span>
                </td>
                <td class="font-w600 font-size-sm">
                  <span class="d-block">{{ $video->updated_at->format('d/m/Y h:i A') }}</span>
                  <span>{{ $video->updated_at->diffForHumans() }}</span>
                </td>
                <td>
                  <div class="d-flex flex-column justify-content-start align-items-stretch">
                    <a class="btn btn-sm btn-primary d-flex align-items-baseline mb-1"
                      data-toggle="modal" data-target="#modal-edit-video{{$video->id}}">
                      <i class="fa fa-edit fa-fw mr-1"></i>{{ trans('posts.editPost') }}
                    </a>
                    <button type="button" class="btn btn-sm btn-danger d-flex align-items-baseline"
                      data-toggle="modal" data-target="#modal-delete-video{{$video->id}}">
                      <i class="fa fa-times fa-fw mr-1"></i>{{ trans('posts.deletePost') }}
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
                        <h3 class="block-title">{{ trans('posts.deletePost') }}</h3>
                        <div class="block-options">
                          <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                          </button>
                        </div>
                      </div>
                      <div class="block-content font-size-sm">
                        {{-- start form --}}
                        <form action="{{ route('frontvideos.destroy', $video->id) }}" method="POST">
                          @csrf
                          @method('DELETE')
                          <div class="row">
                            <div class="col-lg-12 col-xl-12">
                              <div class="form-group text-center">
                                <p>{{ trans('grades.before_delete_alert') }}</p>
                                <p><strong>{{ $video->link }}</strong></p>
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

              <div class="modal fade" id="modal-edit-video{{$video->id}}" tabindex="-1" role="dialog"
                aria-labelledby="modal-block-large" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="block block-rounded block-themed block-transparent mb-0">
                      <div class="block-header bg-primary-dark">
                        <h3 class="block-title">{{ trans('videos.edit') }}</h3>
                        <div class="block-options">
                          <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close" id="closeModal">
                            <i class="fa fa-fw fa-times"></i>
                          </button>
                        </div>
                      </div>
                      <div class="block-content font-size-sm py-0">
                        <form action="{{ route('frontvideos.update', $video->id) }}" method="POST">
                          @csrf
                          @method('put')
                          <div class="row">
                            <div class="row my-block p-3">
                              {{-- video url --}}
                              <div class="col-xl-12">
                                <div class="form-group mb-3">
                                  <label for="url">{{ trans('videos.link') }}</label>
                                  <input type="text" class="form-control form-control-alt" id="url" value="{{ $video->url }}"
                                    name="url" placeholder="{{ trans('videos.link') }}" value="{{ old('url') }}">
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

