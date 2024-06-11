@extends('Backend.layouts.app')

@section('content')

<div class="container">
    <h1>Detail Showing Release</h1>
    <div class="card">
        <div class="card-body">
            <div class="form-group mb-3">
                <label for="movie_id">Phim</label>
                <input type="text" id="movie_id" class="form-control mt-2" value="{{ $showingRelease->movie->name }}" readonly>
            </div>
            <div class="form-group mb-3">
                <label for="seat_id">Ghế</label>
                <input type="text" id="seat_id" class="form-control mt-2" value="{{ $showingRelease->seat->column }}" readonly>
            </div>
            <div class="form-group mb-3">
                <label for="room_id">Phòng</label>
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
@endsection

