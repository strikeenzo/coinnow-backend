@extends('admin.layouts.app')

@section('content')

<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-black d-inline-block mb-0">Button</h6>
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
              <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href={{ route('dashboard') }}><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item"><a href="{{ route('button') }}">Button</a></li>
                  <li class="breadcrumb-item">list</li>
              </ol>
          </nav>
        </div>
        <div class="col-lg-6 col-5 text-right">
            <a href="{{ route('button.add') }}" class="btn btn-lg btn-neutral fade-class"><i class="fas fa-plus fa-lg"></i> Create/Update</a>
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
                  <th>Type</th>
                  <th>Button</th>
                  <th>Created at</th>
                  <th>Updated at</th>
                </tr>
              </thead>
              <tbody>
                @forelse($records as $key => $value)
                  <tr>
                    <td>{{
                      $value->type == 1 ? 'Clan' : (
                        $value->type == 2 ? 'Inventory' : (
                          $value->type == 3 ? 'Barn' : 'Job Offers'
                        )
                      )
                    }}</td>
                    <td class="budget">
                      @if($value->image)
                        <img src="{{asset('/public/uploads/button').'/'.$value->image}}"  alt="button image"  class="img-thumbnail img-fluid" style=" width: auto; height: 60px;">
                      @else
                        <img src="{{asset('/assets/img/default.png')}}"  alt="button image"  class="img-thumbnail img-fluid" style=" width: 60px;height: 60px;">
                      @endif
                    </td>
                    <td>{{ $value->created_at }}</td>
                    <td>{{ $value->updated_at }}</td>
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
      $(document).on('click','.deleteData',function(){
        console.error('here')
        let alertMessage = "Are You Sure,You want to delete it?"
        let routeUrl = $(this).data('url')
        console.error(routeUrl)
        deleteData(alertMessage, routeUrl)
      })
  </script>
@endpush
