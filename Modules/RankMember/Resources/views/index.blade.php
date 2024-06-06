@extends('Backend.layouts.app')

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
                  <th onclick="sortTable('min_points')" style="cursor: pointer;">
                    Min Point
                    @if (request('sort') == 'min_points')
                        @if (request('direction') == 'asc')
                            <i class="bi bi-caret-up-fill"></i>
                        @else
                            <i class="bi bi-caret-down-fill"></i>
                        @endif
                    @endif
                </th>
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
            <!-- Hiển thị phân trang và giữ nguyên các tham số tìm kiếm và sắp xếp -->
            {{ $rankmembers->appends(['q' => request()->get('q'), 'sort' => request()->get('sort'), 'direction' => request()->get('direction')])->links() }}

        </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    function sortTable(column) {
        const urlParams = new URLSearchParams(window.location.search);
        let direction = urlParams.get('direction') === 'asc' ? 'desc' : 'asc';

        urlParams.set('sort', column);
        urlParams.set('direction', direction);

        window.location.href = window.location.pathname + '?' + urlParams.toString();
    }
</script>
@endsection
