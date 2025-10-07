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
                                            {{ $posts->count() }}
                                            <small>post</small>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="info-box mb-3 border border-dark">
                                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Visitors</span>
                                        <span class="info-box-number">
                                            {{ $visitorData->sum('total') }}
                                            <small>visitor</small>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix hidden-md-up"></div>

                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="info-box mb-3 border border-dark">
                                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-comments"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Comment</span>
                                        <span class="info-box-number">0</span>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="info-box mb-3 border border-dark">
                                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Total User</span>
                                        <span class="info-box-number">{{ $users->count() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <div class="card card-widget widget-user-2 border border-dark">
                                <div class="bg-primary p-3">
                                    <h6 class="my-auto font-weight-bold">
                                        <i class="nav-icon fas fa-newspaper mr-2"></i> Posts
                                    </h6>
                                </div>
                                <div class="card-body p-0">
                                    <ul class="nav flex-column font-weight-bold">
                                        <li class="nav-item">
                                            <form action="{{ route('post.show') }}" method="GET">
                                                @csrf
                                                <input type="hidden" name="status_id" value="draft">
                                                <button type="submit" class="nav-link btn btn-link py-2 font-weight-bold text-left btn-block text-dark">
                                                    <span class="float-left">
                                                        <i class="fas fa-file-signature"></i> Draft
                                                    </span>
                                                    <span class="float-right">
                                                        {{ $posts->where('status', 'draft')->count() }}
                                                        usulan
                                                    </span>
                                                </button>
                                            </form>
                                        </li>
                                        <li class="nav-item">
                                            <form action="{{ route('post.show') }}" method="GET">
                                                @csrf
                                                <input type="hidden" name="status_id" value="review">
                                                <button type="submit" class="nav-link btn btn-link py-2 font-weight-bold text-left btn-block text-dark">
                                                    <span class="float-left">
                                                        <i class="fas fa-clock"></i> Review
                                                    </span>
                                                    <span class="float-right">
                                                        {{ $posts->where('status', 'review')->count() }}
                                                        usulan
                                                    </span>
                                                </button>
                                            </form>
                                        </li>
                                        <li class="nav-item">
                                            <form action="{{ route('post.show') }}" method="GET">
                                                @csrf
                                                <input type="hidden" name="status_id" value="published">
                                                <button type="submit" class="nav-link btn btn-link py-2 font-weight-bold text-left btn-block text-dark">
                                                    <span class="float-left">
                                                        <i class="fas fa-check-circle"></i> Published
                                                    </span>
                                                    <span class="float-right">
                                                        {{ $posts->where('status', 'published')->count() }}
                                                        usulan
                                                    </span>
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <table class="table table-striped text-center border border-dark text-xs">
                                <thead class="bg-primary">
                                    <tr>
                                       <td colspan="3">
                                            <b><i class="fas fa-gear"></i> Home Category</b>
                                        </td>
                                    </tr>
                                </thead>
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Category</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pages->where('title', 'home-ctg') as $row)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $row->category?->name }}</td>
                                        <td>
                                            <a href="#" data-toggle="modal" data-target="#detail-{{ $row->id }}">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <!-- Modal -->
                                            <div class="modal fade" id="detail-{{ $row->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">{{ $loop->iteration }} {{ $row->category?->name }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form id="form-{{ $row->id }}" action="{{ route('pages.update', $row->id) }}" method="POST">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <select name="category_id" class="form-control" required>
                                                                    <option value="">-- Select Category</option>
                                                                    @foreach ($category as $subRow)
                                                                    <option value="{{ $subRow->id }}" <?= $subRow->id == $row->category_id ? 'selected' : ''; ?>>
                                                                        {{ $subRow->name }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary" onclick="confirmSubmit(event, 'form-{{ $row->id }}')">Submit</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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
@endsection
@endsection
