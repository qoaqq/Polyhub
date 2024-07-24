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
<div class="container">
    <h1>Detail Showing Release</h1>
    <div class="card">
        <div class="card-body">
            <div class="form-group mb-3">
                <label for="movie_id">Movies</label>
                <input type="text" id="movie_id" class="form-control mt-2" value="{{ $showingRelease->movie->name }}" readonly>
            </div>
            <div class="form-group mb-3">
                <label for="room_id">Room</label>
                <input type="text" id="room_id" class="form-control mt-2" value="{{ $showingRelease->room->name }}" readonly>
            </div>
            <div class="form-group mb-3">
                <label for="date_release">Date</label>
                <input type="text" id="date_release" class="form-control mt-2" value="{{ $showingRelease->date_release}}" readonly>
            </div>
            <div class="form-group mb-3">
                <label for="time_release">Time</label>
                <input type="text" id="time_release" class="form-control mt-2" value="{{ $showingRelease->time_release}}" readonly>
            </div>
            <a href="{{ route('showingrelease.index') }}" class="btn btn-secondary">Quay lại</a>
        </div>
    </div>
</div>

 {{-- list seats --}}
 <section class="my-5">
    <div class="container">
        <div style="width: 70%" class="mx-auto">
            <div class="row row-cols-12 g-lg-3">
                @foreach ($groupedSeats as $rows)
                    @foreach ($rows as $row)
                        <div class="col-1">
                            <div
                                class="p-1 border {{ $row->seat->type == 1 ? 'border-success' : '' }} {{ $row->seat->type == 2 ? 'border-danger' : '' }} {{ $row->seat->type == 3 ? 'bg-danger' : '' }} {{ $row->status == 1 ? 'placed' : '' }}">
                                {{ $row->seat->column }}{{ $row->seat->row }}
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
                    <div class="border bg-secondary iconlist"></div>   <span>Placed</span>
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

