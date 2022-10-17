@extends('admin.layouts.app')

@section('content')
    @include('admin.layouts.headers.cards')

    <div class="container-fluid mt--7">
        <div class="row">
        </div>
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
        salesLabel.push('<?php echo $value['label']; ?>');
        salesData.push('<?php echo $value['value']; ?>');
        <?php   }    ?>

        <?php
  foreach ($data['customerChartData'] as $key => $value) { ?>
        customerLabel.push('<?php echo $value['label']; ?>');
        customerData.push('<?php echo $value['value']; ?>');
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
                    base: 0,
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
