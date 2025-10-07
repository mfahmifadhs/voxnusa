@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid col-md-5 col-12">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h4 class="m-0">Edit Sub Category</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}"> Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('sub-category.show') }}">Sub Categories</a></li>
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
                            Edit Sub Category
                        </label>
                    </div>
                    <div class="table-responsive">
                        <form id="form" action="{{ route('sub-category.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body border border-dark">
                                <div class="form-group">
                                    <label for="category" class="col-form-label">Category:</label>
                                    <select name="category_id" class="form-control" id="category" style="width: 100%;" required>
                                        <option value="">-- Select Category --</option>
                                        @foreach ($category as $row)
                                        <option value="{{ $row->id }}" <?= $row->id == $data->category_id ? 'selected' : ''; ?>>
                                            {{ $row->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-form-label">Name:</label>
                                    <input id="name" type="text" class="form-control" name="name" value="{{ $data->name }}" required>
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
@section('js')
<script>
    $('#category').select2()
</script>
@endsection
@endsection
