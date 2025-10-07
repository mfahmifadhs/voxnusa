@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid col-md-5 col-12">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h4 class="m-0">Edit Category</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}"> Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('category.show') }}"> Categories</a></li>
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
                            Edit Category
                        </label>
                    </div>
                    <div class="table-responsive">
                        <form id="form" action="{{ route('category.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body border border-dark">
                                <div class="form-group">
                                    <label for="name" class="col-form-label">Name:</label>
                                    <input id="name" type="text" class="form-control" name="name" value="{{ $data->name }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="description" class="col-form-label">Description:</label>
                                    <input id="description" type="text" class="form-control" name="description" value="{{ $data->description }}">
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
