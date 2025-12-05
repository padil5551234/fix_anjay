@extends('layouts.admin.app')

@section('title', 'Kelola Materi')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Materi</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>Kelola Materi Pembelajaran</h6>
                        <a href="{{ route('tutor.materials.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah Materi
                        </a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <!-- Filter Section -->
                    <div class="px-4 py-3">
                        <form method="GET" action="{{ route('tutor.materials.index') }}">
                            <div class="row">
                                <div class="col-md-3">
                                    <select name="type" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>Semua Tipe</option>
                                        <option value="video" {{ request('type') == 'video' ? 'selected' : '' }}>Video</option>
                                        <option value="document" {{ request('type') == 'document' ? 'selected' : '' }}>Dokumen</option>
                                        <option value="youtube" {{ request('type') == 'youtube' ? 'selected' : '' }}>YouTube</option>
                                        <option value="link" {{ request('type') == 'link' ? 'selected' : '' }}>Link</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select name="visibility" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <option value="all" {{ request('visibility') == 'all' ? 'selected' : '' }}>Semua Visibilitas</option>
                                        <option value="public" {{ request('visibility') == 'public' ? 'selected' : '' }}>Publik</option>
                                        <option value="private" {{ request('visibility') == 'private' ? 'selected' : '' }}>Private</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-sm">
                                        <input type="text" name="search" class="form-control" placeholder="Cari materi..." value="{{ request('search') }}">
                                        <button class="btn btn-outline-secondary" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    @if($materials->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-folder-open fa-3x text-secondary mb-3"></i>
                            <p class="text-secondary">Belum ada materi yang ditambahkan</p>
                            <a href="{{ route('tutor.materials.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Tambah Materi
                            </a>
                        </div>
                    @else
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Materi</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tipe</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Views</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Downloads</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($materials as $material)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        @if($material->type === 'youtube')
                                                            <img src="{{ $material->getYoutubeThumbnail() }}" class="avatar avatar-sm me-3" alt="{{ $material->title }}">
                                                        @elseif($material->thumbnail_path)
                                                            <img src="{{ asset('storage/' . $material->thumbnail_path) }}" class="avatar avatar-sm me-3" alt="{{ $material->title }}">
                                                        @else
                                                            <div class="avatar avatar-sm me-3 bg-gradient-primary">
                                                                <i class="{{ $material->getTypeIcon() }} text-white"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ Str::limit($material->title, 50) }}</h6>
                                                        <p class="text-xs text-secondary mb-0">
                                                            @if($material->mapel)
                                                                <span class="badge badge-sm bg-info">{{ $material->mapel }}</span>
                                                            @endif
                                                            @if($material->batch)
                                                                <span class="badge badge-sm bg-secondary">{{ $material->batch->nama }}</span>
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-sm {{ $material->getTypeBadgeClass() }}">
                                                    <i class="{{ $material->getTypeIcon() }}"></i> {{ ucfirst($material->type) }}
                                                </span>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-xs font-weight-bold">{{ number_format($material->views_count) }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-xs font-weight-bold">{{ number_format($material->downloads_count) }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                @if($material->is_public)
                                                    <span class="badge badge-sm bg-success">Publik</span>
                                                @else
                                                    <span class="badge badge-sm bg-secondary">Private</span>
                                                @endif
                                                @if($material->is_featured)
                                                    <span class="badge badge-sm bg-warning">Featured</span>
                                                @endif
                                            </td>
                                            <td class="align-middle">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('tutor.materials.show', $material) }}" class="btn btn-link text-info text-gradient px-3 mb-0">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('tutor.materials.edit', $material) }}" class="btn btn-link text-dark px-3 mb-0">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    <form action="{{ route('tutor.materials.destroy', $material) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus materi ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-link text-danger text-gradient px-3 mb-0">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="px-4 py-3">
                            {{ $materials->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.avatar {
    width: 48px;
    height: 48px;
    border-radius: 0.5rem;
    object-fit: cover;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
@endpush