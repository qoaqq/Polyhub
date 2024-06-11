@extends('Backend.layouts.app')

@section('content')

<div class="container">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <h1>Create</h1>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('showingrelease.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="movie_id">Phim</label>
                    <select name="movie_id" id="movie_id" class="form-control select-movie mt-2">
                        <option value="0">--Chọn phim--</option>
                        @foreach($movie as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="seat_id">Ghế</label>
                    <select name="seat_id" id="seat_id" class="form-control select-movie mt-2">
                        <option value="0">--Chọn ghế--</option>
                        @foreach($seat as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="room_id">Phòng</label>
                    <select name="room_id" id="room_id" class="form-control select-movie mt-2">
                        <option value="0">--Chọn phòng--</option>
                        @foreach($room as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="date_release">Date</label>
                    <input type="date" name="date_release" id="date_release" class="form-control mt-2">
                </div>
                <div class="form-group mb-3">
                    <label for="time_release">Time</label>
                    <input type="time" name="time_release" id="time_release" class="form-control mt-2">
                </div>
                <button type="submit" class="btn btn-primary">Create</button>
                <a href="{{ route('showingrelease.index') }}" class="btn btn-secondary">Quay lại</a>
            </form>
        </div>
    </div>
</div>
@endsection

