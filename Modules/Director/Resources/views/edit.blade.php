@extends('Backend.layouts.app')
@section('content')
<h1 class="mt-4 ml-4">{{$title}}</h1>
<div class="card">
    <div class="card-body">
      <form action="/admin/director/{{$director->id}}" enctype="multipart/form-data" method="POST">
        @csrf
        @method("PUT")
        <div class="row">
          <div class="col-md-6">
            <div class="form-floating mb-3">
              <input type="text" class="form-control" name="name" placeholder="Enter Name here" value="{{$director->name}}" />
              <label for="">Name</label>
              @error('name')
                <div class="text text-danger">{{ $message }}</div>
              @enderror  
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-floating mb-3">
              <input type="number" class="form-control" name='age' placeholder="Enter Age" value="{{$director->age}}" />
              <label for="">Age</label>
              @error('age')
                <div class="text text-danger">{{ $message }}</div>
              @enderror 
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-floating mb-3">
              <input type="date" class="form-control" name="date_of_birth" placeholder="Enter Date Of Birth" value="{{$director->date_of_birth}}" />
              <label for="">Date Of Birth</label>
              @error('date_of_birth')
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