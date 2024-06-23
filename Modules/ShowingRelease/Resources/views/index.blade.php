
@extends('Backend.layouts.app')
@section('content')
@if (session('success'))
<script>
    window.onload = function() {
        alert("{{ session('success') }}");
    }
</script>
@endif
    <div class="row">
        <div class="col-12">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="d-md-flex justify-content-between mb-9">
                        <div class="mb-9 mb-md-0">
                            <h5 class="card-title">ShowingRelease</h5>
                            <form id="search-form" class="position-relative me-3 w-100" action="{{ route('showingrelease.index') }}" method="GET">
                                <!-- Sử dụng biểu tượng hoặc icon filter -->
                                <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#filterModal">
                                    <i class="ti ti-filter"></i> Filter
                                </button>
                            
                                <!-- Modal -->
                                <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="filterModalLabel">Filter by Movie</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Thêm dropdown menu cho chọn phim -->
                                                <select name="movie_id" class="form-select" aria-label="Filter by Movie">
                                                    <option value="">All Movies</option>
                                                    @foreach ($movies as $movie)
                                                        <option value="{{ $movie->id }}" {{ request('movie_id') == $movie->id ? 'selected' : '' }}>{{ $movie->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Apply</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>         
                        </div>
                        <div class="d-flex align-items-center">
                            <form id="search-form" class="position-relative me-3 w-100" action="{{ route('showingrelease.index') }}" method="GET">
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
                        <table class="table mb-0 align-middle text-nowrap">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th></th>
                                    <th>Movie</th>
                                    <th>Room</th>
                                    <th>Time</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($list as $show)
                                <tr>
                                    <td><input type="checkbox" name="ticket_id[]" value="{{ $show->id }}"></td>
                                    <td><h6 class="fs-4 mb-0 text-truncate-2">{{ $show->movie->name }}</h6></td>
                                    <td><h6 class="fs-4 mb-0 text-truncate-2">{{ $show->room->name }}</h6></td>
                                    <td><h6 class="fs-4 mb-0 text-truncate-2">{{ \Carbon\Carbon::parse($show->time_release)->format('H:i')}}</h6></td>
                                    <td><h6 class="fs-4 mb-0 text-truncate-2">{{ date('d/m/Y', strtotime($show->date_release)) }}</h6></td>
                                    <td>
                                        <div class="dropdown dropstart">
                                            <a href="#" class="text-muted " id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="ti ti-dots-vertical fs-5"></i>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center gap-3" href="{{ route('showingrelease.show',$show->id) }}"><i
                                                            class="fs-4 ti ti-plus"></i>Detail</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center gap-3" href="{{ route('showingrelease.edit', $show->id) }}"><i
                                                            class="fs-4 ti ti-edit"></i>Edit</a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('showingrelease.destroy', $show->id) }}" method="post" onsubmit="return confirm('Bạn chắc muốn xóa')">
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
                    <div class="d-flex align-items-center justify-content-between mt-10">
                        <div class="mt-3">
                            {{$list->links('vendor.pagination.bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('text-srh').addEventListener('input', function () {
           if (this.value === '') {
               // Nếu ô tìm kiếm bị xóa, gửi form để tải lại trang index
               document.getElementById('search-form').submit();
           }
       });
   </script>
@endsection

