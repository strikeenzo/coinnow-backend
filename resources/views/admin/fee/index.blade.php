@extends('admin.layouts.app')

@section('content')
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-black d-inline-block mb-0">Everyday Fee</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href={{ route('dashboard') }}><i class="fas fa-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('fee') }}">Fee</a></li>
                                <li class="breadcrumb-item">list</li>
                            </ol>
                        </nav>
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
                                        <th>Collected Amounts</th>
                                        <th>Collected_at</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($records as $key => $value)
                                        <tr>
                                            <td class="budget">
                                                {{ $value->total_fee }}
                                            </td>
                                            <td>{{ $value->created_at }}</td>
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
                        <!-- Card footer -->
                        <div class="card-footer py-4">
                            {{ $records->links() }}
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
