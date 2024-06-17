@extends('Backend.layouts.app')

@section('content')
<div class="container">
    <h1>Edit Ticket</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <form action="{{ route('ticket.update', $ticket->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group mb-3">
                    <label for="movie_id">Phim</label>
                    <select name="movie_id" id="movie_id" class="form-control select-movie mt-2">
                        <option value="0">--Chọn phim--</option>
                        @foreach($movie as $id => $name)
                            <option value="{{ $id }}" {{ $ticket->movie_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="seat_id">Ghế</label>
                    <select name="seat_id" id="seat_id" class="form-control select-movie mt-2">
                        <option value="0">--Chọn ghế--</option>
                        @foreach($seat as $id => $name)
                            <option value="{{ $id }}" {{ $ticket->seat_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="room_id">Phòng</label>
                    <select name="room_id" id="room_id" class="form-control select-movie mt-2">
                        <option value="0">--Chọn phòng--</option>
                        @foreach($room as $id => $name)
                            <option value="{{ $id }}" {{ $ticket->room_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="cinema_id">Rạp</label>
                    <select name="cinema_id" id="cinema_id" class="form-control select-movie mt-2">
                        <option value="0">--Chọn rạp--</option>
                        @foreach($cinema as $id => $name)
                            <option value="{{ $id }}" {{ $ticket->cinema_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="showing_release_id">Suất chiếu</label>
                    <select name="showing_release_id" id="showing_release_id" class="form-control select-movie mt-2">
                        <option value="0">--Chọn suất chiếu--</option>
                        @foreach($show as $id => $name)
                            <option value="{{ $id }}" {{ $ticket->showing_release_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="time_start">Giờ chiếu</label>
                    <input type="time" name="time_start" id="time_start" class="form-control mt-2" value="{{ \Carbon\Carbon::parse($ticket->time_start)->format('H:i') }}">
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="{{ route('ticket.index') }}" class="btn btn-secondary">Quay lại</a>
            </form>
        </div>
    </div>
</div>
@endsection

