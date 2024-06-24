@extends('backend.layouts.app')
@section('content')
<h1 class="mt-4 ml-4">{{$title}}</h1>
<div class="ml-4 mb-5">
    <h4 class=" text-dark fs-4">ID: {{ $movie->id }} </h4>
    <h4 class=" text-dark fs-4">Movie Name: {{ $movie->name }}</h4>
    <h4 class=" text-dark fs-4">Description: {{ $movie->description }}</h4>
    <h4 class=" text-dark fs-4">Duration: {{ $movie->duration }} minutes </h4>
    <h4 class=" text-dark fs-4">Premiere Date: {{ $movie->premiere_date }}</h4>
    <h4 class=" text-dark fs-4">Director: {{ $movie->director->name }}</h4>
    <a href="/admin/movie"><button class=" mb-2 btn btn-primary">Back</button></a>
</div>
@endsection