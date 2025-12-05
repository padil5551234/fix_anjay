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
            <div class="stats-card stats-card-violet">
                <div class="stats-card-shimmer"></div>
                <div class="stats-card-body">
                    <div class="stats-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stats-content">
                        <h6 class="stats-label">Total Users</h6>
                        <h2 class="stats-value">{{ $data['user'] }}</h2>
                        <p class="stats-subtitle">↑ 12% from last month</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
            <div class="stats-card stats-card-cyan">
                <div class="stats-card-shimmer"></div>
                <div class="stats-card-body">
                    <div class="stats-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="stats-content">
                        <h6 class="stats-label">Paket Kedinasan</h6>
                        <h2 class="stats-value">{{ $data['paketUjian'] }}</h2>
                        <p class="stats-subtitle">Active packages</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
            <div class="stats-card stats-card-pink">
                <div class="stats-card-shimmer"></div>
                <div class="stats-card-body">
                    <div class="stats-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <div class="stats-content">
                        <h6 class="stats-label">Total Ujian</h6>
                        <h2 class="stats-value">{{ $data['ujian'] }}</h2>
                        <p class="stats-subtitle">Available exams</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row Statistics -->
    <div class="row g-4 mb-4">
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
            <div class="stats-card stats-card-coral">
                <div class="stats-card-shimmer"></div>
                <div class="stats-card-body">
                    <div class="stats-icon">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <div class="stats-content">
                        <h6 class="stats-label">Ujian Aktif</h6>
                        <h2 class="stats-value">{{ $data['ujianActive'] }}</h2>
                        <p class="stats-subtitle">Live now</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
            <div class="stats-card stats-card-purple">
                <div class="stats-card-shimmer"></div>
                <div class="stats-card-body">
                    <div class="stats-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="stats-content">
                        <h6 class="stats-label">Total Pembelian</h6>
                        <h2 class="stats-value">{{ $data['pembelian'] }}</h2>
                        <p class="stats-subtitle">Transactions</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
            <div class="stats-card stats-card-lime">
                <div class="stats-card-shimmer"></div>
                <div class="stats-card-body">
                    <div class="stats-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stats-content">
                        <h6 class="stats-label">Revenue Total</h6>
                        <h2 class="stats-value">Rp {{ number_format($data['revenue'] ?? 0, 0, ',', '.') }}</h2>
                        <p class="stats-subtitle">This period</p>
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
                    <h4 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Statistik Sistem Overview</h4>
                    <p class="header-subtitle mb-0">Real-time dashboard analytics</p>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3 mb-3">
                            <div class="info-box info-box-1">
                                <div class="info-box-icon">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                                <h5>{{ $data['user'] }}</h5>
                                <p class="text-muted mb-0">Peserta Terdaftar</p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="info-box info-box-2">
                                <div class="info-box-icon">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <h5>{{ $data['ujian'] }}</h5>
                                <p class="text-muted mb-0">Total Ujian</p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="info-box info-box-3">
                                <div class="info-box-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <h5>{{ $data['ujianActive'] }}</h5>
                                <p class="text-muted mb-0">Ujian Berlangsung</p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="info-box info-box-4">
                                <div class="info-box-icon">
                                    <i class="fas fa-credit-card"></i>
                                </div>
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
    :root {
        --color-violet: #7C3AED;
        --color-violet-light: #A78BFA;
        --color-cyan: #06B6D4;
        --color-cyan-light: #22D3EE;
        --color-pink: #EC4899;
        --color-pink-light: #F472B6;
        --color-coral: #FF6B6B;
        --color-coral-light: #FF8C8C;
        --color-purple: #A855F7;
        --color-purple-light: #D8B4FE;
        --color-lime: #10B981;
        --color-lime-light: #34D399;
        --color-light-bg: #F8FAFC;
        --color-light-card: #FFFFFF;
        --color-light-border: #E2E8F0;
    }

    .dashboard-modern {
        padding: 30px 0;
        background: linear-gradient(135deg, #F8FAFC 0%, #F1F5F9 100%);
        min-height: 100vh;
    }

    /* Statistics Cards */
    .stats-card {
        background: #FFFFFF;
        border-radius: 20px;
        padding: 0;
        border: 1px solid #E2E8F0;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        overflow: hidden;
        position: relative;
        backdrop-filter: blur(10px);
    }

    .stats-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.12);
        border-color: #CBD5E1;
    }

    .stats-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 250px;
        height: 250px;
        border-radius: 50%;
        opacity: 0.08;
        z-index: 1;
    }

    .stats-card-violet { --gradient-color: var(--color-violet); }
    .stats-card-violet::before { background: var(--color-violet); }
    .stats-card-violet .stats-card-shimmer { background: linear-gradient(135deg, var(--color-violet) 0%, var(--color-violet-light) 100%); }

    .stats-card-cyan { --gradient-color: var(--color-cyan); }
    .stats-card-cyan::before { background: var(--color-cyan); }
    .stats-card-cyan .stats-card-shimmer { background: linear-gradient(135deg, var(--color-cyan) 0%, var(--color-cyan-light) 100%); }

    .stats-card-pink { --gradient-color: var(--color-pink); }
    .stats-card-pink::before { background: var(--color-pink); }
    .stats-card-pink .stats-card-shimmer { background: linear-gradient(135deg, var(--color-pink) 0%, var(--color-pink-light) 100%); }

    .stats-card-coral { --gradient-color: var(--color-coral); }
    .stats-card-coral::before { background: var(--color-coral); }
    .stats-card-coral .stats-card-shimmer { background: linear-gradient(135deg, var(--color-coral) 0%, var(--color-coral-light) 100%); }

    .stats-card-purple { --gradient-color: var(--color-purple); }
    .stats-card-purple::before { background: var(--color-purple); }
    .stats-card-purple .stats-card-shimmer { background: linear-gradient(135deg, var(--color-purple) 0%, var(--color-purple-light) 100%); }

    .stats-card-lime { --gradient-color: var(--color-lime); }
    .stats-card-lime::before { background: var(--color-lime); }
    .stats-card-lime .stats-card-shimmer { background: linear-gradient(135deg, var(--color-lime) 0%, var(--color-lime-light) 100%); }

    .stats-card-shimmer {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        z-index: 3;
        opacity: 0;
        animation: shimmer 3s infinite;
    }

    @keyframes shimmer {
        0%, 100% { opacity: 0; }
        50% { opacity: 1; }
    }

    .stats-card-body {
        padding: 28px;
        display: flex;
        align-items: center;
        gap: 20px;
        position: relative;
        z-index: 2;
    }

    .stats-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, rgba(124, 58, 237, 0.1) 0%, rgba(124, 58, 237, 0.05) 100%);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border: 1px solid rgba(124, 58, 237, 0.15);
        backdrop-filter: blur(10px);
    }

    .stats-icon i {
        font-size: 32px;
        background: linear-gradient(135deg, var(--gradient-color) 0%, var(--gradient-color) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .stats-content {
        flex: 1;
        color: #1E293B;
        text-align: left;
    }

    .stats-label {
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 8px;
        opacity: 0.7;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #64748B;
    }

    .stats-value {
        font-size: 36px;
        font-weight: 800;
        margin: 0;
        line-height: 1.1;
        background: linear-gradient(135deg, var(--gradient-color) 0%, rgba(30, 41, 59, 0.8) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .stats-subtitle {
        font-size: 11px;
        color: #94A3B8;
        margin: 8px 0 0 0;
        font-weight: 500;
    }

    /* Modern Card */
    .modern-card {
        border-radius: 20px;
        border: 1px solid #E2E8F0;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        background: #FFFFFF;
        backdrop-filter: blur(10px);
        overflow: hidden;
    }

    .modern-card-header {
        background: linear-gradient(135deg, var(--color-violet) 0%, var(--color-cyan) 100%);
        border-radius: 0;
        padding: 28px 32px;
        border: none;
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .modern-card-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .modern-card-header h4 {
        color: #ffffff;
        margin: 0;
        font-weight: 700;
        font-size: 24px;
        position: relative;
        z-index: 2;
    }

    .header-subtitle {
        color: rgba(255, 255, 255, 0.9);
        font-size: 13px;
        font-weight: 500;
        position: relative;
        z-index: 2;
    }

    .modern-card .card-body {
        padding: 32px;
        background: #F8FAFC;
    }

    /* Info Boxes */
    .info-box {
        padding: 28px;
        border-radius: 16px;
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        backdrop-filter: blur(10px);
        position: relative;
        overflow: hidden;
    }

    .info-box::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        opacity: 0.05;
    }

    .info-box:hover {
        background: #F8FAFC;
        transform: translateY(-6px);
        border-color: #CBD5E1;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .info-box-1 { --icon-color: var(--color-violet); }
    .info-box-1::before { background: var(--color-violet); }

    .info-box-2 { --icon-color: var(--color-cyan); }
    .info-box-2::before { background: var(--color-cyan); }

    .info-box-3 { --icon-color: var(--color-pink); }
    .info-box-3::before { background: var(--color-pink); }

    .info-box-4 { --icon-color: var(--color-coral); }
    .info-box-4::before { background: var(--color-coral); }

    .info-box-icon {
        font-size: 42px;
        margin-bottom: 16px;
        background: linear-gradient(135deg, var(--icon-color) 0%, rgba(124, 58, 237, 0.6) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        position: relative;
        z-index: 2;
    }

    .info-box h5 {
        font-size: 32px;
        font-weight: 800;
        color: #1E293B;
        margin: 16px 0 8px 0;
        position: relative;
        z-index: 2;
    }

    .info-box p {
        font-size: 13px;
        font-weight: 600;
        color: #64748B;
        position: relative;
        z-index: 2;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .dashboard-modern {
            padding: 15px 0;
        }

        .stats-card-body {
            flex-direction: column;
            text-align: center;
            padding: 20px;
        }

        .stats-value {
            font-size: 28px;
        }

        .stats-icon {
            width: 60px;
            height: 60px;
        }

        .stats-icon i {
            font-size: 26px;
        }

        .stats-content {
            text-align: center;
        }

        .modern-card-header {
            padding: 20px 24px;
        }

        .modern-card-header h4 {
            font-size: 18px;
        }

        .header-subtitle {
            font-size: 12px;
        }

        .modern-card .card-body {
            padding: 20px;
        }

        .info-box {
            padding: 20px;
        }

        .info-box h5 {
            font-size: 24px;
        }

        .info-box-icon {
            font-size: 32px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Smooth entrance animation
    $('.stats-card').each(function(i) {
        $(this).css({
            'opacity': '0',
            'transform': 'translateY(30px)'
        });
        $(this).delay(100 * i).animate({
            opacity: 1
        }, 800, function() {
            $(this).css('transform', 'translateY(0)');
        });
    });

    // Info box stagger animation
    $('.info-box').each(function(i) {
        $(this).css({
            'opacity': '0',
            'transform': 'scale(0.9)'
        });
        $(this).delay(1200 + 100 * i).animate({
            opacity: 1
        }, 600, function() {
            $(this).css('transform', 'scale(1)');
        });
    });

    // Count up effect for numbers
    function countUp(element, target, duration = 2000) {
        let current = 0;
        let increment = target / (duration / 16);
        let timer = setInterval(function() {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            $(element).text(Math.floor(current).toLocaleString());
        }, 16);
    }

    // Trigger count up when cards come into view
    let counted = false;
    $(window).on('scroll', function() {
        if (!counted && $('.stats-value').length > 0) {
            let cardOffset = $('.stats-card').first().offset().top;
            let windowOffset = $(window).scrollTop() + $(window).height();
            if (windowOffset > cardOffset) {
                counted = true;
                // Uncomment below to enable count-up animation
                // $('.stats-value').each(function() {
                //     let value = parseInt($(this).text().replace(/\D/g, ''));
                //     countUp(this, value);
                // });
            }
        }
    });
});
</script>
@endpush