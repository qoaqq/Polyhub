@extends('Backend.layouts.app')

@section('content')
<div class="container">
    <!-- Error messages -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h1>Create Food Combo</h1>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('foodcombos.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control mt-2" required>
                </div>
                <div class="form-group mb-3">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control mt-2"></textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="price">Price</label>
                    <input type="number" name="price" id="price" class="form-control mt-2" required>
                </div>
                <button type="submit" class="btn btn-primary">Create</button>
                <a href="{{ route('foodcombos.index') }}" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>
</div>
@endsection
