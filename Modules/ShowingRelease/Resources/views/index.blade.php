@extends('Backend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="d-md-flex justify-content-between mb-9">
                        <div class="mb-9 mb-md-0">
                            <h5 class="card-title">{{ $title }}</h5>
                        </div>
                        <div class="d-flex align-items-center">
                            <form id="filter-form" class="d-flex justify-content-between w-100">
                                <div class="flex-grow-1 mx-2">
                                    <select name="city_id" class="form-select" id="citySelect">
                                        <option value="">Select City</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="flex-grow-1 mx-2" id="cinemaSelectContainer" style="display: none;">
                                    <select name="cinema_id" class="form-select" id="cinemaSelect">
                                        <option value="">Select Cinema</option>
                                    </select>
                                </div>

                                <div class="flex-grow-1 mx-2" id="movieSelectContainer" style="display: none;">
                                    <div class="d-flex align-items-center">
                                        <select name="movie_id" class="form-select" id="movieSelect">
                                            <option value="">Select Movie</option>
                                        </select>
                                        <div class="dropdown ms-2" id="addButtonContainer" style="display: none;">
                                            <a href="#" class="btn border shadow-none px-3" id="addButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical fs-5"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center gap-3" href="#" id="addLink">
                                                        <i class="fs-4 ti ti-plus"></i>Add
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                    <div id="showingReleaseTable" class="table-responsive overflow-x-auto latest-reviews-table" style="display: none;">
                        <table class="table mb-0 align-middle text-nowrap table-bordered">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th>Movie</th>
                                    <th>Room</th>
                                    <th>Time</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="showingReleaseBody">
                                <!-- Nội dung bảng sẽ được chèn bằng AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('citySelect').addEventListener('change', function() {
            var cityId = this.value;
            fetch(`/admin/cinemas/${cityId}`)
                .then(response => response.json())
                .then(cinemas => {
                    var cinemaSelect = document.getElementById('cinemaSelect');
                    cinemaSelect.innerHTML = '<option value="">Select Cinema</option>';
                    cinemas.forEach(cinema => {
                        cinemaSelect.innerHTML += `<option value="${cinema.id}">${cinema.name}</option>`;
                    });
                    document.getElementById('cinemaSelectContainer').style.display = 'block';
                    // Reset movie and showing release sections
                    document.getElementById('movieSelectContainer').style.display = 'none';
                    document.getElementById('showingReleaseTable').style.display = 'none';
                });
        });

        document.getElementById('cinemaSelect').addEventListener('change', function() {
            var cinemaId = this.value;
            fetch(`/admin/movies/${cinemaId}`)
                .then(response => response.json())
                .then(movies => {
                    if (Array.isArray(movies)) {
                        var movieSelect = document.getElementById('movieSelect');
                        movieSelect.innerHTML = '<option value="">Select Movie</option>';
                        movies.forEach(movie => {
                            movieSelect.innerHTML += `<option value="${movie.id}">${movie.name}</option>`;
                        });
                        document.getElementById('movieSelectContainer').style.display = 'flex';
                        document.getElementById('addButtonContainer').style.display = 'block';

                        // Thiết lập URL cho nút Add với cinemaId
                        var addLink = document.getElementById('addLink');
                        addLink.href = `/admin/showingrelease/create/${cinemaId}`;
                    } else {
                        console.error('Dữ liệu không phải là mảng:', movies);
                        document.getElementById('movieSelectContainer').style.display = 'none';
                        document.getElementById('addButtonContainer').style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Có lỗi xảy ra:', error);
                    document.getElementById('movieSelectContainer').style.display = 'none';
                    document.getElementById('addButtonContainer').style.display = 'none';
                });
        });





document.getElementById('movieSelect').addEventListener('change', function() {
    var movieId = this.value;
    var cinemaId = document.getElementById('cinemaSelect').value;

    if (movieId && cinemaId) {
        fetch(`/admin/showingreleases/${movieId}/${cinemaId}`)
            .then(response => response.json())
            .then(showingReleases => {
                var showingReleaseBody = document.getElementById('showingReleaseBody');
                showingReleaseBody.innerHTML = '';
                if (Array.isArray(showingReleases)) {
                    showingReleases.forEach(showingRelease => {
                        showingReleaseBody.innerHTML += `
                            <tr>
                                <td>${showingRelease.movie.name}</td>
                                <td>${showingRelease.room.name}</td>
                                <td>${new Date(showingRelease.time_release).toLocaleTimeString([], {hour: '2-digit', minute: '2-digit'})}</td>
                                <td>${new Date(showingRelease.date_release).toLocaleDateString()}</td>
                                <td>
                                    <div class="dropdown dropstart">
                                        <a href="#" class="text-muted " id="dropdownMenuButton" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="ti ti-dots-vertical fs-5"></i>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center gap-3"  href="/admin/showingrelease/${showingRelease.id}"><i
                                                        class="fs-4 ti ti-plus"></i>Chi tiết</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center gap-3" href="/admin/showingrelease/${showingRelease.id}/edit"><i
                                                        class="fs-4 ti ti-edit"></i>Chỉnh sửa</a>
                                            </li>
                                            <li>
                                                <form action="/admin/showingrelease/${showingRelease.id}" method="post" onsubmit="return confirm('Bạn chắc muốn xóa')">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="dropdown-item d-flex align-items-center gap-3">
                                                        <i class="fs-4 ti ti-trash"></i>Xóa
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        `;
                    });
                    document.getElementById('showingReleaseTable').style.display = 'block';
                } else {
                    console.error('Dữ liệu trả về không phải là mảng:', showingReleases);
                }
            })
            .catch(error => console.error('Có lỗi xảy ra:', error));
    } else {
        console.error('movieId hoặc cinemaId không hợp lệ');
    }
});

    </script>
@endsection
