@extends('layouts.admin.app')

@section('title', 'Bank Soal')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Bank Soal</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Kelola Bank Soal</h4>
                    <div class="card-header-action">
                        <a href="{{ route('tutor.bank-soal.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Bank Soal
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filter Section -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <form method="GET" action="{{ route('tutor.bank-soal.index') }}">
                                <select name="batch_id" class="form-control" onchange="this.form.submit()">
                                    <option value="">Semua Batch</option>
                                    @foreach($batches as $batch)
                                        <option value="{{ $batch->id }}" {{ request('batch_id') == $batch->id ? 'selected' : '' }}>
                                            {{ $batch->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                        <div class="col-md-3">
                            <form method="GET" action="{{ route('tutor.bank-soal.index') }}">
                                <input type="text" name="mapel" class="form-control" placeholder="Filter Mapel..." value="{{ request('mapel') }}" onchange="this.form.submit()">
                            </form>
                        </div>
                        <div class="col-md-6">
                            <form method="GET" action="{{ route('tutor.bank-soal.index') }}">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Cari bank soal..." value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    @if($bankSoal->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-folder-open fa-4x text-secondary mb-3"></i>
                            <h5>Belum ada bank soal</h5>
                            <p class="text-muted">Mulai dengan menambahkan bank soal pertama Anda</p>
                            <a href="{{ route('tutor.bank-soal.create') }}" class="btn btn-primary mt-2">
                                <i class="fas fa-plus"></i> Tambah Bank Soal
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Nama Bank Soal</th>
                                        <th>Batch</th>
                                        <th>Mapel</th>
                                        <th>Tanggal Upload</th>
                                        <th>File</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bankSoal as $item)
                                    <tr>
                                        <td>
                                            <strong>{{ $item->nama_banksoal }}</strong>
                                            @if($item->deskripsi)
                                                <br><small class="text-muted">{{ Str::limit($item->deskripsi, 50) }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->batch)
                                                <span class="badge badge-info">{{ $item->batch->nama }}</span>
                                            @else
                                                <span class="badge badge-secondary">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-primary">{{ $item->mapel }}</span>
                                        </td>
                                        <td>
                                            <i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($item->tanggal_upload)->format('d M Y') }}
                                        </td>
                                        <td>
                                            @if($item->file_banksoal)
                                                <a href="{{ route('tutor.bank-soal.download', $item) }}" class="btn btn-sm btn-success" title="Download">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('tutor.bank-soal.edit', $item) }}" class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('tutor.bank-soal.destroy', $item) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus bank soal ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $bankSoal->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection