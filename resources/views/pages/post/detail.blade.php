@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid col-md-10 col-12">
        <div class="row mb-2">
            <div class="col-sm-11 col-12 my-auto">
                <h4 class="m-0">{{ $data->title }}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}"> Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('post.show') }}"> Posts</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </div>
            <div class="col-sm-1 col-12 mt-1">
                @if ($data->status == 'draft' && ($data->user_id == Auth::user()->id))
                <a href="#" class="btn btn-primary border-dark btn-block btn-sm text-xs" onclick="confirmLink(event, `{{ route('post.review', $data->id) }}`)">
                    <i class="fas fa-paper-plane"></i> Review
                </a>
                @endif

                @if (in_array(Auth::user()->role_id, [1, 3]) && $data->status != 'review')
                <a href="{{ route('post.edit', $data->id) }}" class="btn btn-warning border-dark btn-block btn-sm text-xs">
                    <i class="fas fa-edit"></i> Edit
                </a>
                @endif

                <!-- Review -->
                @if (Auth::user()->role_id == 2 && $data->status == 'review')
                <label class="text-xs">Review : </label>
                <form id="form-true" action="{{ route('post.verif', $data->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="status" value="published">
                    <input type="hidden" name="notes" id="notes">
                    <button type="submit" class="btn btn-success border-dark btn-block btn-sm text-xs mb-2" onclick="confirmTrue(event)">
                        <i class="fas fa-check-circle"></i> Agree
                    </button>
                </form>

                <form id="form-false" action="{{ route('post.verif', $data->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="status" value="draft">
                    <input type="hidden" name="notes" id="notes-false">
                    <button type="submit" class="btn btn-danger border-dark btn-block btn-sm text-xs mb-2" onclick="confirmFalse(event)">
                        <i class="fas fa-times-circle"></i> Reject
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>


<section class="content">
    <div class="container-fluid col-md-10 col-12">
        <div class="row">
            <div class="col-md-12 form-group">
                <div class="card card-primary">
                    <div class="card-header border border-dark">
                        <label class="card-title">
                            {{ $data->title }}
                        </label>
                    </div>
                    <div class="table-responsive">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    @if ($data->thumbnail)
                                    <a href="#" data-toggle="modal" data-target="#zoom">
                                        <img src="{{ asset('dist/img/thumbnail/'. $data->thumbnail) }}" alt="Thumbnail" class="img-fluid my-2">
                                    </a>
                                    @else
                                    <img src="https://cdn-icons-png.flaticon.com/128/8832/8832608.png" alt="Thumbnail" class="img-fluid form-control my-2" style="height: 15vh;">
                                    @endif

                                    <div class="form-group small">
                                        <label for="">Category:</label>
                                        <h6>{{ $data->category->name }}</h6>
                                    </div>

                                    <div class="form-group small">
                                        <label for="">Author:</label>
                                        <h6>{{ $data->user->name }}</h6>
                                    </div>

                                    <div class="form-group small">
                                        <label for="">Publish Date:</label>
                                        <h6>{{ $data->publised_at }}</h6>
                                    </div>

                                    <div class="form-group small">
                                        <label for="">Status:</label>
                                        @if ($data->status == 'draft' || $data->status == 'review')
                                        <h6><span class="badge badge-warning">{{ $data->status }}</span></h6>
                                        @else
                                        <h6><span class="badge badge-success">{{ $data->status }}</span></h6>
                                        @endif
                                    </div>

                                    <div class="form-group small">
                                        <label for="">Total Views:</label>
                                        <h6>{{ $data->views }} views</h6>
                                    </div>

                                    <div class="form-group small">
                                        <label for="">Tags:</label>
                                        <h6>
                                            @foreach($data->tags as $row)
                                            <span class="badge badge-warning">{{ $row->name }}</span>
                                            @endforeach
                                        </h6>
                                    </div>

                                    @if ($data->reviewer_id)
                                    <div class="form-group small">
                                        <label for="">Reviewer:</label>
                                        <h6>{{ $data->reviewer->name }}</h6>
                                    </div>
                                    @endif

                                    @if ($data->notes)
                                    <div class="form-group small">
                                        <label for="">Notes:</label>
                                        <h6>{{ $data->notes }}</h6>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                            <h4 class="" for="title"><b>{{ $data->title }}</b></h4>
                                        </div>
                                        <div class="col-md-12 col-12 mt-5">
                                            <h6 for="content">{!! $data->content !!}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Zoom -->
<div class="modal fade" id="zoom" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img src="{{ asset('dist/img/thumbnail/'. $data->thumbnail) }}" alt="Thumbnail" class="img-fluid my-2 h-100" data-bs-toggle="modal" data-bs-target="#zoom">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@section('js')
<script>
    $('#user').select2()
    $('#category').select2()
    $('#content').summernote({
        height: 300,
        callbacks: {
            onImageUpload: function(files) {
                uploadImage(files[0]);
            }
        }
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

<script>
    function confirmTrue(event) {
        event.preventDefault();

        const form = document.getElementById('form-true');

        Swal.fire({
            title: 'Process',
            text: 'Agree?',
            icon: 'question',
            input: 'textarea',
            inputPlaceholder: 'Notes...',
            inputAttributes: {
                'aria-label': 'Please write notes  '
            },
            showCancelButton: true,
            confirmButtonText: 'Agree',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                const notes = result.value;

                Swal.fire({
                    title: 'Process...',
                    text: 'Please waiting.',
                    icon: 'info',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                Swal.fire({
                    title: 'Success!',
                    icon: 'success'
                });

                document.getElementById('notes').value = notes;
                form.submit();
            }
        });
    }

    function confirmFalse(event) {
        event.preventDefault();

        const form = document.getElementById('form-false');

        Swal.fire({
            title: 'Reject',
            text: '',
            icon: 'warning',
            input: 'textarea',
            inputPlaceholder: 'Notes...',
            inputAttributes: {
                'aria-label': 'Notes'
            },
            showCancelButton: true,
            confirmButtonText: 'Reject',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                const notes = result.value;

                Swal.fire({
                    title: 'Process...',
                    text: 'Please waiting.',
                    icon: 'info',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                document.getElementById('notes-false').value = notes;
                form.submit();
            }
        });
    }
</script>
@endsection
@endsection
