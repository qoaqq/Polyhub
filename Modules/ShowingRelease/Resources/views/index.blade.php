@extends('Backend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="d-md-flex justify-content-between mb-9">
                        <div class="mb-9 mb-md-0">
                            <h5 class="card-title">{{ $title }}</h5>
                        </div>
                        <div class="d-flex align-items-center">
                            <form id="filter-form" class="position-relative me-3 w-50" method="GET">
                                <select name="movie_id" class="form-select" onchange="this.form.submit()">
                                    <option value="">All Movies</option>
                                    @foreach ($movies as $movie)
                                        <option value="{{ $movie->id }}" @if(request('movie_id') == $movie->id) selected @endif>{{ $movie->name }}</option>
                                    @endforeach
                                </select>
                            </form>
                            <form class="position-relative me-3 w-50" method="GET">
                                <input type="text" class="form-control search-chat py-2 ps-5" id="text-srh" name="search"
                                placeholder="Search" value="{{ request()->get('search') }}">
                                <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                            </form>
                            <div class="dropdown">
                                <a href="#" class="btn border shadow-none px-3" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-dots-vertical fs-5"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3" href="{{ route('showingrelease.create') }}"><i
                                                class="fs-4 ti ti-plus"></i>Add</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive overflow-x-auto latest-reviews-table">
                        <table class="table mb-0 align-middle text-nowrap table-bordered">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th>Movie</th>
                                    <th>Room</th>
                                    <th>Time</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list as $showingRelease)
                                    <tr>
                                        <td>
                                            <div class="ms-3 product-title">
                                                <h6 class="fs-4 mb-0 text-truncate-2">{{ $showingRelease->movie->name }}</h6>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center text-truncate">
                                                <h6 class="mb-0 fw-light">{{ $showingRelease->room->name }}</h6>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center text-truncate">
                                                <h6 class="mb-0 fw-light">{{ \Carbon\Carbon::parse($showingRelease->time_release)->format('H:i')}}</h6>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center text-truncate">
                                                <h6 class="mb-0 fw-light">{{ date('d/m/Y', strtotime($showingRelease->date_release)) }}</h6>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="dropdown dropstart">
                                                <a href="#" class="text-muted " id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="ti ti-dots-vertical fs-5"></i>
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-3" href="{{ route('showingrelease.show',$showingRelease->id) }}"><i
                                                                class="fs-4 ti ti-plus"></i>Detail</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-3" href="{{ route('showingrelease.edit', $showingRelease->id) }}"><i
                                                                class="fs-4 ti ti-edit"></i>Edit</a>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('showingrelease.destroy', $showingRelease->id) }}" method="post" onsubmit="return confirm('Bạn chắc muốn xóa')">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" class="dropdown-item d-flex align-items-center gap-3">
                                                                <i class="fs-4 ti ti-trash"></i>Delete
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-4">
                        <!-- Hiển thị phân trang và giữ nguyên các tham số tìm kiếm và sắp xếp -->
                        {{ $list->appends(['search' => request()->get('search'), 'sort' => request()->get('sort'), 'direction' => request()->get('direction'), 'movie_id' => request()->get('movie_id')])->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function sortTable(column) {
            const urlParams = new URLSearchParams(window.location.search);
            let direction = urlParams.get('direction') === 'asc' ? 'desc' : 'asc';

            urlParams.set('sort', column);
            urlParams.set('direction', direction);

            window.location.href = window.location.pathname + '?' + urlParams.toString();
        }
    </script>
@endsection
