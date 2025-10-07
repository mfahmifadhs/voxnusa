@extends('layouts.app')

@section('content')

<!-- Main content -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="font-weight-bold mb-4 text-capitalize">
                            Halo, {{ ucfirst(strtolower(Auth::user()->name)) }}
                        </h4>
                    </div>

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="info-box border border-dark">
                                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-newspaper"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Posts</span>
                                        <span class="info-box-number">
                                            {{ Auth::user()->post->count() }}
                                            <small>post</small>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="info-box mb-3 border border-dark">
                                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-comments"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Comment</span>
                                        <span class="info-box-number">0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <a href="{{ route('post.create') }}" class="btn btn-primary btn-block fw-bold">
                                <i class="fas fa-plus-circle"></i> Create New Post
                            </a>
                        </div>

                        <div class="form-group">
                            <div class="card card-widget widget-user-2 border border-dark">
                                <div class="bg-primary p-3">
                                    <h6 class="my-auto font-weight-bold">
                                        <i class="nav-icon fas fa-newspaper mr-2"></i> My Posts
                                    </h6>
                                </div>
                                <div class="card-body p-0">
                                    <ul class="nav flex-column font-weight-bold">
                                        <li class="nav-item p-3">
                                            <span class="float-left">
                                                <i class="fas fa-file-signature"></i> Draft
                                            </span>
                                            <span class="float-right">
                                                {{ Auth::user()->post->where('status', 'draft')->count() }}
                                                post
                                            </span>
                                        </li>
                                        <li class="nav-item p-3 text-main">
                                            <span class="float-left">
                                                <i class="fas fa-clock"></i> Review
                                            </span>
                                            <span class="float-right">
                                                {{ Auth::user()->post->where('status', 'review')->count() }}
                                                post
                                            </span>
                                        </li>
                                        <li class="nav-item p-3 text-main">
                                            <span class="float-left">
                                                <i class="fas fa-check-circle"></i> Published
                                            </span>
                                            <span class="float-right">
                                                {{ Auth::user()->post->where('status', 'published')->count() }}
                                                post
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 col-12">
                        <div class="card border border-dark">
                            <div class="card-body">
                                <label class="text-secondary text-sm">
                                    <i class="fas fa-dashboard"></i>
                                    Total Visitors
                                </label>
                                <canvas id="visitorChart"></canvas>
                            </div>
                        </div>

                        <div class="card border border-dark">
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
        </div>
    </div>
</section>
@endsection

@section('js')
<script>
    $(function() {
        const ctx = document.getElementById('visitorChart').getContext('2d');
        const visitorChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($visitorData->pluck('date')); ?>,
                datasets: [{
                    label: 'Pengunjung',
                    data: <?php echo json_encode($visitorData->pluck('total')->map(fn($v) => (int) $v)); ?>,
                    borderWidth: 2,
                    borderColor: '#4e73df',
                    backgroundColor: 'rgba(78, 115, 223, 0.1)',
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                scales: {
                    y: {
                        ticks: {
                            callback: function(value) {
                                return Number.isInteger(value) ? value : null;
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + parseInt(context.raw);
                            }
                        }
                    }
                }
            }
        });
    });
</script>

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
                            }] : []), ],
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
