@extends('admin.layouts.app')

@section('content')
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-black d-inline-block">Digital Show</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href={{ route('dashboard') }}><i class="fas fa-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('digital') }}">Digital Show</a></li>
                                <li class="breadcrumb-item">List</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter -->
    <div class="container-fluid mt--6 mb--1">

        <!-- Page content -->
        <div class="container-fluid ">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <!-- Card header -->

                        <!-- Light table -->
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col" class="sort" data-sort="name">Image</th>
                                        <th scope="col" class="sort" data-sort="name">Description</th>
                                        <th scope="col" class="sort" data-sort="name">Owner</th>
                                        <th scope="col" class="sort" data-sort="name">Comments</th>
                                        <th scope="col" class="sort" data-sort="name">Hearts</th>
                                        {{-- <th scope="col" class="sort">Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody class="list">

                                    @forelse($records as $key => $value)
                                        <tr>
                                            <td class="budget">
                                                <img src="{{ asset('/public/uploads/user') . '/' . $value->image }}"
                                                    alt="{{ $value->name }}" class="img-thumbnail img-fluid"
                                                    style=" width: 60px;height: 60px;">
                                            </td>
                                            <td class="budget"
                                                style="width: 700px; word-break: break-all; white-space: break-spaces;">
                                                {{ $value->comment }}</td>
                                            <td class="budget">
                                                {{ $value->owner->firstname . ' ' . $value->owner->lastname }}</td>
                                            <td class="budget "> <span
                                                    class="@if ($value->comments_count < 5) badge badge-danger btn-small @else badge badge-success btn-small @endif"
                                                    style="font-size:12px;">{{ $value->comments_count ? $value->comments_count : 0 }}</span>
                                            <td class="budget "> <span
                                                    class="@if ($value->sellers_count < 5) badge badge-danger btn-small @else badge badge-success btn-small @endif"
                                                    style="font-size:12px;">{{ $value->sellers_count ? $value->sellers_count : 0 }}</span>
                                                {{-- <td class="">
                                                <div class="dropdown">
                                                    <a class="btn btn-sm btn-icon-only text-dark" href="#"
                                                        role="button" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                        <a class="dropdown-item deleteData" type="button"
                                                            href="javascript:void(0)"
                                                            data-url="{{ route('guide.delete', ['id' => $value->id]) }}">Delete</a>
                                                    </div>
                                                </div>
                                            </td> --}}
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="budget">
                                                No Record Found
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- Card footer -->
                        <div class="card-footer py-4">
                            {{ $records->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('js')
        <script>
            $(document).on('click', '.deleteData', function() {
                let alertMessage = "Are You Sure,You want to delete it ?"
                let routeUrl = $(this).data('url')
                deleteData(alertMessage, routeUrl)
            })

            function onChange(e) {
                e.parentElement.submit()
            }
        </script>
    @endpush
