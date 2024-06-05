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
    <section class="container">
        <div class="card">
            <div class="card-body">
                <h5 class="mb-3">Add new seat</h5>
                <form action="" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col input-group">
                            <span class="input-group-text">name</span>
                           <input class="form-control" type="text" name="name">
                        </div>
                        <div class="col input-group">
                            <span class="input-group-text">Cinema</span>
                            <select name="cinema_id" class="form-select" id="inputGroupSelect04">
                               @foreach ($cinemas as $cinema)
                                   <option value="{{ $cinema->id }}">{{ $cinema->name }}</option>
                               @endforeach
                            </select>
                        </div>
                        <div class="col-12 my-4">
                            <div class="d-md-flex align-items-center">
                                <div class="ms-auto mt-3 mt-md-0">
                                    <button type="submit" class="btn btn-primary  rounded-pill px-4">
                                        <div class="d-flex align-items-center">
                                            Submit
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($errors->any())
                        <ul class="errors">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </form>
            </div>
        </div>
    </section>
    {{-- content end --}}
@endsection
