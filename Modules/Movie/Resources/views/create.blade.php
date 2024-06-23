@extends('Backend.layouts.app')
@section('content')
<h1 class="mt-4 ml-4">{{$title}}</h1>
<div class="card">
    <div class="card-body">
      <form action="/admin/movie" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="row">
          <div class="col-md-6">
            <div class="form-floating mb-3">
              <input type="text" class="form-control" name="name" placeholder="Enter Name here" />
              <label for="">Name</label>
              @error('name')
                <div class="text text-danger">{{ $message }}</div>
              @enderror  
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-floating mb-3">
              <input type="text" class="form-control" name='description' placeholder="Enter Description" />
              <label for="">Description</label>
              @error('description')
                <div class="text text-danger">{{ $message }}</div>
              @enderror 
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-floating mb-3">
              <input type="number" class="form-control" name="duration" placeholder="Enter Duration" />
              <label for="">Duration</label>
              @error('duration')
                <div class="text text-danger">{{ $message }}</div>
              @enderror 
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-floating mb-3">
              <input type="date" class="form-control" name="premiere_date" placeholder="Enter Premiere date" />
              <label for="tb-cpwd">Premiere date</label>
              @error('premiere_date')
                <div class="text text-danger">{{ $message }}</div>
              @enderror 
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-floating mb-3">
              <select type="text" id="director_id" class="form-select" name='director_id'>
                @foreach($director as $id=>$name)
                    <option value="{{$id}}">{{$name}}</option>
                @endforeach
              </select> 
              <label for="tb-cpwd">Director</label>
              @error('premiere_date')
                <div class="text text-danger">{{ $message }}</div>
              @enderror 
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