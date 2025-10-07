@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid col-md-11 col-12">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h4 class="m-0">Create Post</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}"> Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('post.show') }}"> Posts</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>

            </div>
        </div>
    </div>
</div>


<section class="content">
    <div class="container-fluid col-md-11 col-12">
        <div class="row">
            <div class="col-md-12 form-group">
                <div class="card card-primary">
                    <div class="card-header border border-dark">
                        <label class="card-title">
                            Create Post
                        </label>
                    </div>
                    <div class="table-responsive">
                        <form id="form" action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body border border-dark">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="author" class="col-form-label">Author:</label>
                                            <select id="user" name="user_id" class="form-control" required>
                                                @if (Auth::user()->role_id == 3)
                                                <option value="{{ Auth::user()->id }}">{{ Auth::user()->name }}</option>
                                                @else
                                                <option value="">-- Select Author --</option>
                                                @foreach ($user as $row)
                                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                                                @endforeach
                                                @endif
                                            </select>

                                            <label for="category" class="col-form-label mt-2">Category:</label>
                                            <select id="category" name="sub_category_id" class="form-control" required>
                                                <option value="">-- Select Category --</option>
                                                @foreach ($category as $row)
                                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                                                @endforeach
                                            </select>

                                            <label for="tag" class="col-form-label mt-2">Tag:</label>
                                            <select id="tags" name="tags[]" class="form-control tags" multiple required>
                                                <option value="">-- Select Tag --</option>
                                                @foreach ($tag as $row)
                                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                                                @endforeach
                                            </select>


                                            <label for="tag" class="col-form-label mt-2">Thumbnail:</label>
                                            <img id="modal-foto" src="https://cdn-icons-png.flaticon.com/128/8832/8832608.png" alt="Thumbnail" class="img-fluid form-control h-100">

                                            <div class="btn btn-warning btn-block btn-sm mt-1 btn-file border-dark">
                                                <i class="fas fa-paperclip"></i> Upload Foto
                                                <input type="file" name="foto" class="previewImg" data-preview="modal-foto" accept="image/*">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-8 col-12">
                                        <div class="form-group">
                                            <label for="title" class="col-form-label">Title:</label>
                                            <textarea id="title" type="text" class="form-control" name="title" rows=""></textarea>

                                            <label for="content" class="col-form-label mt-2">Content:</label>
                                            <textarea id="content" type="text" class="form-control" name="content"></textarea>
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

@section('js')
<script>
    $('#user').select2()
    $('#category').select2()
    $('#content').summernote({
        height: 600,
        callbacks: {
            onImageUpload: function(files) {
                uploadImage(files[0]);
            }
        }
    });

    $('#tags').select2({
        placeholder: "Pilih atau tambah tag",
        tags: true,
        tokenSeparators: [',', ' '],
        width: '100%'
    });

    function uploadImage(file) {
        let data = new FormData();
        data.append("file", file);
        data.append("_token", "{{ csrf_token() }}");

        $.ajax({
            url: "{{ route('post.upload') }}",
            type: "POST",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(url) {
                $('#content').summernote("insertImage", url);
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }
</script>
@endsection
@endsection
