
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
                                        <a class="dropdown-item d-flex align-items-center gap-3" href="{{ route('voucher.create') }}"><i
                                                class="fs-4 ti ti-plus"></i>Add</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3"
                                            href="{{ route('voucher.bin') }}"><i class="fs-4 ti ti-edit"></i>Bin</a>
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
                                 <tr class="text-center">
                                   
                                    <th scope="col">ID

                                    </th>
                                    <th scope="col">Code

                                    </th>
                                    <th scope="col">Type

                                    </th>
                                    <th scope="col">Amount

                                    </th>
                                    <th scope="col">Start Date

                                    </th>
                                    <th scope="col">End Date

                                    </th>
                                    <th scope="col">Limit Usage

                                    </th>
                                    <th scope="col">Used

                                    </th>
                                    <th scope="col">Status

                                    </th>
                                    <th scope="col"></th>
                                 </tr>
                             </thead>
                             <tbody>
                                @forelse ($page as $item)
                                    <tr>
                                       
                                        <td>
                                            <div class="d-flex align-items-center product text-truncate">
                                                <div class="ms-3 product-title">
                                                    <h6 class="fs-4 mb-0 text-truncate-2">
                                                        {{ $item->id }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center text-truncate">
                                                <div class="ms-7">
                                                    <h5 class="mb-1 fs-4"> {{ $item->code }}</h5>

                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center text-truncate">
                                                <div class="ms-7">
                                                    <h5 class="mb-1 fs-4"> {{ $item->type }}</h5>

                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <h6 class="fs-4 mb-0 text-truncate-2">
                                                {{ $item->amount }}
                                            </h6>
                                        </td>
                                        <td>
                                            <h6 class="fs-4 mb-0 text-truncate-2">
                                                {{ $item->start_date }}
                                            </h6>
                                            
                                        </td>
                                        <td>
                                            <h6 class="fs-4 mb-0 text-truncate-2">
                                                {{ $item->end_date }}
                                            </h6>
                                            
                                        </td>
                                        <td>
                                            <h6 class="fs-4 mb-0 text-truncate-2">
                                                {{ $item->usage_limit }}
                                            </h6>
                                            
                                        </td>
                                        <td>
                                            <h6 class="fs-4 mb-0 text-truncate-2">
                                                {{ $item->used }}
                                            </h6>
                                            
                                        </td>
                                        <td>
                                            <h6 class="fs-4 mb-0 text-truncate-2">
                                                {{ $item->status }}
                                            </h6>
                                            
                                        </td>
                                        <td>
                                            <div class="dropdown dropstart">
                                                <a href="#" class="text-muted " id="dropdownMenuButton"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-dots-vertical fs-5"></i>
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-3"
                                                            href=" {{ route('voucher.show', $item->id) }} "><i
                                                                class="fs-4 ti ti-plus"></i>Detail</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-3"
                                                            href="{{ route('voucher.edit', $item->id) }}"><i
                                                                class="fs-4 ti ti-edit"></i>Edit</a>
                                                    </li>
                                                    <li>

                                                        <form action="{{ route('voucher.delete', $item->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <input type="hidden" name="id"
                                                                value="{{ $item->id }}">
                                                            <button type="submit"
                                                                class="dropdown-item d-flex align-items-center gap-3"
                                                                onclick="return confirm('Delete now?')"><i
                                                                    class="fs-4 ti ti-trash"></i> Delete </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                     </tbody>
                     </table>
                 </div>
                 <div class="d-flex align-items-center justify-content-between mt-4">
                     <!-- Hiển thị phân trang và giữ nguyên các tham số tìm kiếm và sắp xếp -->
                     {{ $page->appends(['q' => request()->get('q'), 'sort' => request()->get('sort'), 'direction' => request()->get('direction')])->links('vendor.pagination.bootstrap-5') }}

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