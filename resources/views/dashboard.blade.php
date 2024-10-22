@extends('layouts.admin')
@php
$all = \Illuminate\Support\Facades\DB::table('requests')->count();
$done = \Illuminate\Support\Facades\DB::table('requests')->where('status','done')->count();
$progress = \Illuminate\Support\Facades\DB::table('requests')->where('status','progress')->count();
$failed = \Illuminate\Support\Facades\DB::table('requests')->where('status','failed')->count();
 @endphp
@section('style')
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Get context of canvas element for chart
        var ctx = document.getElementById('myChart').getContext('2d');

        // Sample data for chart
        var myChart = new Chart(ctx, {
            type: 'bar', // Specify chart type: bar, line, pie, etc.
            data: {
                labels: ['Barchasi', 'Bajarilgani', 'Bajarilmagani', 'Bajarilyapti'],
                datasets: [{
                    label: 'Colors Dataset',
                    data: [{{$all}}, {{$done}}, {{$failed}}, {{$progress}}],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
@section('content')
    <div style="width: 60%; margin: auto;">
        <canvas id="myChart"></canvas> <!-- Canvas element for chart -->
    </div>
@endsection
