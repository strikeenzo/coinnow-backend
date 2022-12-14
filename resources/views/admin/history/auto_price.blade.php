@extends('admin.layouts.app')

@section('content')
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-black d-inline-block mb-0">Auto Price Change history</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href={{ route('dashboard') }}><i class="fas fa-home"></i></a>
                                </li>
                                <li class="breadcrumb-item">Price Change</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-lg-6 col-5 d-flex justify-content-end pr-4">
                        <a href="/api/autoPriceChange" target="blank" class="btn btn-primary">Auto Change</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="header bg-primary pb-6">
        <div class="container-fluid mt--6 mb--1">
            <div>
                <p>Total Remaining: {{ $total_remaining }}</p>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col" class="sort" data-sort="name">Before amount</th>
                                        <th scope="col" class="sort" data-sort="name">Next amount</th>
                                        <th scope="col" class="sort" data-sort="name">Collected</th>
                                        <th scope="col" class="sort" data-sort="name">Distributed</th>
                                        <th scope="col" class="sort" data-sort="name">Remaining balance</th>
                                        <th scope="col" class="sort" data-sort="name">Detail</th>
                                        <th scope="col" class="sort" data-sort="name">created at</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($records as $key => $value)
                                        <tr>
                                            <td>{{ $value->collected }}</td>
                                            <td>{{ $value->distributed }}</td>
                                            <td>{{ $value->collected1 }}</td>
                                            <td>{{ $value->distributed1 }}</td>
                                            <td>{{ $value->collected - $value->distributed }}</td>
                                            <td>
                                                <a class="btn btn-sm btn-success"
                                                    href="{{ route('auto_price_detail_history', $value->id) }}">
                                                    Detail
                                                </a>
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
@endpush
