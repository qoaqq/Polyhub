@extends('Backend.layouts.app')
@section('content')
<h1 class="mt-4 ml-4">{{$title}}</h1>
<div class="card">
    <div class="card-body">
      <form action="/admin/blog" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="row">
          <div class="col-md-6">
            <div class="form-floating mb-3">
              <input type="text" class="form-control" name="title" placeholder="Enter Title here" />
              <label for="">Title</label>
              @error('title')
                <div class="text text-danger">{{ $message }}</div>
              @enderror  
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-floating mb-3">
              <input type="text" class="form-control" name='content' placeholder="Enter Content" />
              <label for="">Content</label>
              @error('content')
                <div class="text text-danger">{{ $message }}</div>
              @enderror 
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-floating mb-3">
                <label for="formFile" class="form-label"></label>
                <input class="form-control" type="file" id="formFile" name="image" />
              @error('image')
                <div class="text text-danger">{{ $message }}</div>
              @enderror 
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-floating mb-3">
              <select class="form-select" aria-label="Default select example" name="categories_id"> 
                <option value="">Select a category</option>
                @foreach ($categories as $item)
                    @if (!$item->category_id)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @include('blog::partials.children_categories', ['categories' => $categories, 'parent_id' => $item->id, 'char' => '|---'])
                    @endif
                @endforeach
            </select>
              <label for="tb-cpwd">Category</label>
            </div>
          </div>
          <div class="col-12">
            <div class="d-md-flex align-items-center">
              <div class="ms-auto mt-3 mt-md-0">
                <button type="submit" class="btn btn-primary  rounded-pill px-4">
                  <div class="d-flex align-items-center">
                    <i class="ti ti-send me-2 fs-4"></i>
                    Submit
                  </div>
                </button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection