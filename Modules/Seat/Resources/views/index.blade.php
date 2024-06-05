@extends('Backend.layouts.app')

@section('content')
    {{-- nav start --}}
    <div class="card shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body d-flex align-items-center justify-content-between p-4">
            <h4 class="fw-semibold mb-0">List Seats</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="../dark/index.html">Home</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">Seat</li>
                </ol>
            </nav>
        </div>
    </div>
    {{-- nav end --}}

    <section>
        <div class="container">
            <div class="row row-cols-12 g-lg-3">
                @foreach ($seats as $rows)
                    @foreach ($rows as $row)
                        <div class="col-1">
                            <div class="p-1 border {{ $row->type == 1 ? "border-success" : "" }} {{ $row->type == 2 ? "border-danger" : "" }} {{ $row->type == 3 ? "bg-danger" : "" }}">
                                {{ $row->column }}{{ $row->row }}
                                <span class="dropdown dropstart">
                                    <a href="#" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                      <i class="ti ti-dots-vertical fs-6"></i>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                      <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3" href="{{ route('admin.seat.create') }}"><i class="fs-4 ti ti-plus"></i>Add</a>
                                      </li>
                                      <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3" href="{{ route('admin.seat.detail', [$row->id]) }}"><i class="fs-4 ti ti-edit"></i>detail</a>
                                      </li>
                                      <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3" href="{{ route('admin.seat.delete', [$row->id]) }}"><i class="fs-4 ti ti-trash"></i>Delete</a>
                                      </li>
                                    </ul>
                                  </span>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </section>
@endsection
