@extends('backend.layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
      <div class="card mb-0">
        <div class="card-body">
          <div class="d-md-flex justify-content-between mb-9">
            <div class="mb-9 mb-md-0">
              <h5 class="card-title">{{$title}}</h5>
            </div>
            <div class="d-flex align-items-center">
              <form class="position-relative me-3 w-100" method="GET">
                <input type="text" class="form-control search-chat py-2 ps-5" id="text-srh"
                  placeholder="Search" name='q'>
                <i
                  class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
              </form>
              <div class="dropdown">
                <a href="#" class="btn border shadow-none px-3" id="dropdownMenuButton"
                  data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="ti ti-dots-vertical fs-5"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                  <li>
                    <a class="dropdown-item d-flex align-items-center gap-3" href="{{ route('rankmember.create') }}"><i
                        class="fs-4 ti ti-plus"></i>Add</a>
                  </li>
                  <li>
                    <a class="dropdown-item d-flex align-items-center gap-3" href="#"><i
                        class="fs-4 ti ti-edit"></i>Edit</a>
                  </li>
                  <li>
                    <a class="dropdown-item d-flex align-items-center gap-3" href="#"><i
                        class="fs-4 ti ti-trash"></i>Delete</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="table-responsive overflow-x-auto latest-reviews-table">
            <table class="table mb-0 align-middle text-nowrap table-bordered">
              <thead class="text-dark fs-4">
                <tr>
                  <th>Rank</th>
                  <th>Min Point</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($rankmembers as $rankmember)
                <tr>  
                  <td>
                      <div class="ms-3 product-title">
                        <h6 class="fs-4 mb-0 text-truncate-2">{{$rankmember->rank}}</h6>
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="d-flex align-items-center text-truncate">
                        <h6 class="mb-0 fw-light">{{$rankmember->min_points}}</h6>
                    </div>
                  </td>
                  <td>
                    <div class="dropdown dropstart">
                      <a href="#" class="text-muted " id="dropdownMenuButton" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="ti ti-dots-vertical fs-5"></i>
                      </a>
                      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li>
                          <a class="dropdown-item d-flex align-items-center gap-3" href="{{route('rankmember.edit',$rankmember->id)}}"><i
                              class="fs-4 ti ti-edit"></i>Edit</a>
                        </li>
                        <li>
                          <form action="{{route('rankmember.destroy',$rankmember->id)}}" method="post">
                            @csrf
                            @method('delete')
                            <button  class="dropdown-item d-flex align-items-center gap-3" type="submit"
                                onclick="return confirm('Do you want to delete?')"><i
                                class="fs-4 ti ti-trash"></i>Delete</button>
                        </form>
                        </li>
                      </ul>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="d-flex align-items-center justify-content-between mt-4">
            <p class="mb-0 fw-normal">
                {{ $rankmembers->firstItem() }}-{{ $rankmembers->lastItem() }} of {{ $rankmembers->total() }}
            </p>
            <nav aria-label="Page navigation example">
                <ul class="pagination mb-0 align-items-center">
                        <li class="page-item">
                            <a class="page-link border-0 d-flex align-items-center text-muted fw-normal" href="{{ $rankmembers->previousPageUrl() }}" rel="prev">
                                <iconify-icon icon="solar:alt-arrow-left-line-duotone" class="fs-5"></iconify-icon>Previous
                            </a>
                        </li>
                    @foreach ($rankmembers->getUrlRange(1, $rankmembers->lastPage()) as $page => $url)
                        @if ($page == $rankmembers->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                        <li class="page-item">
                            <a class="page-link border-0 d-flex align-items-center fw-normal" href="{{ $rankmembers->nextPageUrl() }}" rel="next">
                                Next<iconify-icon icon="solar:alt-arrow-right-line-duotone" class="fs-5"></iconify-icon>
                            </a>
                        </li>
                </ul>
            </nav>
        </div>
        </div>
      </div>
    </div>
  </div>
@endsection
