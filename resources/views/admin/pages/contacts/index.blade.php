@extends('admin.dashboard.includes.master')

@section('content')
<!-- Main Container -->
<main id="main-container">
  <!-- Hero -->
  <div class="bg-body-light">
    <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
        <h1 class="flex-sm-fill h3 my-2">
          {{ trans('main_trans.contacts') }} <small class="font-size-base font-w400 text-muted">{{ trans('main_trans.contacts_list') }}</small>
        </h1>
        <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-alt">
            <li class="breadcrumb-item" aria-current="page">
              <a class="link-fx" href="/">{{ trans('main_trans.Dashboard_page') }}</a>
            </li>
            <li class="breadcrumb-item">{{ trans('main_trans.contacts_list') }}</li>
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
        <x-alert></x-alert>

        <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
        <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
          <thead>
            <tr>
              <th class="text-center" style="width: 60px;">ID</th>
              <th>{{ trans('main_trans.name') }}</th>
              <th style="width: 30%;">{{ trans('main_trans.email') }}</th>

              <th class="d-none d-sm-table-cell">{{ trans('main_trans.phone') }}</th>
              <th class="d-none d-sm-table-cell">{{ trans('main_trans.age') }}</th>
              <th class="d-none d-sm-table-cell">{{ trans('main_trans.gender') }}</th>
              <th class="d-none d-sm-table-cell">{{ trans('main_trans.nationality') }}</th>

              <th class="d-none d-sm-table-cell">{{ trans('main_trans.message') }}</th>
              <th style="width: 15%;">{{ trans('grades.action') }}</th>
          </tr>
          </thead>
          <tbody>
            @foreach ($contacts as $contact)
              <tr>
                  <td class="text-center font-size-sm">{{$loop->iteration}}</td>
                  <td class="font-w600 font-size-sm">{{$contact->name}}</td>
                  <td class="font-w600 font-size-sm">{{$contact->email}}</td>
                  <td class="font-w600 font-size-sm">{{$contact->phone}}</td>
                  <td class="font-w600 font-size-sm">{{$contact->age}}</td>
                  <td class="font-w600 font-size-sm">{{$contact->gender}}</td>
                  <td class="font-w600 font-size-sm">{{$contact->nationality->name}}</td>
                  <td class="d-none d-sm-table-cell font-size-sm">{{$contact->message}}</td>
                  <td>
                      <div class="d-flex flex-xs-column flex-sm-column flex-md-row justify-content-start">
                          <button type="button" class="btn btn-sm btn-danger m-1" data-toggle="modal"
                                  data-target="#modal-delete-contact{{$contact->id}}">
                              <i class="fa fa-fw fa-times mr-1"></i> {{ trans('students.delete') }}
                          </button>
                      </div>
                  </td>
              </tr>
              <!-- start delete modal Content -->
              <div class="modal fade" id="modal-delete-contact{{$contact->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-block-large" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="block block-rounded block-themed block-transparent mb-0">
                      <div class="block-header bg-primary-dark">
                        <h3 class="block-title">{{ trans('action.delete') }}</h3>
                        <div class="block-options">
                          <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                          </button>
                        </div>
                      </div>
                      <div class="block-content font-size-sm">
                        {{-- start form --}}
                        <form action="{{ route('contact.destroy', $contact->id) }}" method="POST">
                          @csrf
                          @method('DELETE')
                          <div class="row">
                            <div class="col-lg-12 col-xl-12">
                              <div class="form-group text-center">
                                <p>{{ trans('grades.before_delete_alert') }}</p>
                                <p><strong>{{$contact->email}}</strong></p>
                                {{-- <input type="hidden" name="id" value="{{ $contact->id }}"> --}}
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
