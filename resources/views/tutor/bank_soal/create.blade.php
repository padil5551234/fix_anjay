@extends('layouts.admin.app')

@section('title', 'Tambah Bank Soal')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('tutor.bank-soal.index') }}">Bank Soal</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Tambah Bank Soal</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('tutor.bank-soal.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="form-group">
                            <label for="batch_id">Batch <span class="text-danger">*</span></label>
                            <select name="batch_id" id="batch_id" class="form-control @error('batch_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Batch --</option>
                                @foreach($batches as $batch)
                                    <option value="{{ $batch->id }}" {{ old('batch_id') == $batch->id ? 'selected' : '' }}>
                                        {{ $batch->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('batch_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="nama_banksoal">Nama Bank Soal <span class="text-danger">*</span></label>
                            <input type="text" name="nama_banksoal" id="nama_banksoal" class="form-control @error('nama_banksoal') is-invalid @enderror" value="{{ old('nama_banksoal') }}" required>
                            @error('nama_banksoal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="mapel">Mata Pelajaran <span class="text-danger">*</span></label>
                            <input type="text" name="mapel" id="mapel" class="form-control @error('mapel') is-invalid @enderror" value="{{ old('mapel') }}" placeholder="Contoh: Matematika, Bahasa Indonesia" required>
                            @error('mapel')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="file_banksoal">File Bank Soal <span class="text-danger">*</span></label>
                            <input type="file" name="file_banksoal" id="file_banksoal" class="form-control @error('file_banksoal') is-invalid @enderror" accept=".pdf,.doc,.docx,.zip" required>
                            <small class="form-text text-muted">
                                Format: PDF, DOC, DOCX, ZIP. Maksimal 10MB
                            </small>
                            @error('file_banksoal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                            <a href="{{ route('tutor.bank-soal.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Preview file name
    document.getElementById('file_banksoal').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name;
        if (fileName) {
            console.log('File selected:', fileName);
        }
    });
</script>
@endpush