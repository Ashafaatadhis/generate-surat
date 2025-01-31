@extends('adminlte::page')

@section('title', 'Dashboard - Template Letters')

@section('content_header')
    <h1>Dashboard - Template Letters</h1>
@stop

@section('content')
    <div class="row">
        <!-- Grafik 1: Template Letters Populer -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3>Most Popular Templates</h3>
                </div>
                <div class="card-body">
                    <canvas id="popularTemplatesChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Grafik 2: Template Letters Terbaru -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3>Newest Templates by Usage</h3>
                </div>
                <div class="card-body">
                    <canvas id="newestTemplatesChart"></canvas>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Data untuk Grafik 1: Template Letters Populer
        const popularTemplatesData = @json($popularTemplates); // Data dari controller
        const popularTemplatesLabels = popularTemplatesData.map(item => item.title);
        const popularTemplatesCount = popularTemplatesData.map(item => item.count_use);

        const ctx1 = document.getElementById('popularTemplatesChart').getContext('2d');
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: popularTemplatesLabels,
                datasets: [{
                    label: 'Usage Count',
                    data: popularTemplatesCount,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Data untuk Grafik 2: Template Letters Terbaru
        const newestTemplatesData = @json($newestTemplates); // Data dari controller
        const newestTemplatesLabels = newestTemplatesData.map(item => item.title);
        const newestTemplatesCount = newestTemplatesData.map(item => item.count_use);

        const ctx2 = document.getElementById('newestTemplatesChart').getContext('2d');
        new Chart(ctx2, {
            type: 'line',
            data: {
                labels: newestTemplatesLabels,
                datasets: [{
                    label: 'Usage Count',
                    data: newestTemplatesCount,
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@stop
