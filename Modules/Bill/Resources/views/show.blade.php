@extends('Backend.layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-md-flex justify-content-between mb-9">
                <div class="mb-9 mb-md-0">
                    <h1 class="card-title" style="font-size: 1.5rem">Bill</h1>
                </div>
                
            </div>

            <div>
                <div class="card-body">
                    <div class="row">
                        {{-- <div class="col-md-6 mb-3">
                            <label class="form-label" for="date_release">Date</label>
                            <input type="date" id="date_release" class="form-control" value="{{ $showingRelease->date_release }}" readonly/>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="time_release">Time</label>
                            <input type="time" id="time_release" class="form-control" value="{{ \Carbon\Carbon::parse( $showingRelease->time_release)->format('H:i') }}" readonly/>
                        </div> --}}
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="movie_id">Username</label>
                            <input type="text" id="movie_id" class="form-control mt-2" value="{{ $bill->user->name }}" readonly/>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="room_id">Email</label>
                            <input type="text" id="room_id" class="form-control mt-2" value="{{ $bill->user->email }}" readonly/>
                        </div>
                    </div>
                    <a href="{{ route('bill.index') }}" class="btn btn-secondary mt-3 rounded-pill px-4">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection