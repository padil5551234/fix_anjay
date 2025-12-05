<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>@yield('title') &mdash; {{ config('app.name', 'Laravel') }}</title>
    <meta content="Website Tryout Online Platform" name="description">
    <meta content="Try Out Online, Ujian Online" name="keywords">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <!-- Favicons -->
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" rel="stylesheet">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('adminLTE') }}/plugins/toastr/toastr.min.css">

    <!-- Custom Main CSS File -->
    <link href="{{ asset('assets/css/custom-style.css') }}" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('adminLTE') }}/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('adminLTE') }}/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('adminLTE') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

    <!-- Midtrans Snap -->
    <script type="text/javascript"
        src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
        data-client-key="{{ config('midtrans.client_key') }}"></script>
    
    <style>
        .btn-primary {
            background-color: #8b5cf6;
            border-color: #8b5cf6;
        }

        .badge-primary {
            background-color: #8b5cf6;
        }

        .btn-primary:hover {
            background-color: #a855f7;
            border-color: #a855f7;
        }

        .btn-primary:active {
            background-color: #a855f7;
            border-color: #a855f7;
        }

        .btn-primary:disabled {
            background-color: #a855f7;
            border-color: #a855f7;
        }

        .form-group.required .control-label:after {
            content: " *";
            color: red;
        }

        .form-group.required .col-form-label:after {
            content: " *";
            color: red;
        }

    </style>

    @stack('links')
    @stack('styles')
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top d-flex align-items-center">
        <div class="container d-flex align-items-center justify-content-between">

            <div class="logo ">
                <h1>
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo Bimbel">
                        <span class="align-middle"> {{ config('app.name', 'Laravel') }}</span>
                    </a>
                </h1>
            </div>

            @include('layouts.user.navbar')

        </div>
    </header><!-- End Header -->

    <!-- ======= Hero Section ======= -->
    @yield('content')

    <!-- ======= Footer ======= -->
    <footer id="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row">

                    <div class="col-12">
                        <div class="footer-info">
                            <div class="d-flex flex-row">
                                <div class="col-lg-8">
                                    <h3><img src="{{ asset('img/logo.png') }}" alt="Logo Platform" width="5%" class="mb-2"> Try Out Online</h3>
                                    <p class="pb-3"><em>Platform try out online terpercaya yang menyediakan berbagai program Try Out dan Bimbingan untuk membantu para calon mahasiswa mempersiapkan ujian masuk perguruan tinggi. Kami menyediakan soal-soal berkualitas dan sistem evaluasi yang komprehensif untuk mendukung persiapan ujian yang optimal.</em></p>
                                </div>
                                <div class="col-lg-1"></div>
                                <div class="col-lg-3 mt-5">
                                    <p class="mt-4">
                                        Jalan Otto Iskandar Dinata 64C <br>
                                        Jakarta Timur, DKI Jakarta<br><br>
                                        <strong>Email:</strong> <a style="color: inherit;" href="mailto:admin@tryout-online.com">admin@tryout-online.com</a><br>
                                    </p>
                                    <div class="social-links mt-3">
                                        <a href="https://www.whatsapp.com/channel/0029Vb6tAJ97IUYPkGCzF43g" target="_blank" class="twitter"><i class="bx bxl-whatsapp"></i></a>
                                        <a href="https://twitter.com/TryOutOnline" target="_blank" class="twitter"><i class="bx bxl-twitter"></i></a>
                                        <a href="https://www.facebook.com/BimbelSTIS/" target="_blank" class="facebook"><i class="bx bxl-facebook"></i></a>
                                        <a href="https://www.instagram.com/bocah_kedinasan/" target="_blank" class="instagram"><i class="bx bxl-instagram"></i></a>
                                        <a href="https://www.youtube.com/@BimbelStis" target="_blank" class="youtube"><i class="bx bxl-youtube"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="copyright">
                Copyright &copy; Try Out Online Platform 2025
            </div>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <!-- jQuery -->
    <script src="{{ asset('adminLTE') }}/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Custom Main JS File -->
    <script src="{{ asset('assets/js/custom-main.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('adminLTE') }}/plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="{{ asset('adminLTE') }}/plugins/toastr/toastr.min.js"></script>
    <!-- Select2 -->
    <script src="{{ asset('adminLTE') }}/plugins/select2/js/select2.full.min.js"></script>
    <!-- Alpinejs -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js"></script>
    <script>
        toastr.options = {
            "positionClass": "toast-bottom-right"
        };

    </script>

    @stack('scripts')
</body>

</html>
