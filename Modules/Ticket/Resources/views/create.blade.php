@extends('Backend.layouts.app')

@section('content')
<div class="container">
    <h1>Create</h1>
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
            <form action="{{ route('ticket.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="movie_id">Movies</label>
                    <select name="movie_id" id="movie_id" class="form-control select-movie mt-2">
                        <option value="0">--Select movies--</option>
                        @foreach($movie as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="seat_id">Seat</label>
                    <select name="seat_id" id="seat_id" class="form-control select-movie mt-2">
                        <option value="0">--Select seat--</option>
                        @foreach($seat as $seat)
                            <option value="{{ $seat->id }}">{{ $seat->column }}{{ $seat->row }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="room_id">Room</label>
                    <select name="room_id" id="room_id" class="form-control select-movie mt-2">
                        <option value="0">--Select room--</option>
                        @foreach($room as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="cinema_id">Cinema</label>
                    <select name="cinema_id" id="cinema_id" class="form-control select-movie mt-2">
                        <option value="0">--Select cinema--</option>
                        @foreach($cinema as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="showing_release_id">ShowingRelease</label>
                    <select name="showing_release_id" id="showing_release_id" class="form-control select-movie mt-2">
                        <option value="0">--Select showingRelease--</option>
                        @foreach($show as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="time_start">Time</label>
                    <input type="time" name="time_start" id="time_start" class="form-control mt-2">
                </div>
                <button type="submit" class="btn btn-primary mt-2">Create</button>
                <a href="{{ route('ticket.index') }}" class="btn btn-secondary mt-2">Back</a>
            </form>
        </div>
    </div>
</div>
@endsection

