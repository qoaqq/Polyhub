@extends('Backend.layouts.app')

@section('content')
    {{-- nav start --}}
    <div class="card shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body d-flex align-items-center justify-content-between p-4">
            <h4 class="fw-semibold mb-0">Add new</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="../dark/index.html">Home</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">seat</li>
                </ol>
            </nav>
        </div>
    </div>
    {{-- nav end --}}

    <section>
        <div class="table-responsive">
            <table class="table">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Rate point</th>
                        <th>city</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cinemas as $cinema)
                    <tr>
                        <td>{{ $cinema->id }}</td>
                        <td>{{ $cinema->name }}</td>
                        <td>{{ $cinema->rate_point }}</td>
                        <td>{{ $cinema->city->name }}</td>
                        <td>
                            <div class="dropdown dropstart">
                              <a href="#" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-dots-vertical fs-6"></i>
                              </a>
                              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li>
                                  <a class="dropdown-item d-flex align-items-center gap-3" href="{{ route('admin.cinema.create') }}"><i class="fs-4 ti ti-plus"></i>Add</a>
                                </li>
                                <li>
                                  <a class="dropdown-item d-flex align-items-center gap-3" href="#"><i class="fs-4 ti ti-edit"></i>Edit</a>
                                </li>
                                <li>
                                  <a class="dropdown-item d-flex align-items-center gap-3" href="{{ route('admin.cinema.delete',[$cinema->id]) }}"><i class="fs-4 ti ti-trash"></i>Delete</a>
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
              {{ $cinemas->links('cinema::layouts.pagination')}}
            </div>
    </section>
@endsection
