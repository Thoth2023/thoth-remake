@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Dashboard de Progresso</h2>
    
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
        <canvas id="progressChart" class="w-full h-64"></canvas>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('progressChart').getContext('2d');

        const progressChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Triagem', 'Extração', 'Análise'],
                datasets: [{
                    label: 'Progresso (%)',
                    data: @json([$triagem ?? 0, $extracao ?? 0, $analise ?? 0]),
                    backgroundColor: ['#36a2eb', '#ffcd56', '#4bc0c0'],
                    borderRadius: 5,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    }
                },
                plugins: {
                    legend: { display: true },
                    tooltip: { callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.raw + '%';
                        }
                    }}
                }
            }
        });
    });
</script>
@endsection
