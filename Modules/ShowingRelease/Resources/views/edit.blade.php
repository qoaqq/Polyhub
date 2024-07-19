@extends('Backend.layouts.app')

@section('content')
<div class="container">
    <h1>Edit</h1>
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
            <form action="{{ route('showingrelease.update', $show->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group mb-3">
                    <label for="movie_id">Movies</label>
                    <select name="movie_id" id="movie_id" class="form-control select-movie mt-2">
                        <option value="0">--Select movies--</option>
                        @foreach($movie as $id => $name)
                            <option value="{{ $id }}" {{ $show->movie_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="room_id">Room</label>
                    <select name="room_id" id="room_id" class="form-control select-movie mt-2">
                        <option value="0">--Select room--</option>
                        @foreach($room as $id => $name)
                            <option value="{{ $id }}" {{ $show->room_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="time_start">Date</label>
                    <input type="date" name="date_release" id="date_release" class="form-control mt-2" value="{{ $show->date_release}}">
                </div>
            
                <div class="form-group mb-3">
                    <label for="time_start">Time</label>
                    <input type="time" name="time_release" id="time_release" class="form-control mt-2" value="{{ \Carbon\Carbon::parse($show->time_release)->format('H:i') }}">
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="{{ route('showingrelease.index') }}" class="btn btn-secondary">Quay lại</a>
            </form>
        </div>
    </div>
</div>
@endsection

