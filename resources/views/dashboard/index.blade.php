@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width: 850px;">
    <h1 class="mb-4 text-center text-primary fw-bold" style="font-family: 'Poppins', sans-serif; font-size: 2.2rem;" data-aos="fade-down">
        Dashboard Tugas
    </h1>

    <div class="row g-4 mb-4">
        <div class="col-md-4" data-aos="zoom-in" data-aos-delay="100">
            <div class="card shadow rounded-4 border-0 stat-card">
                <div class="card-body text-center py-4 px-3">
                    <i class="bi bi-list-check text-primary mb-2" style="font-size: 1.8rem;"></i>
                    <h6 class="text-uppercase text-muted mb-1 fw-semibold">Total Tugas</h6>
                    <p class="h2 text-primary fw-bold mb-0">{{ $totalTugas }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
            <div class="card shadow rounded-4 border-0 stat-card">
                <div class="card-body text-center py-4 px-3">
                    <i class="bi bi-check-circle text-success mb-2" style="font-size: 1.8rem;"></i>
                    <h6 class="text-uppercase text-muted mb-1 fw-semibold">Tugas Selesai</h6>
                    <p class="h2 text-success fw-bold mb-0">{{ $tugasSelesai }}</p>
                    <div class="progress mt-2" style="height: 6px;">
                        <div class="progress-bar bg-success" style="width: {{ ($tugasSelesai / max($totalTugas,1)) * 100 }}%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4" data-aos="zoom-in" data-aos-delay="300">
            <div class="card shadow rounded-4 border-0 stat-card">
                <div class="card-body text-center py-4 px-3">
                    <i class="bi bi-exclamation-circle text-warning mb-2" style="font-size: 1.8rem;"></i>
                    <h6 class="text-uppercase text-muted mb-1 fw-semibold">Belum Selesai</h6>
                    <p class="h2 text-warning fw-bold mb-0">{{ $tugasBelum }}</p>
                    <div class="progress mt-2" style="height: 6px;">
                        <div class="progress-bar bg-warning" style="width: {{ ($tugasBelum / max($totalTugas,1)) * 100 }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Grafik --}}
    <div class="card shadow-lg rounded-4 mb-4 border-0" data-aos="fade-up">
        <div class="card-body px-3 py-4">
            <h5 class="mb-3 text-primary fw-semibold">📈 Visualisasi Tugas</h5>
            <canvas id="taskChart" height="130"></canvas>
        </div>
    </div>

    {{-- Notifikasi (opsional tambahkan di sini) --}}
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init();

    const ctx = document.getElementById('taskChart').getContext('2d');
    const taskChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Total Tugas', 'Tugas Selesai', 'Belum Selesai'],
            datasets: [{
                label: 'Jumlah Tugas',
                data: [{{ $totalTugas }}, {{ $tugasSelesai }}, {{ $tugasBelum }}],
                backgroundColor: [
                    'rgba(33, 150, 243, 0.8)',
                    'rgba(76, 175, 80, 0.8)',
                    'rgba(255, 193, 7, 0.8)'
                ],
                borderRadius: 10,
                maxBarThickness: 40,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#222',
                    titleFont: { size: 14, weight: 'bold' },
                    bodyFont: { size: 13 },
                    padding: 10,
                    cornerRadius: 8,
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });
</script>
@endpush

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
<style>
    body {
        background-color: #f4f8fc;
        font-family: 'Poppins', sans-serif;
    }

    .stat-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 18px rgba(0, 0, 0, 0.08);
    }

    .list-group-item {
        font-size: 1rem;
        transition: background-color 0.2s ease, transform 0.2s ease;
        cursor: pointer;
    }

    .list-group-item:hover {
        background-color: #e3f2fd;
        transform: scale(1.02);
    }

    @media (min-width: 992px) {
        .container {
            max-width: 850px !important;
        }
    }
</style>
@endpush
