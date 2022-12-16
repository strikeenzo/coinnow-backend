@extends('admin.layouts.app')

@section('content')
    <canvas id="myChart" style="min-width:100%;overflow-x: scroll;"></canvas>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script>
        var xValues = {{ json_encode($dates) }};

        new Chart("myChart", {
            type: "line",
            data: {
                labels: xValues,
                datasets: [{
                    data: {{ json_encode($prices) }},
                    borderColor: "blue",
                    pointRadius: 1,
                    borderWidth: 1,
                    fill: false
                }, {
                    data: {{ json_encode($origins) }},
                    borderColor: "red",
                    pointRadius: 1,
                    borderWidth: 1,
                    fill: false
                }]
            },
            options: {
                legend: {
                    display: false
                }
            }
        });
    </script>
@endpush
