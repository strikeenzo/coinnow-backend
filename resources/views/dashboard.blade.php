@extends('admin.layouts.app')

@section('content')
    @include('admin.layouts.headers.cards')

    <div class="container-fluid mt--7">
          <div class="row">
<!--              <div class="col-xl-6 mb-5 mb-xl-0">
                  <div class="card bg-gradient-default shadow">
                      <div class="card-header bg-transparent">
                          <div class="row align-items-center">
                              <div class="col">
                                  <h6 class="text-uppercase text-light ls-1 mb-1">Monthly Sales</h6>
                                  <h2 class="text-white mb-0">Sales Data</h2>
                              </div>
                          </div>
                      </div>

                      <div class="card-body">
                          <div class="chart">
                              <canvas id="sale-chart" class="chart-canvas"></canvas>
                          </div>
                      </div>
                  </div>
              </div>-->


<!--              <div class="col-xl-6 mb-5 mb-xl-0">
                  <div class="card bg-white-default shadow">
                      <div class="card-header bg-transparent">
                          <div class="row align-items-center">
                              <div class="col">
                                  <h2 class="text-black mb-0">Customers</h2>
                              </div>

                          </div>
                      </div>


                      <div class="card-body">
                          <div class="chart">
                              <canvas id="customer-chart" class="chart-canvas"></canvas>
                          </div>
                      </div>
                  </div>
              </div>-->

          </div>
<!--        <div class="row mt-5">
            <div class="col-xl-8 mb-5 mb-xl-0">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Lastest Orders</h3>
                            </div>
                            <div class="col text-right">
                                <a href="{{route('order')}}" class="btn btn-sm btn-primary">See all</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        &lt;!&ndash; Projects table &ndash;&gt;
                        <table class="table align-items-center table-flush">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Order ID</th>
                                    <th scope="col">Customer Name</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                              @forelse($data['latestOrders'] as $key => $value)
                                <tr>
                                    <th scope="row">
                                      #{{$value->invoice_prefix}} {{$value->invoice_no}}
                                    </th>
                                    <td>
                                        {{$value->firstname}}
                                    </td>
                                    <td>
                                      {{ $value->orderStatus ? $value->orderStatus->name : null}}
                                    </td>
                                    <td>
                                        {{date('d M Y',strtotime($value->order_date))}}
                                    </td>
                                    <td>
                                    ${{number_format($value->grand_total,2)}}
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="budget">
                                            No Record Found
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>-->

        @include('admin.layouts.footers.auth')
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('assets') }}/vendor/chart.js/dist/Chart.extension.js"></script>
    <script type="text/javascript">
    let salesLabel = [];
    let salesData = [];
    let customerLabel = [];
    let customerData = [];
    <?php
    foreach ($data['salesChartData'] as $key => $value) { ?>
      salesLabel.push('<?php  echo $value['label']; ?>');
      salesData.push('<?php  echo $value['value']; ?>');
  <?php   }    ?>

  <?php
  foreach ($data['customerChartData'] as $key => $value) { ?>
    customerLabel.push('<?php  echo $value['label']; ?>');
    customerData.push('<?php  echo $value['value']; ?>');
<?php   }    ?>

    const ctx = document.getElementById('sale-chart').getContext('2d');
const myChart = new Chart(ctx, {
type: 'line',
data: {
    labels: salesLabel,
    datasets: [{
        label: 'Sale',
        data: salesData,
        backgroundColor: [
            'rgba(255, 99, 132, 0.2)',

        ],
        borderColor: [
            'rgba(255, 255, 255, 1)',

        ],
        borderWidth: 1
    }]
},
options: {
  scales: {
         yAxes: [{
             ticks: {
                 beginAtZero: true
             }
         }]
     }
}
});


const ctx2 = document.getElementById('customer-chart').getContext('2d');
const myChart2 = new Chart(ctx2, {
type: 'bar',
data: {
labels: customerLabel,
datasets: [{
    label: 'Customer',
    data: customerData,
    base:0,
    axis: 'y',
    backgroundColor: [
       'rgba(255, 99, 132, 0.2)',
       'rgba(255, 159, 64, 0.2)',
       'rgba(255, 205, 86, 0.2)',
       'rgba(75, 192, 192, 0.2)',
       'rgba(54, 162, 235, 0.2)',
       'rgba(153, 102, 255, 0.2)',
       'rgba(201, 203, 207, 0.2)'
     ],
     borderColor: [
       'rgb(255, 99, 132)',
       'rgb(255, 159, 64)',
       'rgb(255, 205, 86)',
       'rgb(75, 192, 192)',
       'rgb(54, 162, 235)',
       'rgb(153, 102, 255)',
       'rgb(201, 203, 207)'
     ],
    borderWidth: 1
}]
},
options: {
  indexAxis: 'y',
  scales: {
         yAxes: [{
             ticks: {
                 beginAtZero: true
             }
         }]
     }
}
});




    </script>
@endpush
