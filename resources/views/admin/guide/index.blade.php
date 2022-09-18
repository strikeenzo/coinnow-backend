@extends('admin.layouts.app')

@section('content')

    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-black d-inline-block">Guide</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href={{ route('dashboard') }}><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('guide') }}">Guide</a></li>
                                <li class="breadcrumb-item">List</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                        <a href="{{ route('guide.add') }}" class="btn btn-lg btn-neutral fade-class"><i class="fas fa-plus fa-lg"></i> New</a>
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
                                <th scope="col" class="sort" data-sort="name">ID</th>
                                <th scope="col" class="sort" data-sort="name">Title</th>
                                <th scope="col" class="sort" data-sort="name">Content</th>
                                <th scope="col" class="sort" data-sort="name">Sort Order</th>
                                <th scope="col" class="sort" data-sort="name">Status</th>
                                <th scope="col" class="sort" data-sort="name">type</th>
                                <th scope="col" class="sort">Action</th>
                            </tr>
                            </thead>
                            <tbody class="list">

                            @forelse($records as $key => $value)

                                <tr>
                                    <td class="budget">{{ $value->id }}</td>
                                    <td class="budget">{{ $value->title }}</td>
                                    <td class="budget" style="width: 700px; word-break: break-all; white-space: break-spaces;">{{ $value->content }}</td>
                                    <td class="budget">{{ $value->sort_order }}</td>
                                    <td class="budget">
                                      <form method="post" action="{{ route('guide.updateStatus', $value) }}"  autocomplete="off">
                                          @csrf
                                          @method('put')
                                          <input type="checkbox" name="status" {{ $value->status ? "checked" : "" }} onclick="onChange(this)">
                                      </form>
                                    </td>
                                    <td class="budget">{{ $value->type }}</td>
                                    <td class="">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-dark" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a class="dropdown-item" href="{{ route('guide.edit',['id' => $value->id]) }}">Edit</a>
                                                <a class="dropdown-item deleteData" type="button"  href="javascript:void(0)" data-url="{{ route('guide.delete',['id' => $value->id]) }}">Delete</a>
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
                        {{ $records->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')

    <script>
        $(document).on('click','.deleteData',function(){
            let alertMessage = "Are You Sure,You want to delete it ?"
            let routeUrl = $(this).data('url')
            deleteData(alertMessage, routeUrl)
        })

        function onChange(e) {
          e.parentElement.submit()
        }
    </script>
@endpush
