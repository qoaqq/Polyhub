@extends('Backend.layouts.app')

@section('content')
    {{-- nav start --}}
    <div class="card shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body d-flex align-items-center justify-content-between p-4">
            <h4 class="fw-semibold mb-0">Detail city</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="{{ route('admin.city.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">city</li>
                </ol>
            </nav>
        </div>
    </div>
    {{-- nav end --}}

    <section class="container">
        <div class="my-5">
            <h2>Name : {{ $city->name }}</h2>
        </div>
    </section>
    {{-- content start --}}
    <section>
        {{-- table cinemas start --}}
        <div class="my-3">
            <button type="button" class="btn btn-rounded btn-outline-success">
                Add new cinema for this city
            </button>
        </div>
        <div class="table-responsive mb-4">
            <h5>List cinemas of city</h5>
            <table class="table border text-nowrap mb-0 align-middle">
                <thead class="text-dark fs-4">
                    <tr>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Name</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Rate point</h6>
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($city->cinemas as $cinema)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="ms-3">
                                        <h6 class="fs-4 fw-semibold mb-0">{{ $cinema->name }}</h6>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <span
                                        class="badge text-bg-primary rounded-3 fw-semibold fs-2">{{ $cinema->rate_point }}</span>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('admin.cinema.show', [$cinema->id]) }}" class="text-muted">
                                    <i class="ti ti-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- table cinemas end --}}
</section {{-- content end --}} @endsection
