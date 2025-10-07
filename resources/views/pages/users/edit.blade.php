@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid col-md-8">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h4 class="m-0">Edit Users</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}"> Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('users.show') }}"> Daftar</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>

            </div>
        </div>
    </div>
</div>


<section class="content">
    <div class="container-fluid col-md-8">
        <div class="row">
            <div class="col-md-12 form-group">
                <div class="card card-primary">
                    <div class="card-header border border-dark">
                        <label class="card-title">
                            Edit Users
                        </label>
                    </div>
                    <div class="table-responsive">
                        <form id="form" action="{{ route('users.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body border border-dark">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label for="role" class="col-form-label">Pilih Role:</label>
                                        <select class="form-control" name="role_id" required>
                                            @foreach ($role as $row)
                                            <option value="{{ $row->id }}" <?php echo $row->id == $data->role_id ? 'selected' : '';?>>
                                                {{ $row->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="name" class="col-form-label">Nama:</label>
                                        <input id="name" type="text" class="form-control" name="name" value="{{ $data->name }}">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="username" class="col-form-label">Username:</label>
                                        <input id="username" type="text" class="form-control" name="username" value="{{ $data->username }}">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="password" class="col-form-label">Password:</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control border-dark rounded password" name="password" value="{{ $data->password_text }}" placeholder="Masukkan Password" required>
                                            <div class="input-group-append border rounded border-dark">
                                                <span class="input-group-text h-100 rounded-0 bg-white">
                                                    <i class="fas fa-eye eye-icon-pass"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label for="keterangan" class="col-form-label">Keterangan:</label>
                                        <input id="keterangan" type="text" class="form-control" name="keterangan" value="{{ $data->keterangan }}">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="col-form-label">Status:</label> <br>
                                        <div class="input-group">
                                            <input type="radio" id="true" name="status" value="true" <?php echo $data->status == 'true' ? 'checked' : ''; ?>>
                                            <label for="true" class="my-auto ml-2 mr-5">Active</label>

                                            <input type="radio" id="false" name="status" value="false" <?php echo $data->status == 'false' ? 'checked' : ''; ?>>
                                            <label for="false" class="my-auto ml-2">Inactive</label>
                                        </div>
                                    </div>
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
