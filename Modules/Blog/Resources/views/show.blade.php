@extends('backend.layouts.app')
@section('content')
<h1 class="mt-4 ml-4">{{$title}}</h1>
<div class="ml-4 mb-5">
    <h4 class=" text-dark fs-4">ID: {{ $blog->id }} </h4>
    <h4 class=" text-dark fs-4">Title: {{ $blog->title }}</h4>
    <h4 class=" text-dark fs-4">Content: {{ $blog->content }}</h4>
    <h4 class=" text-dark fs-4">Category: {{ $blog->category->name }}</h4>
    <a href="/admin/blog"><button class=" mb-2 btn btn-primary">Back</button></a>
</div>
@endsection