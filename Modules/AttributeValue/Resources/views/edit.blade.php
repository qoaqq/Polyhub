@extends('Backend.layouts.app')

@section('content')
    <div class="mx-2">
        <div class="card shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body d-flex align-items-center justify-content-between p-4">
                <a href="{{ route('attributevalue.list') }}">
                    <h4 class="fw-semibold mb-0"> {{ $title }} </h4>
                </a>

            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="mb-4 pb-2 align-items-center">
                    <h5 class="mb-0"> {{ $title2 }} </h5>
                </div>
                <form action="{{ route('attributevalue.update', $attrV->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div>
                        <div class="card-body">
                            {{-- <h5>Person Info</h5> --}}
                            <div class="row pt-3">

                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="mb-3 has-success">
                                        <label class="form-label">Movie</label>
                                        <select class="form-select" name="attribute_id">
                                            <option value="">Select a Movie</option>
                                            {{-- @forelse ($movie as $item)
                                                <option value=" {{ $item->id }} "> {{ $item->name }} </option>
                                            @empty
                                            @endforelse --}}
                                            @forelse ($listattr as $item2)
                                                {{-- @forelse ($movie as $item3)
                                                    @if ($attrV->attribute_id == $item2->id && $item2->movie_id == $item3->id)
                                                        <option value=" {{ $attrV->attribute_id }} " selected>
                                                            {{ $item3->name . ' - ' . $item2->name }} </option>
                                                    @else
                                                        <option value=" {{ $item2->id }} " selected>
                                                            {{ $item3->name . ' - ' . $item2->name }} </option>
                                                    @endif
                                                @empty
                                                @endforelse --}}
                                                @if ($attrV->attribute_id == $item2->id)
                                                    @forelse ($movie as $item3)
                                                        @if ($item2->movie_id == $item3->id)
                                                            <option value=" {{ $attrV->id }} " selected>
                                                                {{ $item3->name . ' - ' . $item2->name }}
                                                            </option>
                                                        @else
                                                            <option value=" {{ $item2->id }} " selected>
                                                                {{ $item3->name . ' - ' . $item2->name }}
                                                            </option>
                                                        @endif
                                                    @empty
                                                    @endforelse
                                                @else
                                                @endif
                                            @empty
                                            @endforelse

                                        </select>
                                        <span class="text-danger">{{ $errors->first('movie_id') }}</span>

                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label"> Value</label>
                                        <input type="file" name="value" value=" {{ $attrV->value }} " id="firstName"
                                            class="form-control" placeholder="John doe" />
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    </div>
                                    <div>
                                        <img src="{{ asset($attrV->value) }}" alt="">
                                    </div>
                                </div>
                            </div>
                            <!--/row-->


                        </div>

                        <div class="form-actions">
                            <div class="card-body border-top">
                                <button type="submit" class="btn btn-success rounded-pill px-4">
                                    Save
                                </button>
                                <a href=" {{ route('attributevalue.list') }} ">
                                    <button type="button" class="btn bg-danger-subtle text-danger rounded-pill px-4 ms-6">
                                        Cancel
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
