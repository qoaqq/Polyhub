@extends('Backend.layouts.app')

@section('content')
<div class="container">
    <h1>Detail Food Combo</h1>
    <div class="card">
        <div class="card-body">
            <div class="form-group mb-3">
                <label for="name">Name</label>
                <input type="text" id="name" class="form-control mt-2" value="{{ $foodCombo->name }}" readonly>
            </div>
            <div class="form-group mb-3">
                <label for="description">Description</label>
                <textarea id="description" class="form-control mt-2" readonly>{{ $foodCombo->description }}</textarea>
            </div>
            <div class="form-group mb-3">
                <label for="price">Price</label>
                <input type="number" id="price" class="form-control mt-2" value="{{ $foodCombo->price }}" readonly>
            </div>
            <a href="{{ route('foodcombos.index') }}" class="btn btn-secondary">Quay lại</a>
        </div>
    </div>
</div>
@endsection

