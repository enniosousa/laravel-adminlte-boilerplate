@extends('layouts.app')

@section('page_title', trans('crud.detail') . ' '. trans('models/users.singular'))

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>@lang('models/users.singular')</h1>
            </div>
            <div class="col-sm-6">
                <a class="btn btn-default float-right" href="{{ route('users.index') }}">
                    @lang('crud.back')
                </a>
            </div>
        </div>
    </div>
</section>

<div class="content px-3">
    <div class="card card-primary card-outline">
        <div class="card-body">
            @include('users.show_fields')
        </div><!-- /.card-body -->
    </div>
</div>
@endsection