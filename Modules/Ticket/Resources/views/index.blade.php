
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
                            <h5 class="card-title">Ticket</h5>
                            <form id="filter-form" class="position-relative me-3" action="{{ route('ticket.index') }}" method="GET">
                                <!-- Sử dụng biểu tượng hoặc icon filter -->
                                <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#filterModal">
                                    <i class="ti ti-filter"></i> Filter
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="filterModalLabel">Filter by Showing Release</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Thêm dropdown menu cho chọn showing release -->
                                                <select name="showing_release_id" class="form-select" aria-label="Filter by Showing Release">
                                                    <option value="">All Showing Releases</option>
                                                    @foreach ($showingReleases as $showingRelease)
                                                        <option value="{{ $showingRelease->id }}" {{ request('showing_release_id') == $showingRelease->id ? 'selected' : '' }}>
                                                            {{ $showingRelease->time_release }} - {{ date('d/m/Y', strtotime($showingRelease->date_release)) }}
                                                        </option>
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
                            <form id="search-form" class="position-relative me-3 w-100" action="{{ route('ticket.index') }}" method="GET">
                                <input type="text" class="form-control search-chat py-2 ps-5" id="text-srh" name="search"
                                       placeholder="Search (e.g., movie:Inception, seat:A1)" value="{{ request()->get('search') }}">
                                <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                            </form>
                            <div class="dropdown">
                                <a href="#" class="btn border shadow-none px-3" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-dots-vertical fs-5"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3" href="{{ route('ticket.create') }}"><i class="fs-4 ti ti-plus"></i>Add</a>
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
                                    <th>Seat</th>
                                    <th>Room</th>
                                    <th>Cinema</th>
                                    <th>Showing Release</th>
                                    <th>Time</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($list as $ticket)
                    <tr>
                        <td><input type="checkbox" name="ticket_id[]" value="{{ $ticket->id }}"></td>
                        <td><h6 class="fs-4 mb-0 text-truncate-2">{{ $ticket->movie->name }}</h6></td>
                        <td><h6 class="fs-4 mb-0 text-truncate-2">{{ $ticket->seat->column }}{{$ticket->seat->row}}</h6></td>
                        <td><h6 class="fs-4 mb-0 text-truncate-2">{{ $ticket->room->name }}</h6></td>
                        <td><h6 class="fs-4 mb-0 text-truncate-2">{{ $ticket->cinema->name }}</h6></td>
                        <td><h6 class="fs-4 mb-0 text-truncate-2">{{ $ticket->showingrelease->time_release }}</h6></td>
                        <td><h6 class="fs-4 mb-0 text-truncate-2">{{ \Carbon\Carbon::parse($ticket->time_start)->format('H:i') }}</h6></td>         
                        <td>
                            <div class="dropdown dropstart">
                                <a href="#" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-dots-vertical fs-5"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3" href="{{ route('ticket.show', $ticket->id) }}"><i
                                                class="fs-4 ti ti-plus"></i>Detail</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3" href="{{ route('ticket.edit', $ticket->id) }}"><i
                                                class="fs-4 ti ti-edit"></i>Edit</a>
                                    </li>
                                    <li>
                                        <form action="{{ route('ticket.destroy', $ticket->id) }}" method="post" onsubmit="return confirm('Bạn chắc muốn xóa')">
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


