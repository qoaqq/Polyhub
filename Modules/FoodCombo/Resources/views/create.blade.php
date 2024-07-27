@extends('Backend.layouts.app')
@section('content')
<div class="card">
    <div class="border-bottom title-part-padding">
      <h4 class="card-title mb-0">{{$title}}</h4>
    </div>
    <div class="card-body">
      <form class="needs-validation" action="{{route('foodcombos.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label" for="validationCustom01">Name</label>
            <input type="text" class="form-control" id="validationCustom01" name="name" id="name"
            value="{{old('name')}}"  required/>
              @if ($errors->has('name'))
                <span class="error text-danger">{{ $errors->first('name') }}</span>
              @endif
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label" for="validationCustom02">Price</label>
            <input type="number" class="form-control" name="price" id="price"
              value="{{old('price')}}"  required/>
              @if ($errors->has('price'))
                <span class="error text-danger">{{ $errors->first('price') }}</span>
              @endif
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 mb-3">
            <label class="form-label" for="validationCustom03">Description</label>
            <textarea name="description" id="description" class="form-control" value="{{old('description')}}"  required/></textarea>
            @if ($errors->has('description'))
            <span class="error text-danger">{{ $errors->first('description') }}</span>
          @endif
          </div>
        </div>
        <button class="btn btn-primary mt-3 rounded-pill px-4" type="submit">
          Submit form
        </button>
        <a href="{{ route('foodcombos.index') }}" class="btn btn-secondary  mt-3 rounded-pill px-4">Back</a>
      </form>
    </div>
  </div>
@endsection