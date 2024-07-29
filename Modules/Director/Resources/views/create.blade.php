@extends('Backend.layouts.app')
@section('content')
<div class="card">
    <div class="border-bottom title-part-padding">
        <h4 class="card-title mb-0">{{ $title }}</h4>
    </div>
    <div class="card-body">
        <form action="/admin/director" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name here" />
                    @error('name')
                        <div class="text text-danger">{{ $message }}</div>
                    @enderror  
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="age">Age</label>
                    <input type="text" class="form-control" id="age" name="age" placeholder="Enter Age" />
                    @error('age')
                        <div class="text text-danger">{{ $message }}</div>
                    @enderror 
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="date_of_birth">Date Of Birth</label>
                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" placeholder="Enter Date of Birth" />
                    @error('date_of_birth')
                        <div class="text text-danger">{{ $message }}</div>
                    @enderror 
                </div>
                <div class="col-12 mb-3">
                    <div class="d-md-flex align-items-center">
                        <div class="ms-auto mt-3 mt-md-0">
                            <button type="submit" class="btn btn-primary rounded-pill px-4">
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
