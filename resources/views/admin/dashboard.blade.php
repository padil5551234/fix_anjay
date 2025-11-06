@extends('layouts/admin/app')

@section('title')
Dashboard
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="container-fluid dashboard-modern">
    <!-- Statistics Cards Row -->
    <div class="row g-4 mb-4">
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
            <div class="stats-card stats-card-primary">
                <div class="stats-card-body">
                    <div class="stats-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stats-content">
                        <h6 class="stats-label">Total Users</h6>
                        <h2 class="stats-value">{{ $data['user'] }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
            <div class="stats-card stats-card-success">
                <div class="stats-card-body">
                    <div class="stats-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="stats-content">
                        <h6 class="stats-label">Total Paket Kedinasan</h6>
                        <h2 class="stats-value">{{ $data['paketUjian'] }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
            <div class="stats-card stats-card-info">
                <div class="stats-card-body">
                    <div class="stats-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <div class="stats-content">
                        <h6 class="stats-label">Total Ujian</h6>
                        <h2 class="stats-value">{{ $data['ujian'] }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row Statistics -->
    <div class="row g-4 mb-4">
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
            <div class="stats-card stats-card-warning">
                <div class="stats-card-body">
                    <div class="stats-icon">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <div class="stats-content">
                        <h6 class="stats-label">Ujian Aktif</h6>
                        <h2 class="stats-value">{{ $data['ujianActive'] }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
            <div class="stats-card stats-card-danger">
                <div class="stats-card-body">
                    <div class="stats-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="stats-content">
                        <h6 class="stats-label">Total Pembelian</h6>
                        <h2 class="stats-value">{{ $data['pembelian'] }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
            <div class="stats-card stats-card-secondary">
                <div class="stats-card-body">
                    <div class="stats-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stats-content">
                        <h6 class="stats-label">Revenue Total</h6>
                        <h2 class="stats-value">Rp {{ number_format($data['revenue'] ?? 0, 0, ',', '.') }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Info Section -->
    <div class="row">
        <div class="col-12">
            <div class="card modern-card">
                <div class="card-header modern-card-header">
                    <h4 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Statistik Sistem</h4>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3 mb-3">
                            <div class="info-box">
                                <i class="fas fa-user-graduate fa-2x text-primary mb-2"></i>
                                <h5>{{ $data['user'] }}</h5>
                                <p class="text-muted mb-0">Peserta Terdaftar</p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="info-box">
                                <i class="fas fa-file-alt fa-2x text-success mb-2"></i>
                                <h5>{{ $data['ujian'] }}</h5>
                                <p class="text-muted mb-0">Total Ujian</p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="info-box">
                                <i class="fas fa-check-circle fa-2x text-warning mb-2"></i>
                                <h5>{{ $data['ujianActive'] }}</h5>
                                <p class="text-muted mb-0">Ujian Berlangsung</p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="info-box">
                                <i class="fas fa-credit-card fa-2x text-danger mb-2"></i>
                                <h5>{{ $data['pembelian'] }}</h5>
                                <p class="text-muted mb-0">Transaksi Sukses</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .dashboard-modern {
        padding: 20px 0;
    }

    .stats-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        padding: 0;
        border: none;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .stats-card-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .stats-card-success {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    }

    .stats-card-info {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }

    .stats-card-warning {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    }

    .stats-card-danger {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .stats-card-secondary {
        background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
    }

    .stats-card-body {
        padding: 25px;
        display: flex;
        align-items: center;
        gap: 20px;
        position: relative;
        z-index: 2;
    }

    .stats-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        z-index: 1;
    }

    .stats-icon {
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .stats-icon i {
        font-size: 28px;
        color: #ffffff;
    }

    .stats-content {
        flex: 1;
        color: #ffffff;
    }

    .stats-label {
        font-size: 13px;
        font-weight: 500;
        margin-bottom: 5px;
        opacity: 0.9;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stats-value {
        font-size: 32px;
        font-weight: 700;
        margin: 0;
        line-height: 1.2;
    }

    .modern-card {
        border-radius: 15px;
        border: none;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .modern-card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px 15px 0 0;
        padding: 20px 25px;
        border: none;
        color: #ffffff;
    }

    .modern-card-header h4 {
        color: #ffffff;
        margin: 0;
        font-weight: 600;
    }

    .info-box {
        padding: 20px;
        border-radius: 10px;
        background: #f8f9fa;
        transition: all 0.3s ease;
    }

    .info-box:hover {
        background: #e9ecef;
        transform: translateY(-3px);
    }

    .info-box h5 {
        font-size: 28px;
        font-weight: 700;
        color: #2c3e50;
        margin: 10px 0;
    }

    .info-box p {
        font-size: 13px;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .stats-card-body {
            flex-direction: column;
            text-align: center;
            padding: 20px;
        }

        .stats-value {
            font-size: 28px;
        }

        .stats-icon {
            width: 50px;
            height: 50px;
        }

        .stats-icon i {
            font-size: 24px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Add animation to statistics cards
    $('.stats-card').each(function(i) {
        $(this).css('opacity', '0');
        $(this).delay(100 * i).animate({
            opacity: 1
        }, 500);
    });
});
</script>
@endpush
