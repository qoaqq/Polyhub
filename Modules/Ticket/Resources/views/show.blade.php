@extends('Backend.layouts.app')

@section('content')
<div class="container">
    <h1>Ticket Details</h1>
    <div class="card">
        <div class="card-body">
            <div class="form-group mb-3">
                <label for="movie_id">Movies</label>
                <input type="text" id="movie_id" class="form-control mt-2" value="{{ $ticket->movie->name }}" readonly>
            </div>
            <div class="form-group mb-3">
                <label for="seat_id">Seat</label>
                <input type="text" id="seat_id" class="form-control mt-2" value="{{ $ticket->seat->column }}{{$ticket->seat->row}}" readonly>
            </div>
            <div class="form-group mb-3">
                <label for="room_id">Room</label>
                <input type="text" id="room_id" class="form-control mt-2" value="{{ $ticket->room->name }}" readonly>
            </div>
            <div class="form-group mb-3">
                <label for="cinema_id">Cinema</label>
                <input type="text" id="cinema_id" class="form-control mt-2" value="{{ $ticket->cinema->name }}" readonly>
            </div>
            <div class="form-group mb-3">
                <label for="showing_release_id">ShowingRelease</label>
                <input type="text" id="showing_release_id" class="form-control mt-2" value="{{ $ticket->showingrelease->time_release . ' -- date: ' . \Carbon\Carbon::parse($ticket->showingrelease->date_release)->format('d/m/Y') }}" readonly>
            </div>
            <div class="form-group mb-3">
                <label for="time_start">Time</label>
                <input type="text" id="time_start" class="form-control mt-2" value="{{ \Carbon\Carbon::parse($ticket->time_start)->format('H:i') }}" readonly>
            </div>
            <a href="{{ route('ticket.index') }}" class="btn btn-secondary mt-2">Back</a>
        </div>
    </div>
</div>
@endsection

