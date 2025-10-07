@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h4 class="m-0">Posts</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard') }}"> Dashboard</a></li>
                    <li class="breadcrumb-item active">Posts</li>
                </ol>

            </div>
        </div>
    </div>
</div>


<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 form-group">
                <div class="card card-primary">
                    <div class="card-header">
                        <label class="card-title">
                            Posts
                        </label>

                        <div class="card-tools">
                            <a href="" class="btn btn-default btn-sm text-dark" data-toggle="modal" data-target="#filter">
                                <i class="fas fa-filter"></i> Filter
                            </a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <div class="card-body">
                            <table id="table-data" class="table table-bordered text-center">
                                <thead class="text-uppercase text-center">
                                    <tr>
                                        <th style="width: 0%;">No</th>
                                        <th style="width: 10%;">Action</th>
                                        <th>Category</th>
                                        <th>Title</th>
                                        <th>Slug</th>
                                        <th>Views</th>
                                        <th>Author</th>
                                        <th>Status</th>
                                        <th>Thumbnail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($data == 0)
                                    <tr class="text-center">
                                        <td colspan="9">No data available in table</td>
                                    </tr>
                                    @else
                                    <tr>
                                        <td colspan="9">Processing ...</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Filter -->
<div class="modal fade" id="filter" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-filter"></i> Filter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="GET" action="{{ route('post.show') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-form-label">Category</label>
                        <select name="category_id" class="form-control">
                            <option value="">-- Select Category --</option>
                            @foreach ($category as $row)
                            <option value="{{ $row->id }}" <?php echo $row->id == $selectCategory ? 'selected' : ''; ?>>
                                {{ $row->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">Author</label>
                        <select name="user_id" class="form-control">
                            <option value="">-- Select Author --</option>
                            @foreach ($user as $row)
                            <option value="{{ $row->id }}" <?php echo $row->id == $selectUser ? 'selected' : ''; ?>>
                                {{ $row->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">Status</label>
                        <select name="status_id" class="form-control">
                            <option value="">-- Select Status --</option>
                            <option value="draft" <?php echo $selectStatus == 'draft' ? 'selected' : ''; ?>>Draft</option>
                            <option value="review" <?php echo $selectStatus == 'review' ? 'selected' : ''; ?>>Review</option>
                            <option value="published" <?php echo $selectStatus == 'published' ? 'selected' : ''; ?>>Published</option>
                            <option value="scheduled" <?php echo $selectStatus == 'scheduled' ? 'selected' : ''; ?>>Scheduled</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('post.show') }}" class="btn btn-danger btn-sm">
                        <i class="fas fa-undo"></i> Refresh
                    </a>
                    <button class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Search</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="createModal" aria-labelledby="createModal" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModal">Create</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form" action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-md-12 mb-2">
                            <label for="name" class="col-form-label">Name:</label>
                            <input id="name" type="text" class="form-control" name="name" required>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="slug" class="col-form-label">Slug:</label>
                            <input id="slug" type="text" class="form-control" name="slug" required>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="description" class="col-form-label">Description:</label>
                            <textarea id="description" type="text" class="form-control" name="description"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="confirmSubmit(event, 'form')">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('js')
<script>
    $(document).ready(function() {

        let category = $('[name="category_id"]').val();
        let user = $('[name="user_id"]').val();
        let status = $('[name="status_id"]').val();
        let role = '{{ Auth::user()->role_id }}';

        loadTable(category, user, status);

        function loadTable(category, user, status) {
            $.ajax({
                url: `{{ route('post.select') }}`,
                method: 'GET',
                data: {
                    category: category,
                    user: user,
                    status: status
                },
                dataType: 'json',
                success: function(response) {
                    let tbody = $('.table tbody');
                    tbody.empty();

                    if (response.message) {
                        tbody.append(`
                        <tr>
                            <td colspan="9">${response.message}</td>
                        </tr>
                    `);
                    } else {
                        // Jika ada data
                        $.each(response, function(index, item) {
                            let actionButton = '';
                            let deleteUrl = "{{ route('tag.delete', ':id') }}".replace(':id', item.id);
                            actionButton = `
                                <a href="#" class="btn btn-default btn-xs bg-danger rounded border-dark"
                                onclick="confirmRemove(event, '${deleteUrl}')">
                                    <i class="fas fa-trash-alt p-1" style="font-size: 12px;"></i>
                                </a>
                             `;
                            tbody.append(`
                                <tr>
                                    <td class="align-middle">${item.no}</td>
                                    <td class="align-middle">${item.aksi}</td>
                                    <td class="align-middle">${item.category}</td>
                                    <td class="align-middle">${item.title}</td>
                                    <td class="align-middle">${item.slug}</td>
                                    <td class="align-middle">${item.views}</td>
                                    <td class="align-middle">${item.user}</td>
                                    <td class="align-middle">${item.status}</td>
                                    <td class="align-middle">${item.thumbnail}</td>
                                </tr>
                            `);
                        });

                        $("#table-data").DataTable({
                            "responsive": false,
                            "lengthChange": true,
                            "autoWidth": false,
                            "info": true,
                            "paging": true,
                            "searching": true,
                            buttons: [{
                                extend: 'pdf',
                                text: ' PDF',
                                pageSize: 'A4',
                                className: 'bg-danger',
                                title: 'show',
                                exportOptions: {
                                    columns: [0, 2, 3, 4, 5],
                                },
                            }, {
                                extend: 'excel',
                                text: ' Excel',
                                className: 'bg-success',
                                title: 'show',
                                exportOptions: {
                                    columns: [0, 2, 3, 4, 5],
                                },

                            }, ((role == 1 || role == 3) ? [{
                                text: ' Create',
                                className: 'bg-primary',
                                action: function(e, dt, button, config) {
                                    window.location.href = `{{ route('post.create') }}`.replace(':form', form)
                                }
                            }] : []),
                        ],
                            "bDestroy": true
                        }).buttons().container().appendTo('#table-data_wrapper .col-md-6:eq(0)');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        }
    });
</script>
@endsection
@endsection
