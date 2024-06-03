@extends('Backend.layouts.app')

@section('content')
    {{-- nav start --}}
    <div class="card shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body d-flex align-items-center justify-content-between p-4">
            <h4 class="fw-semibold mb-0">Chart Apex Radial</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="../dark/index.html">Home</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">Chart Apex Radial</li>
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
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </section>
@endsection
