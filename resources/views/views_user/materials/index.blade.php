@extends('layouts.user.app')

@section('title', 'Materi Pembelajaran')

@section('content')

<section id="materials" class="materials">
    <div class="container" data-aos="fade-up">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-3">Materi Pembelajaran</h2>
            <p class="text-muted">Akses materi pembelajaran dari paket yang sudah Anda beli</p>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('user.materials.index') }}">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Tipe Materi</label>
                                <select name="type" class="form-select" onchange="this.form.submit()">
                                    <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>Semua Tipe</option>
                                    <option value="youtube" {{ request('type') == 'youtube' ? 'selected' : '' }}>Video YouTube</option>
                                    <option value="video" {{ request('type') == 'video' ? 'selected' : '' }}>Video</option>
                                    <option value="document" {{ request('type') == 'document' ? 'selected' : '' }}>Dokumen</option>
                                    <option value="link" {{ request('type') == 'link' ? 'selected' : '' }}>Link</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Paket</label>
                                <select name="package" class="form-select" onchange="this.form.submit()">
                                    <option value="all" {{ request('package') == 'all' ? 'selected' : '' }}>Semua Paket</option>
                                    @foreach($purchasedPackages as $package)
                                        <option value="{{ $package->id }}" {{ request('package') == $package->id ? 'selected' : '' }}>
                                            {{ $package->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Mata Pelajaran</label>
                                <input type="text" name="mapel" class="form-control" placeholder="Cari mapel..." value="{{ request('mapel') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Cari</label>
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Cari materi..." value="{{ request('search') }}">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if($materials->isEmpty())
        <div class="row">
            <div class="col-12">
                <div class="card text-center py-5">
                    <div class="card-body">
                        <i class="fas fa-book-open fa-4x text-muted mb-3"></i>
                        <h5>Belum Ada Materi</h5>
                        <p class="text-muted">
                            @if($purchasedPackages->isEmpty())
                                Anda belum membeli paket apapun. Silakan beli paket untuk mengakses materi pembelajaran.
                            @else
                                Materi untuk paket yang Anda beli belum tersedia.
                            @endif
                        </p>
                        @if($purchasedPackages->isEmpty())
                            <a href="{{ route('dashboard') }}#pricing" class="btn btn-primary">
                                <i class="fas fa-shopping-cart"></i> Lihat Paket
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            @foreach($materials as $material)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 material-card">
                        <div class="material-thumbnail">
                            @if($material->type === 'youtube' && $material->youtube_url)
                                <img src="{{ $material->getYoutubeThumbnail() }}" alt="{{ $material->title }}" class="card-img-top">
                                <div class="play-overlay">
                                    <i class="fab fa-youtube fa-3x"></i>
                                </div>
                            @elseif($material->thumbnail_path)
                                <img src="{{ asset('storage/' . $material->thumbnail_path) }}" alt="{{ $material->title }}" class="card-img-top">
                            @else
                                <div class="placeholder-thumbnail">
                                    <i class="{{ $material->getTypeIcon() }} fa-4x"></i>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                <span class="badge bg-primary">{{ ucfirst($material->type) }}</span>
                                @if($material->mapel)
                                    <span class="badge bg-info">{{ $material->mapel }}</span>
                                @endif
                                @if($material->batch)
                                    <span class="badge bg-secondary">{{ $material->batch->nama }}</span>
                                @endif
                            </div>
                            <h5 class="card-title">{{ Str::limit($material->title, 60) }}</h5>
                            <p class="card-text text-muted small">
                                {{ Str::limit($material->description, 100) }}
                            </p>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-muted">
                                    <i class="fas fa-eye"></i> {{ number_format($material->views_count) }} views
                                </small>
                                @if($material->duration_seconds)
                                    <small class="text-muted">
                                        <i class="fas fa-clock"></i> {{ $material->getFormattedDuration() }}
                                    </small>
                                @endif
                            </div>
                            @if($material->tutor)
                                <small class="text-muted">
                                    <i class="fas fa-user"></i> {{ $material->tutor->name }}
                                </small>
                            @endif
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="d-flex gap-2">
                                <a href="{{ route('user.materials.show', $material) }}" class="btn btn-primary btn-sm flex-grow-1">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                                @if($material->isDownloadable())
                                    <a href="{{ route('user.materials.download', $material) }}" class="btn btn-secondary btn-sm" title="Download">
                                        <i class="fas fa-download"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-12">
                {{ $materials->links() }}
            </div>
        </div>
    @endif
    </div>
</section>
@endsection

@push('styles')
<style>
.breadcrumbs {
    padding: 20px 0;
    background-color: #f8f9fa;
}

.breadcrumbs ol {
    display: flex;
    flex-wrap: wrap;
    list-style: none;
    padding: 0;
    margin: 0;
    font-size: 14px;
}

.breadcrumbs ol li + li {
    padding-left: 10px;
}

.breadcrumbs ol li + li::before {
    display: inline-block;
    padding-right: 10px;
    color: #6c757d;
    content: "/";
}

.breadcrumbs h2 {
    font-size: 28px;
    font-weight: 600;
    color: #2c3e50;
    margin-top: 10px;
}

.material-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    overflow: hidden;
}

.material-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.material-thumbnail {
    position: relative;
    height: 200px;
    overflow: hidden;
    background: #f8f9fa;
}

.material-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.placeholder-thumbnail {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.play-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.material-card:hover .play-overlay {
    opacity: 1;
}

.card-footer {
    border-top: 1px solid rgba(0, 0, 0, 0.05);
}
</style>
@endpush