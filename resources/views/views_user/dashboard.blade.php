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
    <section id="about" class="about" style="background: url('{{ asset('img/about.png') }}') center/cover no-repeat; position: relative;">
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
    <section id="counts" class="counts" style="background: #995df1) center/cover no-repeat; position: relative;">
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
      <section class="testimonials" style="background: url('{{ asset('img/bg_testi.png') }}') center/cover no-repeat; position: relative;">
        <div class="container">
            <div class="section-title">
                <h2>Testimoni</h2>
                <p>Apa Kata Alumni Kami</p>
            </div>

            <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
                <div class="carousel-indicators justify-content-center">
                    <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="0" class="active"></button>
                    <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="2"></button>
                </div>

                <div class="carousel-inner">
                    <!-- Slide 1 -->
                    <div class="carousel-item active">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="testimonial-card">
                                    <div class="testimonial-image-wrapper">
                                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=400&h=350&fit=crop" alt="Ismi Maulfi Rahma">
                                        
                                        <!-- Badge Universitas & Jurusan -->
                                        <div class="testimonial-badge">
                                            <i class="bi bi-trophy-fill badge-icon"></i>
                                            <div class="badge-text">
                                                <span class="badge-university">UGM</span>
                                                <span class="badge-major">Ilmu Keperawatan</span>
                                            </div>
                                        </div>

                                        <!-- Name Badge -->
                                        <div class="testimonial-name-badge">
                                            <h4>ISMI MAULFI RAHMA</h4>
                                        </div>
                                    </div>
                                    <div class="testimonial-content">
                                        <p class="testimonial-text">
                                            Makasih banyak Kak Faiz, video dan tryout dari Privat AI Faiz bantu banget. Tryout kaka bener" mirip dengan soal asli SNBT. Penyampaian materi juga seru, jadi belajarnya rileks dan ngga tegang. Banyak juga trik-trik cepet yang ngebantu banget. Terimakasih Privat AI Faiz, Sukses selalu!
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="testimonial-card">
                                    <div class="testimonial-image-wrapper">
                                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=400&h=350&fit=crop" alt="Zalsa Archyta">
                                        
                                        <div class="testimonial-badge">
                                            <i class="bi bi-trophy-fill badge-icon"></i>
                                            <div class="badge-text">
                                                <span class="badge-university">UNIVERSITAS HASANUDDIN</span>
                                                <span class="badge-major">Pendidikan Dokter Gigi</span>
                                            </div>
                                        </div>

                                        <div class="testimonial-name-badge">
                                            <h4>ZALSA ARCHYTA</h4>
                                        </div>
                                    </div>
                                    <div class="testimonial-content">
                                        <p class="testimonial-text">
                                            Alhamdulillah berkat Privat AI Faiz aku bisa masuk ke PTN dan Fakultas yang aku impikan. Kalian harus cobain juga sebab pembelajarannya yang selalu seru. Aku bisa kamu juga pasti bisa! Karna C ituuuu Cintaaaaaaa
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="testimonial-card">
                                    <div class="testimonial-image-wrapper">
                                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=350&fit=crop" alt="Ganda Sibarani">
                                        
                                        <div class="testimonial-badge">
                                            <i class="bi bi-trophy-fill badge-icon"></i>
                                            <div class="badge-text">
                                                <span class="badge-university">UI</span>
                                                <span class="badge-major">Teknik Mesin</span>
                                            </div>
                                        </div>

                                        <div class="testimonial-name-badge">
                                            <h4>GANDA SIBARANI</h4>
                                        </div>
                                    </div>
                                    <div class="testimonial-content">
                                        <p class="testimonial-text">
                                            Belajarnya seru, para tim orangnya asik dan menarik cara mengajarnya friendly banget dan seru. Selalu kasih video hasil record dan ss-an hasil pembahasan soal. Keren banget lah
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="testimonial-card">
                                    <div class="testimonial-image-wrapper">
                                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=400&h=350&fit=crop" alt="Siti Nurhaliza">
                                        
                                        <div class="testimonial-badge">
                                            <i class="bi bi-trophy-fill badge-icon"></i>
                                            <div class="badge-text">
                                                <span class="badge-university">STIS</span>
                                                <span class="badge-major">Statistika</span>
                                            </div>
                                        </div>

                                        <div class="testimonial-name-badge">
                                            <h4>SITI NURHALIZA</h4>
                                        </div>
                                    </div>
                                    <div class="testimonial-content">
                                        <p class="testimonial-text">
                                            Try out di DinasSolution sangat membantu persiapan saya. Soal-soalnya mirip dengan ujian asli SPMB STIS. Alhamdulillah sekarang saya sudah mahasiswa STIS!
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="testimonial-card">
                                    <div class="testimonial-image-wrapper">
                                        <img src="https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?w=400&h=350&fit=crop" alt="Budi Santoso">
                                        
                                        <div class="testimonial-badge">
                                            <i class="bi bi-trophy-fill badge-icon"></i>
                                            <div class="badge-text">
                                                <span class="badge-university">PKN STAN</span>
                                                <span class="badge-major">Akuntansi</span>
                                            </div>
                                        </div>

                                        <div class="testimonial-name-badge">
                                            <h4>BUDI SANTOSO</h4>
                                        </div>
                                    </div>
                                    <div class="testimonial-content">
                                        <p class="testimonial-text">
                                            Mentor-mentornya sabar dan profesional. Materi yang diajarkan sangat terstruktur dan mudah dipahami. Recommended banget untuk persiapan kedinasan!
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="testimonial-card">
                                    <div class="testimonial-image-wrapper">
                                        <img src="https://images.unsplash.com/photo-1524504388940-b1c1722653e1?w=400&h=350&fit=crop" alt="Rina Fitriani">
                                        
                                        <div class="testimonial-badge">
                                            <i class="bi bi-trophy-fill badge-icon"></i>
                                            <div class="badge-text">
                                                <span class="badge-university">IPDN</span>
                                                <span class="badge-major">Manajemen Pemerintahan</span>
                                            </div>
                                        </div>

                                        <div class="testimonial-name-badge">
                                            <h4>RINA FITRIANI</h4>
                                        </div>
                                    </div>
                                    <div class="testimonial-content">
                                        <p class="testimonial-text">
                                            Harga terjangkau dengan kualitas premium. Sistem CAT-nya membuat saya terbiasa dengan ujian sebenarnya. Terima kasih DinasSolution!
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 3 -->
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="testimonial-card">
                                    <div class="testimonial-image-wrapper">
                                        <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?w=400&h=350&fit=crop" alt="Dimas Prasetyo">
                                        
                                        <div class="testimonial-badge">
                                            <i class="bi bi-trophy-fill badge-icon"></i>
                                            <div class="badge-text">
                                                <span class="badge-university">STIN</span>
                                                <span class="badge-major">Teknologi Industri</span>
                                            </div>
                                        </div>

                                        <div class="testimonial-name-badge">
                                            <h4>DIMAS PRASETYO</h4>
                                        </div>
                                    </div>
                                    <div class="testimonial-content">
                                        <p class="testimonial-text">
                                            Pembahasan soal-soalnya sangat detail dan mudah dipahami. Saya yang awalnya lemah di matematika jadi lebih percaya diri menghadapi SPMB!
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="testimonial-card">
                                    <div class="testimonial-image-wrapper">
                                        <img src="https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?w=400&h=350&fit=crop" alt="Anisa Putri">
                                        
                                        <div class="testimonial-badge">
                                            <i class="bi bi-trophy-fill badge-icon"></i>
                                            <div class="badge-text">
                                                <span class="badge-university">AIM</span>
                                                <span class="badge-major">Manajemen Imigrasi</span>
                                            </div>
                                        </div>

                                        <div class="testimonial-name-badge">
                                            <h4>ANISA PUTRI</h4>
                                        </div>
                                    </div>
                                    <div class="testimonial-content">
                                        <p class="testimonial-text">
                                            Try out rutin setiap minggu membuat saya terlatih mengatur waktu. Sistem ranking juga memotivasi saya untuk terus belajar lebih giat!
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="testimonial-card">
                                    <div class="testimonial-image-wrapper">
                                        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=400&h=350&fit=crop" alt="Maya Safitri">
                                        
                                        <div class="testimonial-badge">
                                            <i class="bi bi-trophy-fill badge-icon"></i>
                                            <div class="badge-text">
                                                <span class="badge-university">POLTEKIM</span>
                                                <span class="badge-major">Kimia Industri</span>
                                            </div>
                                        </div>

                                        <div class="testimonial-name-badge">
                                            <h4>MAYA SAFITRI</h4>
                                        </div>
                                    </div>
                                    <div class="testimonial-content">
                                        <p class="testimonial-text">
                                            Grup WhatsApp sangat membantu untuk diskusi soal. Kakak mentor juga responsif menjawab pertanyaan. Worth it banget!
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
            </div>
        </div>
    </section>

    <!-- ======= Pricing Section ======= -->
    <section id="pricing" class="pricing" style="background: url('{{ asset('img/pricing-bg.jpg') }}') center/cover no-repeat; position: relative;">
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
    <section id="tutors" class="tutors" style="background: url('{{ asset('img/tutors-bg.png') }}') center/cover no-repeat; position: relative;">
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
        <section id="articles" class="articles" style="background: url('{{ asset('img/articles-bg.jpg') }}') center/cover no-repeat; position: relative;">
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
                                    <a href="{{ route('articles.show', $featured->slug) }}" class="btn-buy btn-article" style="display: inline-block; padding: 10px 25px; margin-top: 15px; background: linear-gradient(135deg, var(--primary-color), var(--primary-hover)); color: white; border: none; border-radius: 25px; text-decoration: none; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(147, 51, 234, 0.3);">Baca Selengkapnya</a>
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
                                    <a href="{{ route('articles.show', $article->slug) }}" class="btn-buy btn-article" style="display: inline-block; padding: 10px 25px; margin-top: 15px; background: linear-gradient(135deg, var(--primary-color), var(--primary-hover)); color: white; border: none; border-radius: 25px; text-decoration: none; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(147, 51, 234, 0.3);">Baca Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-4" data-aos="fade-up" data-aos-delay="200">
                    <a href="{{ route('articles.index') }}" class="btn-buy btn-article-main" style="display: inline-block; padding: 15px 40px; background: linear-gradient(135deg, var(--primary-color), var(--primary-hover)); color: white; border: none; border-radius: 30px; text-decoration: none; font-weight: 700; font-size: 16px; transition: all 0.3s ease; box-shadow: 0 6px 20px rgba(147, 51, 234, 0.4); text-transform: uppercase; letter-spacing: 1px;">Lihat Semua Artikel</a>
                </div>
            </div>
        </section><!-- End Articles Section -->
    @endif

    <!-- ======= F.A.Q Section ======= -->
    @if ($faqs)
        <section id="faq" class="faq section-bg" style="background: url('{{ asset('img/faq-bg.png') }}') center/cover no-repeat; position: relative;">
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
    <section id="contact" class="contact" style="background: url('{{ asset('img/contact-bg.jpg') }}') center/cover no-repeat; position: relative;">
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
                            <p><a style="color: inherit;" target="_blank" href="https://wa.me/6283117106878?text=Halo,%20saya%20ingin%20berkonsultasi%20tentang%20Paket%20Bimbel">0883117106878 (Kak Ayu) - WhatsApp untuk Konsultasi</a></p>
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
        :root {
            --primary-color: #9333ea;
            --primary-hover: #7c3aed;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
        }

        /* Testimonials Section */
        .testimonials {
            padding: 80px 0;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .section-title p {
            font-size: 1.2rem;
            color: #64748b;
            font-weight: 500;
        }

        /* Testimonial Card - Mirip Gambar */
        .testimonial-card {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            transition: all 0.4s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .testimonial-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        /* Image Container dengan Badge */
        .testimonial-image-wrapper {
            position: relative;
            width: 100%;
            height: 350px;
            overflow: hidden;
        }

        .testimonial-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .testimonial-card:hover .testimonial-image-wrapper img {
            transform: scale(1.05);
        }

        /* Badge di atas foto */
        .testimonial-badge {
            position: absolute;
            top: 20px;
            left: 20px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            color: white;
            padding: 12px 20px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            font-size: 14px;
            box-shadow: 0 4px 15px rgba(184, 58, 94, 0.4);
            z-index: 2;
        }

        .badge-icon {
            font-size: 24px;
        }

        .badge-text {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }

        .badge-university {
            font-size: 11px;
            opacity: 0.95;
            font-weight: 500;
        }

        .badge-major {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
        }

        /* Name Badge di bawah foto */
        .testimonial-name-badge {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            color: white;
            padding: 20px 25px;
            clip-path: polygon(0 30%, 100% 0, 100% 100%, 0% 100%);
        }

        .testimonial-name-badge h4 {
            margin: 0;
            font-size: 22px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Content Area */
        .testimonial-content {
            padding: 30px;
            flex-grow: 1;
            background: white;
        }

        .testimonial-text {
            color: #4a5568;
            font-size: 15px;
            line-height: 1.8;
            margin: 0;
        }

        /* Carousel Controls */
    /* Carousel Controls */
#testimonialCarousel {
    padding-bottom: 100px; /* Beri ruang untuk controls */
    position: relative;
}

#testimonialCarousel .carousel-indicators {
    position: absolute;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    margin: 0;
    display: flex;
    justify-content: center;
    gap: 8px;
    z-index: 10;
}

#testimonialCarousel .carousel-indicators button {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: var(--primary-color);
    opacity: 0.4;
    border: none;
    margin: 0;
    padding: 0;
    transition: all 0.3s ease;
}

#testimonialCarousel .carousel-indicators button.active {
    opacity: 1;
    transform: scale(1.3);
    box-shadow: 0 0 8px rgba(184, 58, 94, 0.4);
}

/* Carousel Navigation Buttons */
.carousel-controls-wrapper {
    position: absolute;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    align-items: center;
    gap: 100px;
    z-index: 5;
}

#testimonialCarousel .carousel-control-prev,
#testimonialCarousel .carousel-control-next {
    position: absolute;
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
    border-radius: 50%;
    opacity: 0.9;
    bottom: 20px;
    top: auto;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(184, 58, 94, 0.3);
}

#testimonialCarousel .carousel-control-prev {
    left: calc(50% - 130px);
}

#testimonialCarousel .carousel-control-next {
    right: calc(50% - 130px);
    left: auto;
}

#testimonialCarousel .carousel-control-prev:hover,
#testimonialCarousel .carousel-control-next:hover {
    opacity: 1;
    transform: scale(1.1);
    box-shadow: 0 6px 16px rgba(184, 58, 94, 0.4);
}

#testimonialCarousel .carousel-control-prev-icon,
#testimonialCarousel .carousel-control-next-icon {
    width: 20px;
    height: 20px;
    filter: brightness(0) invert(1);
}

/* Responsive */
@media (max-width: 992px) {
    .testimonial-image-wrapper {
        height: 300px;
    }

    .testimonial-badge {
        padding: 10px 15px;
        font-size: 12px;
    }

    .testimonial-name-badge h4 {
        font-size: 18px;
    }

    #testimonialCarousel .carousel-control-prev {
        left: calc(50% - 110px);
    }

    #testimonialCarousel .carousel-control-next {
        right: calc(50% - 110px);
    }
}

@media (max-width: 768px) {
    .testimonial-image-wrapper {
        height: 280px;
    }

    .testimonial-content {
        padding: 20px;
    }

    .testimonial-text {
        font-size: 14px;
    }

    #testimonialCarousel {
        padding-bottom: 90px;
    }

    #testimonialCarousel .carousel-control-prev,
    #testimonialCarousel .carousel-control-next {
        width: 45px;
        height: 45px;
    }

    #testimonialCarousel .carousel-control-prev {
        left: calc(50% - 90px);
    }

    #testimonialCarousel .carousel-control-next {
        right: calc(50% - 90px);
    }

    #testimonialCarousel .carousel-indicators {
        bottom: 25px;
    }
}

@media (max-width: 576px) {
    #testimonialCarousel {
        padding-bottom: 70px;
    }

    #testimonialCarousel .carousel-control-prev,
    #testimonialCarousel .carousel-control-next {
        width: 40px;
        height: 40px;
    }

    #testimonialCarousel .carousel-control-prev {
        left: calc(50% - 70px);
    }

    #testimonialCarousel .carousel-control-next {
        right: calc(50% - 70px);
    }

    #testimonialCarousel .carousel-indicators {
        bottom: 20px;
        gap: 6px;
    }

    #testimonialCarousel .carousel-indicators button {
        width: 10px;
        height: 10px;
    }

    #testimonialCarousel .carousel-control-prev-icon,
    #testimonialCarousel .carousel-control-next-icon {
        width: 16px;
        height: 16px;
    }
}

@media (max-width: 400px) {
    #testimonialCarousel .carousel-control-prev {
        left: calc(50% - 60px);
    }

    #testimonialCarousel .carousel-control-next {
        right: calc(50% - 60px);
    }
}

/* Enhanced Article Buttons */
.btn-article {
    position: relative;
    overflow: hidden;
}

.btn-article::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.btn-article:hover::before {
    left: 100%;
}

.btn-article:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(147, 51, 234, 0.4) !important;
}

.btn-article-main {
    position: relative;
    overflow: hidden;
}

.btn-article-main::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    transition: left 0.6s;
}

.btn-article-main:hover::before {
    left: 100%;
}

.btn-article-main:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(147, 51, 234, 0.5) !important;
}

.btn-article-main:active,
.btn-article:active {
    transform: translateY(0);
    box-shadow: 0 2px 10px rgba(147, 51, 234, 0.3) !important;
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