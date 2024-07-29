@extends('Backend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-0">
                <div class="border-bottom title-part-padding">
                    <h4 class="card-title mb-0">update cinema</h4>
                </div>
                <div class="card-body">
                    {{-- content start --}}
                    <section class="container">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="mb-3">Add new room</h5>
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
                                                            Add new
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
                </div>
            </div>
        </div>
    </div>
@endsection
