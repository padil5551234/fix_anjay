@extends('layouts.user.app')

@section('title')
    Dashboard
@endsection

@section('content')\
<section id="hero" style="background: url('{{ asset('img/gambar_landing.png') }}') center/cover no-repeat fixed; position: relative;">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-7 pt-5 pt-lg-0 order-2 order-lg-1 d-flex align-items-center">
                <div data-aos="zoom-out">
                    <h1>DinasSolution</h1>
                    <h2>Bimbel Kedinasan Terbaik di Indonesia</h2>
                    <h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</h2>

                    
                    <div class="text-center text-lg-start">
                        <a href="#pricing" class="btn-get-started scrollto">Show More</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 order-1 order-lg-2 hero-img" data-aos="zoom-out" data-aos-delay="300">
                <img src="{{ asset('img/hero-img.png') }}" class="img-fluid animated" alt="Hero Image">
            </div>
        </div>
    </div>
</section><!-- End Hero -->

<main id="main">
    <!-- ======= About Section ======= -->
    <section id="about" class="about">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-5 col-lg-6 video-box d-flex justify-content-center align-items-stretch" data-aos="fade-right" style="position: relative; overflow: hidden;">
                    <img src="{{ asset('img/about-stis.jpg') }}" class="img-fluid" alt="DinasSolution - Bimbel Kedinasan" style="object-fit: cover; width: 100%; height: 100%; min-height: 400px; border-radius: 10px;">
                    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(135deg, rgba(67, 97, 238, 0.1) 0%, transparent 100%);"></div>
                </div>
                <div class="col-xl-7 col-lg-6 icon-boxes d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5" data-aos="fade-left">
                    <h3>Kenapa harus DinasSolution</h3>
                    <p>DinasSolution merupakan sarana dalam menunjang para peserta untuk masuk sekolah kedinasan yang terdiri atas <b>TRYOUT</b> dengan 3 gelombang dan <b>KELAS</b>. Dapatkan gambaran soal yang akurat dan persiapan yang matang untuk seleksi masuk Sekolah kedinasan pilihan.</p>

                    <div class="icon-box" data-aos="zoom-in" data-aos-delay="100">
                        <div class="icon"><i class="bx bx-notepad"></i></div>
                        <h4 class="title"><a href="#">Soal Dibuat Langsung OLEH MAHASISWA POLSTAT STIS</a></h4>
                        <p class="description">Soal akurat karena dibuat langsung oleh mahasiswa Polstat STIS yang berpengalaman mengerjakan soal asli SPMB Polstat STIS baik SKD maupun Matematika</p>
                    </div>

                    <div class="icon-box" data-aos="zoom-in" data-aos-delay="200">
                        <div class="icon"><i class="bx bx-desktop"></i></div>
                        <h4 class="title"><a href="">Pengerjaan Online Dengan Sistem CAT</a></h4>
                        <p class="description">Pengerjaan dilakukan secara daring dengan menggunakan sistem CAT (Computer Assisted Test) sehingga menyerupai sistem ujian yang sebenarnya</p>
                    </div>

                    <div class="icon-box" data-aos="zoom-in" data-aos-delay="300">
                        <div class="icon"><i class="bx bx-money-withdraw"></i></div>
                        <h4 class="title"><a href="">Harga Terjangkau</a></h4>
                        <p class="description">Dengan harga terjangkau, kamu bisa mendapatkan Try Out dan bimbingan yang berkualitas dan bermutu</p>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End About Section -->

    <!-- ======= Counts Section ======= -->
    <section id="counts" class="counts">
        <div class="container">
            <div class="row" data-aos="fade-up">
                <div class="col-lg-3 col-md-6">
                    <div class="count-box">
                        <i class="bi bi-journal-text"></i>
                        <span data-purecounter-start="0" data-purecounter-end="500" data-purecounter-duration="1" class="purecounter"></span>
                        <p>Soal berkualitas yang disiapkan oleh Mahasiswa Polstat STIS</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mt-5 mt-md-0">
                    <div class="count-box">
                        <i class="bi bi-mortarboard-fill"></i>
                        <span data-purecounter-start="0" data-purecounter-end="36" data-purecounter-duration="1" class="purecounter"></span>
                        <p>Pengajar yang merupakan Mahasiswa Polstat STIS</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mt-5 mt-lg-0">
                    <div class="count-box">
                        <i class="bi bi-people"></i>
                        <span data-purecounter-start="0" data-purecounter-end="10000" data-purecounter-duration="1" class="purecounter"></span>
                        <p>Pejuang Kedinasan telah mempercayakan Try Out dan bimbingan masuk kedinasan bersama Kami</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mt-5 mt-lg-0">
                    <div class="count-box">
                        <i class="bi bi-award-fill"></i>
                        <span data-purecounter-start="0" data-purecounter-end="15" data-purecounter-duration="1" class="purecounter"></span>
                        <p>tahun berpengalaman menyelenggarakan Try Out dan Bimbingan masuk Polstat STIS dan kedinasan lainnya.</p>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End Counts Section -->

    <!-- ======= Testimonials Section ======= -->
    <section id="testimonials" class="testimonials">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>Testimoni</h2>
                <p>Apa Kata Alumni Kami</p>
            </div>

            <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000" data-aos="fade-up" data-aos-delay="100">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
                </div>

                <div class="carousel-inner">
                    <!-- Slide 1 - 3 Testimoni -->
                    <div class="carousel-item active">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="testimonial-card">
                                    <div class="testimonial-content">
                                        <i class="bx bxs-quote-alt-left quote-icon"></i>
                                        <p class="testimonial-text">
                                            "Try out di DinasSolution sangat membantu persiapan saya. Soal-soalnya mirip dengan ujian asli SPMB STIS. Alhamdulillah sekarang saya sudah mahasiswa STIS!"
                                        </p>
                                    </div>
                                    <div class="testimonial-author">
                                        <img src="{{ asset('img/testimonial-1.jpg') }}" alt="Ahmad Ridwan">
                                        <div class="author-info">
                                            <h4>Ahmad Ridwan</h4>
                                            <p>Mahasiswa STIS Angkatan 66</p>
                                            <div class="stars">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="testimonial-card">
                                    <div class="testimonial-content">
                                        <i class="bx bxs-quote-alt-left quote-icon"></i>
                                        <p class="testimonial-text">
                                            "Mentor-mentornya sabar dan profesional. Materi yang diajarkan sangat terstruktur dan mudah dipahami. Recommended banget untuk persiapan kedinasan!"
                                        </p>
                                    </div>
                                    <div class="testimonial-author">
                                        <img src="{{ asset('img/testimonial-2.jpg') }}" alt="Siti Nurhaliza">
                                        <div class="author-info">
                                            <h4>Siti Nurhaliza</h4>
                                            <p>Mahasiswa PKN STAN 2024</p>
                                            <div class="stars">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="testimonial-card">
                                    <div class="testimonial-content">
                                        <i class="bx bxs-quote-alt-left quote-icon"></i>
                                        <p class="testimonial-text">
                                            "Harga terjangkau dengan kualitas premium. Sistem CAT-nya membuat saya terbiasa dengan ujian sebenarnya. Terima kasih DinasSolution!"
                                        </p>
                                    </div>
                                    <div class="testimonial-author">
                                        <img src="{{ asset('img/testimonial-3.jpg') }}" alt="Budi Santoso">
                                        <div class="author-info">
                                            <h4>Budi Santoso</h4>
                                            <p>Mahasiswa IPDN 2024</p>
                                            <div class="stars">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-half"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2 - 3 Testimoni Lainnya -->
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="testimonial-card">
                                    <div class="testimonial-content">
                                        <i class="bx bxs-quote-alt-left quote-icon"></i>
                                        <p class="testimonial-text">
                                            "Pembahasan soal-soalnya sangat detail dan mudah dipahami. Saya yang awalnya lemah di matematika jadi lebih percaya diri menghadapi SPMB!"
                                        </p>
                                    </div>
                                    <div class="testimonial-author">
                                        <img src="{{ asset('img/testimonial-4.jpg') }}" alt="Rina Fitriani">
                                        <div class="author-info">
                                            <h4>Rina Fitriani</h4>
                                            <p>Mahasiswa STIS Angkatan 65</p>
                                            <div class="stars">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="testimonial-card">
                                    <div class="testimonial-content">
                                        <i class="bx bxs-quote-alt-left quote-icon"></i>
                                        <p class="testimonial-text">
                                            "Try out rutin setiap minggu membuat saya terlatih mengatur waktu. Sistem ranking juga memotivasi saya untuk terus belajar lebih giat!"
                                        </p>
                                    </div>
                                    <div class="testimonial-author">
                                        <img src="{{ asset('img/testimonial-5.jpg') }}" alt="Dimas Prasetyo">
                                        <div class="author-info">
                                            <h4>Dimas Prasetyo</h4>
                                            <p>Mahasiswa STIN 2024</p>
                                            <div class="stars">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="testimonial-card">
                                    <div class="testimonial-content">
                                        <i class="bx bxs-quote-alt-left quote-icon"></i>
                                        <p class="testimonial-text">
                                            "Grup WhatsApp sangat membantu untuk diskusi soal. Kakak mentor juga responsif menjawab pertanyaan. Worth it banget!"
                                        </p>
                                    </div>
                                    <div class="testimonial-author">
                                        <img src="{{ asset('img/testimonial-6.jpg') }}" alt="Anisa Putri">
                                        <div class="author-info">
                                            <h4>Anisa Putri</h4>
                                            <p>Mahasiswa AIM 2024</p>
                                            <div class="stars">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 3 - 3 Testimoni Lainnya -->
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="testimonial-card">
                                    <div class="testimonial-content">
                                        <i class="bx bxs-quote-alt-left quote-icon"></i>
                                        <p class="testimonial-text">
                                            "Materi SKD-nya lengkap banget! TWK, TIU, TKP semuanya dibahas sampai tuntas. Saya lolos di tahap SKD berkat bimbingan di sini."
                                        </p>
                                    </div>
                                    <div class="testimonial-author">
                                        <img src="{{ asset('img/testimonial-7.jpg') }}" alt="Farhan Maulana">
                                        <div class="author-info">
                                            <h4>Farhan Maulana</h4>
                                            <p>Mahasiswa IPDN 2024</p>
                                            <div class="stars">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-half"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="testimonial-card">
                                    <div class="testimonial-content">
                                        <i class="bx bxs-quote-alt-left quote-icon"></i>
                                        <p class="testimonial-text">
                                            "Tips dan trik dari kakak mentor sangat membantu! Strategi mengerjakan soal yang diajarkan terbukti efektif saat ujian sebenarnya."
                                        </p>
                                    </div>
                                    <div class="testimonial-author">
                                        <img src="{{ asset('img/testimonial-8.jpg') }}" alt="Dewi Sartika">
                                        <div class="author-info">
                                            <h4>Dewi Sartika</h4>
                                            <p>Mahasiswa POLTEKIP 2024</p>
                                            <div class="stars">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="testimonial-card">
                                    <div class="testimonial-content">
                                        <i class="bx bxs-quote-alt-left quote-icon"></i>
                                        <p class="testimonial-text">
                                            "Platform online-nya user friendly dan mudah diakses. Bisa belajar kapan saja dan dimana saja. Sangat cocok untuk yang sibuk seperti saya!"
                                        </p>
                                    </div>
                                    <div class="testimonial-author">
                                        <img src="{{ asset('img/testimonial-9.jpg') }}" alt="Rizki Firmansyah">
                                        <div class="author-info">
                                            <h4>Rizki Firmansyah</h4>
                                            <p>Mahasiswa PKN STAN 2024</p>
                                            <div class="stars">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 4 - 3 Testimoni Tambahan -->
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="testimonial-card">
                                    <div class="testimonial-content">
                                        <i class="bx bxs-quote-alt-left quote-icon"></i>
                                        <p class="testimonial-text">
                                            "Belajar di DinasSolution benar-benar membuka wawasan saya. Dari yang tidak tahu apa-apa, sekarang saya sudah mahasiswa kedinasan impian!"
                                        </p>
                                    </div>
                                    <div class="testimonial-author">
                                        <img src="{{ asset('img/testimonial-10.jpg') }}" alt="Linda Permata">
                                        <div class="author-info">
                                            <h4>Linda Permata</h4>
                                            <p>Mahasiswa STSN 2024</p>
                                            <div class="stars">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="testimonial-card">
                                    <div class="testimonial-content">
                                        <i class="bx bxs-quote-alt-left quote-icon"></i>
                                        <p class="testimonial-text">
                                            "Investasi terbaik untuk masa depan! Dengan biaya yang terjangkau, saya mendapat bimbingan berkualitas dan akhirnya lolos SPMB."
                                        </p>
                                    </div>
                                    <div class="testimonial-author">
                                        <img src="{{ asset('img/testimonial-11.jpg') }}" alt="Yoga Aditama">
                                        <div class="author-info">
                                            <h4>Yoga Aditama</h4>
                                            <p>Mahasiswa STMKG 2024</p>
                                            <div class="stars">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="testimonial-card">
                                    <div class="testimonial-content">
                                        <i class="bx bxs-quote-alt-left quote-icon"></i>
                                        <p class="testimonial-text">
                                            "Sistem pembelajaran terstruktur dan terarah. Bank soalnya lengkap dan selalu update. Sukses terus DinasSolution!"
                                        </p>
                                    </div>
                                    <div class="testimonial-author">
                                        <img src="{{ asset('img/testimonial-12.jpg') }}" alt="Maya Safitri">
                                        <div class="author-info">
                                            <h4>Maya Safitri</h4>
                                            <p>Mahasiswa POLTEKIM 2024</p>
                                            <div class="stars">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-half"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section><!-- End Testimonials Section -->

    <!-- ======= Pricing Section ======= -->
    <section id="pricing" class="pricing">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>Daftar</h2>
                <p>Pilihan Paket Kedinasan</p>
            </div>

            <div class="row" data-aos="fade-left">
                @if ($pakets->isEmpty())
                    <div class="alert alert-primary" role="alert">Paket Ujian belum tersedia</div>
                @else
                    @foreach ($pakets as $paket)
                        <div class="col-lg-4 col-md-6 mt-4 mb-4 mt-lg-0">
                            <div class="box" data-aos="zoom-in" data-aos-delay="400">
                                @if ($paket->id == '03dfc817-3ee3-404c-b162-e1a4acb8ff73')
                                    <span class="advanced">Terlaris</span>
                                @endif
                                <h3>{{ $paket->nama }}</h3>
                                <h4><sup>Rp</sup>{{ number_format($paket->harga, 0, ',', '.') }}</h4>
                                {!! $paket->deskripsi !!}
                                <div class="btn-wrap">
                                    @if ($paket->pembelian->isEmpty() || !auth()->check())
                                        @if (Carbon\Carbon::now()->between($paket->waktu_mulai, $paket->waktu_akhir))
                                            <form method="post" action="{{ route('pembelian.store') }}">
                                                @csrf
                                                @method('post')
                                                <input type="hidden" name="paket_id" value="{{ $paket->id }}">
                                                <button type="submit" class="btn-buy">Beli Paket</button>
                                            </form>
                                        @else
                                            <button type="button" style="background-color: grey; border-color: black" class="btn-buy">Belum Tersedia</button>
                                        @endif
                                    @else
                                        @if($paket->whatsapp_group_link)
                                           <a href="{{ $paket->whatsapp_group_link }}" target="_blank" type="button" style="width: 10rem; border: 2px solid; border-color: black" class="btn-buy mb-2">Grup WA</a>
                                        @endif
                                        <a href="{{ route('tryout.index', $paket->id) }}" type="button" style="width: 10rem; background-color: grey; border: 2px solid; border-color: black" class="btn-buy">Lihat Paket</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section><!-- End Pricing Section -->

    <!-- ======= Tutor Section ======= -->
    <section id="tutors" class="tutors">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>Tentor Kami</h2>
                <p>Tim Pengajar Berpengalaman</p>
            </div>

            <div class="row" data-aos="fade-up" data-aos-delay="100">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="tutor-card">
                        <div class="tutor-image">
                            <img src="{{ asset('img/aulia.png') }}" alt="Kak aulia">
                        </div>
                        <div class="tutor-info text-center">
                            <h3>Kak Aulia</h3>
                            <p class="tutor-title">Mahasiswa STIS Angkatan 62</p>
                            <p class="tutor-desc">Spesialis Matematika dan SKD dengan pengalaman mengajar lebih dari 3 tahun</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="tutor-card">
                        <div class="tutor-image">
                            <img src="{{ asset('img/dicky.png') }}" alt="Kak Dicky">
                        </div>
                        <div class="tutor-info text-center">
                            <h3>Kak Dicky</h3>
                            <p class="tutor-title">Mahasiswa STIS Angkatan 62</p>
                            <p class="tutor-desc">Expert dalam persiapan SPMB STIS dan sekolah kedinasan lainnya</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="tutor-card">
                        <div class="tutor-image">
                            <img src="{{ asset('img/padil.png') }}" alt="Kak Padil">
                        </div>
                        <div class="tutor-info text-center">
                            <h3>Kak Padil</h3>
                            <p class="tutor-title">Mahasiswa STIS Angkatan 65</p>
                            <p class="tutor-desc">Berpengalaman dalam membimbing siswa lolos seleksi kedinasan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ======= Articles Section ======= -->
    @if (isset($articles) && $articles->count() > 0)
        <section id="articles" class="articles">
            <div class="container">
                <div class="section-title" data-aos="fade-up">
                    <h2>Artikel</h2>
                    <p>Tips & Strategi Belajar</p>
                </div>

                <!-- Featured Articles -->
                @if(isset($featuredArticles) && $featuredArticles->count() > 0)
                <div class="row mb-5" data-aos="fade-up" data-aos-delay="100">
                    <div class="col-lg-12">
                        <h3 class="mb-4">Artikel Unggulan</h3>
                    </div>
                    @foreach ($featuredArticles as $featured)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="tutor-card">
                                @if($featured->featured_image)
                                <div class="tutor-image">
                                    <img src="{{ asset('storage/' . $featured->featured_image) }}" alt="{{ $featured->title }}">
                                </div>
                                @endif
                                <div class="tutor-info">
                                    <h3>{{ $featured->title }}</h3>
                                    <p class="tutor-title">
                                        <span class="badge" style="background-color: var(--primary-color);">{{ ucfirst($featured->category) }}</span>
                                        <small class="text-muted">{{ $featured->formatted_published_date }}</small>
                                    </p>
                                    <p class="tutor-desc">{{ \Illuminate\Support\Str::limit(strip_tags($featured->excerpt), 100) }}</p>
                                    <a href="{{ route('articles.show', $featured->slug) }}" class="btn-buy" style="display: inline-block; padding: 8px 20px; margin-top: 10px;">Baca Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @endif

                <!-- All Articles -->
                <div class="row" data-aos="fade-up" data-aos-delay="100">
                    <div class="col-lg-12">
                        <h3 class="mb-4">{{ isset($featuredArticles) && $featuredArticles->count() > 0 ? 'Artikel Lainnya' : 'Artikel Terbaru' }}</h3>
                    </div>
                    @foreach ($articles as $article)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="tutor-card">
                                @if($article->featured_image)
                                <div class="tutor-image">
                                    <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}">
                                </div>
                                @endif
                                <div class="tutor-info">
                                    <h3>{{ $article->title }}</h3>
                                    <p class="tutor-title">
                                        <span class="badge" style="background-color: var(--primary-color);">{{ ucfirst($article->category) }}</span>
                                        <small class="text-muted">{{ $article->formatted_published_date }}</small>
                                    </p>
                                    <p class="tutor-desc">{{ \Illuminate\Support\Str::limit(strip_tags($article->excerpt), 100) }}</p>
                                    <a href="{{ route('articles.show', $article->slug) }}" class="btn-buy" style="display: inline-block; padding: 8px 20px; margin-top: 10px;">Baca Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-4" data-aos="fade-up" data-aos-delay="200">
                    <a href="{{ route('articles.index') }}" class="btn-buy" style="display: inline-block; padding: 12px 30px;">Lihat Semua Artikel</a>
                </div>
            </div>
        </section><!-- End Articles Section -->
    @endif

    <!-- ======= F.A.Q Section ======= -->
    @if ($faqs)
        <section id="faq" class="faq section-bg">
            <div class="container">
                <div class="section-title" data-aos="fade-up">
                    <h2>F.A.Q</h2>
                    <p>Frequently Asked Questions</p>
                </div>
                <div class="faq-list">
                    <ul>
                        @foreach ($faqs as $index => $faq)
                            @if ($index < 4)
                                <li data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                                    <i class="bx bx-help-circle icon-help"></i>
                                    <a data-bs-toggle="collapse" class="{{ $index > 0 ? 'collapsed' : 'collapse'}}" data-bs-target="#faq-list-{{ $index }}">{{ $faq->title }}
                                        <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i>
                                    </a>
                                    <div id="faq-list-{{ $index }}" class="collapse {{ $index == 0 ? 'show' : '' }}" data-bs-parent=".faq-list">
                                        <p>
                                            {!! $faq->content !!}
                                        </p>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                @if ($faqs->count() > 4)
                    <a data-aos="fade-up" data-aos-delay="{{ 5 * 100 }}" class="float-end mt-2" href="{{ route('faq.index') }}">
                        <h6><b>Lihat lainnya...</b></h6>
                    </a>
                @endif
            </div>
        </section><!-- End F.A.Q Section -->
    @endif

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>Contact</h2>
                <p>Contact Us</p>
            </div>

            <div class="row">
                <div class="col-lg-4" data-aos="fade-right" data-aos-delay="100">
                    <div class="info">
                        <div class="address">
                            <i class="bi bi-envelope"></i>
                            <h4>Email:</h4>
                            <p><a style="color: inherit;" href="mailto:ukmbimbel@stis.ac.id">ukmbimbel@stis.ac.id</a></p>
                        </div>

                        <div class="phone">
                            <i class="bi bi-phone"></i>
                            <h4>Contact Person 1:</h4>
                            <p><a style="color: inherit;" target="_blank" href="https://wa.me/6288232397969?text=Halo,%20saya%20ingin%20berkonsultasi%20tentang%20tryout">088232397969 (Anin) - WhatsApp untuk Konsultasi</a></p>
                        </div>

                        <div class="phone">
                            <i class="bi bi-phone"></i>
                            <h4>Contact Person 2:</h4>
                            <p><a style="color: inherit;" target="_blank" href="https://wa.me/6283195559334?text=Halo,%20saya%20ingin%20berkonsultasi%20tentang%20tryout">083195559334 (Mizan) - WhatsApp untuk Konsultasi</a></p>
                        </div>

                        <div class="phone">
                            <i class="bi bi-phone"></i>
                            <h4>Contact Person 3:</h4>
                            <p><a style="color: inherit;" target="_blank" href="https://wa.me/6281914952169?text=Halo,%20saya%20ingin%20berkonsultasi%20tentang%20tryout">081914952169 (Dinur) - WhatsApp untuk Konsultasi</a></p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 mt-5 mt-lg-0" data-aos="fade-left" data-aos-delay="200">
                    <form action="{{ route('sendEmail') }}" method="post" role="form" class="php-email-form">
                        @csrf
                        @method('post')
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <input type="text" name="name" class="form-control" id="name" placeholder="Nama Lengkap" required>
                            </div>
                            <div class="col-md-6 form-group mt-3 mt-md-0">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <input type="text" class="form-control" name="subject" id="subject" placeholder="Judul" required>
                        </div>
                        <div class="form-group mt-3">
                            <textarea class="form-control" name="message" rows="5" placeholder="Pesan" required></textarea>
                        </div>
                        <div class="my-3">
                            <div class="loading">Menunggu</div>
                            <div class="error-message"></div>
                            <div class="sent-message">Pesanmu telah terkirim, terimakasih!</div>
                        </div>
                        <div class="text-center">
                            <button type="submit">Kirim Pesan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section><!-- End Contact Section -->
</main><!-- End #main -->
@endsection

@push('styles')
<style>
/* Testimonials Section */
.testimonials {
    padding: 80px 0;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    position: relative;
    overflow: hidden;
}

.testimonials::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="%23933aea" opacity="0.03"/><circle cx="75" cy="75" r="1" fill="%23933aea" opacity="0.03"/><circle cx="50" cy="10" r="0.5" fill="%23933aea" opacity="0.02"/><circle cx="10" cy="50" r="0.5" fill="%23933aea" opacity="0.02"/><circle cx="90" cy="30" r="0.5" fill="%23933aea" opacity="0.02"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    pointer-events: none;
}

.testimonial-card {
    background: #fff;
    padding: 35px;
    border-radius: 20px;
    box-shadow: 0 8px 32px rgba(147, 51, 234, 0.1);
    height: 100%;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    border: 1px solid rgba(147, 51, 234, 0.08);
    position: relative;
    overflow: hidden;
}

.testimonial-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--primary-color), var(--primary-hover));
    transform: scaleX(0);
    transition: transform 0.3s ease;
}

.testimonial-card:hover::before {
    transform: scaleX(1);
}

.testimonial-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 20px 60px rgba(147, 51, 234, 0.15);
}

.testimonial-content {
    position: relative;
    margin-bottom: 25px;
}

.quote-icon {
    font-size: 36px;
    color: var(--primary-color);
    opacity: 0.6;
    margin-bottom: 15px;
    transition: all 0.3s ease;
}

.testimonial-card:hover .quote-icon {
    opacity: 1;
    transform: scale(1.1);
}

.testimonial-text {
    font-style: italic;
    color: #555;
    line-height: 1.7;
    margin-bottom: 0;
    font-size: 16px;
    font-weight: 400;
    position: relative;
}

.testimonial-text::before {
    content: '"';
    font-size: 60px;
    color: rgba(147, 51, 234, 0.1);
    position: absolute;
    top: -20px;
    left: -15px;
    font-family: 'Georgia', serif;
}

.testimonial-text::after {
    content: '"';
    font-size: 60px;
    color: rgba(147, 51, 234, 0.1);
    position: absolute;
    bottom: -40px;
    right: -15px;
    font-family: 'Georgia', serif;
}

.testimonial-author {
    display: flex;
    align-items: center;
    padding-top: 25px;
    border-top: 2px solid rgba(147, 51, 234, 0.1);
    margin-top: 25px;
    position: relative;
}

.testimonial-author img {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    margin-right: 20px;
    object-fit: cover;
    border: 4px solid var(--primary-color);
    box-shadow: 0 4px 12px rgba(147, 51, 234, 0.2);
    transition: all 0.3s ease;
}

.testimonial-card:hover .testimonial-author img {
    transform: scale(1.05);
    border-color: var(--primary-hover);
}

.author-info h4 {
    margin: 0;
    font-size: 18px;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 2px;
}

.author-info p {
    margin: 5px 0;
    font-size: 14px;
    color: #718096;
    font-weight: 500;
}

.stars {
    color: #fbbf24;
    font-size: 16px;
    margin-top: 8px;
}

.stars i {
    margin-right: 3px;
    filter: drop-shadow(0 1px 2px rgba(0,0,0,0.1));
}

/* Carousel Customization */
#testimonialCarousel {
    padding: 40px 0;
}

#testimonialCarousel .carousel-indicators {
    margin-bottom: -40px;
    position: relative;
    z-index: 10;
}

#testimonialCarousel .carousel-indicators button {
    width: 14px;
    height: 14px;
    border-radius: 50%;
    background: linear-gradient(45deg, var(--primary-color), var(--primary-hover));
    opacity: 0.4;
    border: 2px solid rgba(255,255,255,0.8);
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

#testimonialCarousel .carousel-indicators button.active {
    opacity: 1;
    transform: scale(1.3);
    box-shadow: 0 4px 12px rgba(147, 51, 234, 0.3);
}

#testimonialCarousel .carousel-control-prev,
#testimonialCarousel .carousel-control-next {
    width: 55px;
    height: 55px;
    background: linear-gradient(45deg, var(--primary-color), var(--primary-hover));
    border-radius: 50%;
    bottom: -70px;
    transform: translateX(-50%);
    opacity: 0.9;
    top: auto;
    border: 3px solid rgba(255,255,255,0.8);
    transition: all 0.3s ease;
    box-shadow: 0 4px 16px rgba(147, 51, 234, 0.2);
}

#testimonialCarousel .carousel-control-prev {
    left: 45%;
}

#testimonialCarousel .carousel-control-next {
    left: 55%;
}

#testimonialCarousel .carousel-control-prev:hover,
#testimonialCarousel .carousel-control-next:hover {
    opacity: 1;
    transform: translateX(-50%) scale(1.1);
    box-shadow: 0 6px 20px rgba(147, 51, 234, 0.3);
}

#testimonialCarousel .carousel-control-prev-icon,
#testimonialCarousel .carousel-control-next-icon {
    width: 22px;
    height: 22px;
    filter: brightness(0) invert(1);
}

/* Section Title Enhancement */
.testimonials .section-title h2 {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--primary-color);
    margin-bottom: 10px;
    text-shadow: 0 2px 4px rgba(147, 51, 234, 0.1);
}

.testimonials .section-title p {
    font-size: 1.2rem;
    color: #64748b;
    font-weight: 500;
}

/* Responsive Enhancements */
@media (max-width: 1200px) {
    .testimonial-card {
        padding: 30px;
    }

    .testimonial-text {
        font-size: 15px;
    }

    .author-info h4 {
        font-size: 17px;
    }
}

@media (max-width: 992px) {
    .testimonials {
        padding: 60px 0;
    }

    #testimonialCarousel .carousel-control-prev {
        left: 40%;
    }

    #testimonialCarousel .carousel-control-next {
        left: 60%;
    }

    .testimonial-card {
        padding: 25px;
        margin-bottom: 20px;
    }

    .testimonial-author img {
        width: 60px;
        height: 60px;
    }

    .testimonial-text::before,
    .testimonial-text::after {
        display: none;
    }
}

@media (max-width: 768px) {
    .testimonials .section-title h2 {
        font-size: 2rem;
    }

    .testimonial-card {
        padding: 20px;
    }

    .testimonial-text {
        font-size: 14px;
        line-height: 1.6;
    }

    .author-info h4 {
        font-size: 16px;
    }

    .author-info p {
        font-size: 13px;
    }

    #testimonialCarousel .carousel-control-prev,
    #testimonialCarousel .carousel-control-next {
        width: 45px;
        height: 45px;
        bottom: -50px;
    }

    #testimonialCarousel .carousel-control-prev {
        left: 35%;
    }

    #testimonialCarousel .carousel-control-next {
        left: 65%;
    }
}

@media (max-width: 576px) {
    .testimonials {
        padding: 40px 0;
    }

    .testimonial-card {
        padding: 20px;
        border-radius: 15px;
    }

    .testimonial-author {
        flex-direction: column;
        text-align: center;
        padding-top: 20px;
    }

    .testimonial-author img {
        margin-right: 0;
        margin-bottom: 15px;
        width: 65px;
        height: 65px;
    }

    .testimonial-content {
        margin-bottom: 20px;
    }

    .quote-icon {
        font-size: 28px;
    }

    .testimonial-text {
        font-size: 14px;
    }

    #testimonialCarousel .carousel-control-prev,
    #testimonialCarousel .carousel-control-next {
        display: none;
    }

    #testimonialCarousel .carousel-indicators {
        margin-bottom: -20px;
    }
}

/* Tutor Section */
.tutors .tutor-info h3 {
    text-align: center;
    color: var(--primary-color);
}
</style>
@endpush

@push('scripts')
<script>
    (function () {
        "use strict";

        let forms = document.querySelectorAll(".php-email-form");

        forms.forEach(function (e) {
            e.addEventListener("submit", function (event) {
                event.preventDefault();

                let thisForm = this;
                let action = thisForm.getAttribute("action");
                let recaptcha = thisForm.getAttribute("data-recaptcha-site-key");

                if (!action) {
                    displayError(thisForm, "The form action property is not set!");
                    return;
                }
                thisForm.querySelector(".loading").classList.add("d-block");
                thisForm.querySelector(".error-message").classList.remove("d-block");
                thisForm.querySelector(".sent-message").classList.remove("d-block");

                let formData = new FormData(thisForm);

                if (recaptcha) {
                    if (typeof grecaptcha !== "undefined") {
                        grecaptcha.ready(function () {
                            try {
                                grecaptcha.execute(recaptcha, {
                                    action: "php_email_form_submit"
                                }).then((token) => {
                                    formData.set("recaptcha-response", token);
                                    php_email_form_submit(thisForm, action, formData);
                                });
                            } catch (error) {
                                displayError(thisForm, error);
                            }
                        });
                    } else {
                        displayError(thisForm, "The reCaptcha javascript API url is not loaded!");
                    }
                } else {
                    php_email_form_submit(thisForm, action, formData);
                }
            });
        });

        function php_email_form_submit(thisForm, action, formData) {
            fetch(action, {
                method: "POST",
                body: formData,
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                },
            }).then((response) => {
                thisForm.querySelector(".loading").classList.remove("d-block");
                thisForm.querySelector(".sent-message").classList.add("d-block");
                thisForm.reset();
            });
        }

        function displayError(thisForm, error) {
            thisForm.querySelector(".loading").classList.remove("d-block");
            thisForm.querySelector(".error-message").innerHTML = error;
            thisForm.querySelector(".error-message").classList.add("d-block");
        }
    })();
</script>
@endpush