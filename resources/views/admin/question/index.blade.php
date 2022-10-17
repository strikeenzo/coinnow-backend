@extends('admin.layouts.app')

@section('content')
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-black d-inline-block mb-0">Security Questions</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href={{ route('dashboard') }}><i class="fas fa-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('question') }}">Question</a></li>
                                <li class="breadcrumb-item">list</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                        <a href="{{ route('question.add') }}" class="btn btn-lg btn-neutral fade-class"><i
                                class="fas fa-plus fa-lg"></i> Create</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="header bg-primary pb-6">
        <div class="container-fluid mt--6 mb--1">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Question</th>
                                        <th>Created at</th>
                                        <th>Updated at</th>
                                        <th scope="col" class="sort">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($records as $key => $value)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td class="budget">
                                                {{ $value->question }}
                                            </td>
                                            <td>{{ $value->created_at }}</td>
                                            <td>{{ $value->updated_at }}</td>
                                            <td class="">
                                                <div class="dropdown">
                                                    <a class="btn btn-sm btn-icon-only text-dark" href="#"
                                                        role="button" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                        <a class="dropdown-item"
                                                            href="{{ route('question.edit', $value->id) }}">Edit</a>
                                                        <a class="dropdown-item deleteData" type="button"
                                                            href="javascript:void(0)"
                                                            data-url="{{ route('question.delete', $value->id) }}">Delete</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="budget">
                                                No Record Found
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).on('click', '.deleteData', function() {
            console.error('here')
            let alertMessage = "Are You Sure,You want to delete it?"
            let routeUrl = $(this).data('url')
            console.error(routeUrl)
            deleteData(alertMessage, routeUrl)
        })
    </script>
@endpush
