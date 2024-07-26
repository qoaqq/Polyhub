@extends('Backend.layouts.app')
@section('content')
<style>
    .iconlist{
        width: 25px;
        height: 25px;
        margin-right: 10px;
        display: inline-block;
    }

    .placed{
        background-color: grey !important;
        border: 0 !important;
    }
</style>
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
                <h5 class="mb-3">Room detail</h5>
                <form action="{{ route('admin.room.update', [$room->id]) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col input-group">
                            <span class="input-group-text">name</span>
                            <input class="form-control" type="text" name="name" value="{{ $room->name }}">
                        </div>
                        <div class="col input-group">
                            <span class="input-group-text">Cinema</span>
                            <select name="cinema_id" class="form-select" id="inputGroupSelect04">
                                @foreach ($cinemas as $cinema)
                                    <option class="{{ $room->cinema_id == $cinema->id ? 'text-danger' : '' }}"
                                        value="{{ $cinema->id }}" {{ $room->cinema_id == $cinema->id ? 'selected' : '' }}>
                                        {{ $cinema->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 my-4">
                            <div class="d-md-flex align-items-center">
                                <div class="ms-auto mt-3 mt-md-0">
                                    <button type="submit" class="btn btn-primary  rounded-pill px-4">
                                        <div class="d-flex align-items-center">
                                            Update
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($errors->any())
                        <ul class="errors">
                            @foreach ($errors->all() as $error)
                                <li><span class="text-danger">{{ $error }}</span></li>
                            @endforeach
                        </ul>
                    @endif
                </form>
            </div>
        </div>
    </section>
    {{-- content end --}}

    {{-- list seats --}}
    <section class="my-5">
        <div class="container">
            <div style="width: 70%" class="mx-auto">
                <div class="row row-cols-12 g-lg-3">
                    @foreach ($seats as $rows)
                        @foreach ($rows as $row)
                            <div class="col-1">
                                <div
                                    class="p-1 border {{ $row->seat_type_id == 1 ? 'border-success' : '' }} {{ $row->seat_type_id == 2 ? 'border-danger' : '' }} {{ $row->seat_type_id == 3 ? 'bg-danger' : '' }} {{ $row->status == 1 ? 'placed' : '' }}">
                                    {{ $row->column }}{{ $row->row }}
                                    <span class="dropdown dropstart">
                                        <a href="#" class="text-muted" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ti ti-dots-vertical fs-6"></i>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center gap-3"
                                                    href="{{ route('admin.seat.detail', [$row->id]) }}"><i
                                                        class="fs-4 ti ti-edit"></i>update</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center gap-3"
                                                    href="{{ route('admin.seat.delete', [$row->id]) }}"><i
                                                        class="fs-4 ti ti-trash"></i>Delete</a>
                                            </li>
                                        </ul>
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
        {{-- type of seats --}}
        <div style="width: 40%; margin-top: 50px" class="container mx-auto">
            <div>
                <div class="row justify-content-around">
                    <div class="col-6">
                        <div class="border bg-primary iconlist"></div> <span>Checked</span>
                    </div>
                    <div class="col-6">
                        <div class="border border-success iconlist"></div> <span>Normal</span>
                    </div>
                    <div class="col-6">
                        <div class="border bg-secondary iconlist"></div>   <span>Having incident</span>
                    </div>
                    <div class="col-6">
                        <div class="border border-danger iconlist"></div> <span>VIP</span>
                    </div>
                    <div class="col-6">
                        <div class="border bg-dark iconlist"></div> <span>Cannot select</span>
                    </div>
                    <div class="col-6">
                        <div class="border bg-danger iconlist"></div> <span>Sweetbox</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- list seats end --}}
@endsection
