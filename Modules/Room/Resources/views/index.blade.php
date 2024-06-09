@extends('Backend.layouts.app')

@section('content')
    {{-- nav start --}}
    <div class="card shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body d-flex align-items-center justify-content-between p-4">
            <h4 class="fw-semibold mb-0">List room</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="../dark/index.html">Home</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">room</li>
                </ol>
            </nav>
        </div>
    </div>
    {{-- nav end --}}

    {{-- content start --}}
    <div class="my-3">
        <a href="{{ route('admin.room.create') }}"><button type="button" class="btn btn-rounded btn-outline-success">
                Add new
            </button>
        </a>
    </div>
    <section class="container">
        <div class="table-responsive mb-4">
            <table class="table border text-nowrap mb-0 align-middle">
                <thead class="text-dark fs-4">
                    <tr>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">ID</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Name</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">cinema</h6>
                        </th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rooms as $room)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="ms-3">
                                        <h6 class="fs-4 fw-semibold mb-0">{{ $room->id }}</h6>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="mb-0 fw-normal">{{ $room->name }}</p>
                            </td>
                            <td>
                                <p class="mb-0 fw-normal">{{ isset($room->cinema->name) ? $room->cinema->name : '' }}</p>
                            </td>
                            <td>
                                <div class="dropdown dropstart">
                                    <a href="#" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="ti ti-dots-vertical fs-6"></i>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="">
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-3"
                                                href="{{ route('admin.room.create') }}"><i
                                                    class="fs-4 ti ti-plus"></i>Add</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-3"
                                                href="{{ route('admin.room.detail', [$room->id]) }}"><i
                                                    class="fs-4 ti ti-edit"></i>Detail</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-3"
                                                href="{{ route('admin.room.delete', [$room->id]) }}"><i
                                                    class="fs-4 ti ti-trash"></i>Delete</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div>
            {{ $rooms->links('room::layouts.pagination') }}
        </div>
    </section>
    {{-- contrent end --}}
@endsection
