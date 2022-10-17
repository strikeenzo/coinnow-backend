@extends('admin.layouts.app')

@section('content')
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-black d-inline-block mb-0">Customer Support Center</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href={{ route('dashboard') }}><i class="fas fa-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('comments') }}">Comment</a></li>
                                <li class="breadcrumb-item">List</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid ">
        <div class="row">
            <div class="col">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header border-0">
                        <h3 class="mb-3">Filter</h3>
                        <form action="{{ route('comments') }}">
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <input type="text" name="keyword" id="firstname" value="{{ request()->keyword }}"
                                        class="form-control form-control-alternative"
                                        placeholder="Search by name,email,mobile number" autofocus>
                                </div>
                                <div class="col-md-3 form-group">
                                    <button type="submit" class="btn btn-success"><i class="fas fa-search"></i></button>
                                    <a href="{{ route('comments') }}" class="btn btn-info"><i
                                            class="fas fa-sync-alt"></i></a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <!-- Card header -->

            <!-- Light table -->
            <div class="table-responsive">
                <table class="table align-items-center table-flush">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col" class="sort p-3" data-sort="name" style="width: 3%">ID</th>
                            <th scope="col" class="sort p-3" data-sort="name" style="width: 45%">Comment</th>
                            <th scope="col" class="sort p-3" data-sort="name" style="width: 5%">username</th>
                            <th scope="col" class="sort p-3" data-sort="status" style="width: 45%">Reply</th>
                            <th scope="col" class="sort p-3" data-sort="status" style="width: 4%">Created At</th>
                            <th scope="col" class="sort p-3" data-sort="status" style="width: 4%">Reply At</th>
                            <th scope="col" class="sort p-3" style="width: 4%">Action</th>
                        </tr>
                    </thead>
                    <tbody class="list">

                        @forelse($records as $key => $value)
                            <tr>
                                <td class="budget">{{ $value->id }}</td>
                                <td style="word-break: break-word; white-space: break-spaces;" class="p-3">
                                    {{ $value->content }}</td>
                                <td style="word-break: break-word; white-space: break-spaces;" class="budget p-3">
                                    {{ $value['customer']->email }}</td>
                                <td style="word-break: break-word; white-space: break-spaces;" class="p-3">
                                    {{ $value->reply }}</td>
                                <td style="word-break: break-word; white-space: break-spaces;" class="budget p-3"
                                    style="width: 70px;">{{ $value->created_at }}</td>
                                <td style="word-break: break-word; white-space: break-spaces;" class="budget p-3"
                                    style="width: 70px ">{{ $value->reply_at }}</td>
                                <td class="p-3">
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-icon-only text-dark" href="#" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            <a class="dropdown-item"
                                                href="{{ route('comments.edit', $value->id) }}">Reply</a>
                                        </div>
                                    </div>
                                </td>
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
                {{ $records->appends(['keyword' => request()->keyword])->links() }}
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
