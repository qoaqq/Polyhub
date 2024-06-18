@extends('backend.layouts.app')
@section('content')
<h1 class="mt-4 ml-4">{{$title}}</h1>
<div class="ml-4 mb-5">
    <h4 class=" text-dark fs-4">ID: {{ $director->id }} </h4>
    <h4 class=" text-dark fs-4">Name: {{ $director->name }}</h4>
    <h4 class=" text-dark fs-4">Age: {{ $director->age }}</h4>
    <h4 class=" text-dark fs-4">Date Of Birth: {{ $director->date_of_birth }}</h4>
    <a href="/admin/director"><button class=" mb-2 btn btn-primary">Back</button></a>
</div>
@endsection