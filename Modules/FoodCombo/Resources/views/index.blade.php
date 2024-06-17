
@extends('backend.layouts.app')

@section('content')
@if (session('success'))
<script>
    window.onload = function() {
        alert("{{ session('success') }}");
    }
</script>
@endif
    <div class="row">
        <div class="col-12">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="d-md-flex justify-content-between mb-9">
                        <div class="mb-9 mb-md-0">
                            <h5 class="card-title">FoodCombo</h5>
                        </div>
                        <div class="d-flex align-items-center">
                            <form id="search-form" class="position-relative me-3 w-100" action="{{ route('foodcombos.index') }}" method="GET">
                                <input type="text" class="form-control search-chat py-2 ps-5" id="text-srh" name="search"
                                       placeholder="Search" value="{{ request()->get('search') }}">
                                <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                            </form>
                            <div class="dropdown">
                                <a href="#" class="btn border shadow-none px-3" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-dots-vertical fs-5"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3" href="{{ route('foodcombos.create') }}"><i
                                                class="fs-4 ti ti-plus"></i>Add</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive overflow-x-auto latest-reviews-table">
                        <table class="table mb-0 align-middle text-nowrap">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Price  
                                        <i class="ti ti-filter" style="cursor: pointer;" onclick="toggleSortingOptions()"></i>
                                        <div id="sortingOptions" style="display: none;">
                                            <a href="{{ route('foodcombos.index', ['search' => request()->get('search'), 'sort_field' => 'price', 'sort_direction' => 'asc']) }}"> ↑</a>
                                            |
                                            <a href="{{ route('foodcombos.index', ['search' => request()->get('search'), 'sort_field' => 'price', 'sort_direction' => 'desc']) }}"> ↓</a>
                                        </div>
                                    </th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($foodCombos as $foodCombo)
                                <tr>
                                    <td><input type="checkbox" name="ticket_id[]" value="{{ $foodCombo->id }}"></td>
                                    <td><h6 class="fs-4 mb-0 text-truncate-2">{{ $foodCombo->name }}</h6></td>
                                    <td><h6 class="fs-4 mb-0 text-truncate-2">{{ $foodCombo->description }}</h6></td>
                                    <td><h6 class="fs-4 mb-0 text-truncate-2">{{ number_format($foodCombo->price, 0, ',', '.') }} VND</h6></td>
                                    <td>
                                        <div class="dropdown dropstart">
                                            <a href="#" class="text-muted " id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="ti ti-dots-vertical fs-5"></i>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center gap-3" href="{{ route('foodcombos.show', $foodCombo->id) }}"><i
                                                            class="fs-4 ti ti-plus"></i>Detail</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center gap-3" href="{{ route('foodcombos.edit', $foodCombo->id) }}"><i
                                                            class="fs-4 ti ti-edit"></i>Edit</a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('foodcombos.destroy', $foodCombo->id) }}" method="post" onsubmit="return confirm('Bạn chắc muốn xóa')">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="dropdown-item d-flex align-items-center gap-3">
                                                            <i class="fs-4 ti ti-trash"></i>Delete
                                                        </button>
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
                    <div class="d-flex align-items-center justify-content-between mt-10">
                        <div class="mt-3">
                            {{$foodCombos->links('vendor.pagination.bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function toggleSortingOptions() {
            var sortingOptions = document.getElementById('sortingOptions');
            sortingOptions.style.display = sortingOptions.style.display === 'none' ? 'inline-block' : 'none';
        }
        document.getElementById('text-srh').addEventListener('input', function () {
            if (this.value === '') {
                // Nếu ô tìm kiếm bị xóa, gửi form để tải lại trang index
                document.getElementById('search-form').submit();
            }
        });
    </script>
@endsection

