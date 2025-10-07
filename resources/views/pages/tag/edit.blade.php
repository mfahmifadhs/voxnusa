@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid col-md-5 col-12">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h4 class="m-0">Edit Tag</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}"> Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('tag.show') }}"> Tags</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>

            </div>
        </div>
    </div>
</div>


<section class="content">
    <div class="container-fluid col-md-5 col-12">
        <div class="row">
            <div class="col-md-12 form-group">
                <div class="card card-primary">
                    <div class="card-header border border-dark">
                        <label class="card-title">
                            Edit Tag
                        </label>
                    </div>
                    <div class="table-responsive">
                        <form id="form" action="{{ route('tag.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body border border-dark">
                                <div class="form-group">
                                    <label for="name" class="col-form-label">Name:</label>
                                    <input id="name" type="text" class="form-control" name="name" value="{{ $data->name }}">
                                </div>
                                <div class="form-group">
                                    <label for="slug" class="col-form-label">Slug:</label>
                                    <input id="slug" type="text" class="form-control" name="slug" value="{{ $data->slug }}">
                                </div>
                            </div>
                            <div class="card-footer border border-dark text-right">
                                <button type="button" class="btn btn-primary" onclick="confirmSubmit(event, 'form')">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
