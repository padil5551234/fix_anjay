@extends('layouts.admin.app')

@section('title', isset($bankSoal) ? 'Edit Bank Soal' : 'Tambah Bank Soal')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('admin.bank-soal.index') }}">Bank Soal</a></li>
    <li class="breadcrumb-item active">{{ isset($bankSoal) ? 'Edit' : 'Tambah' }}</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4>{{ isset($bankSoal) ? 'Edit Bank Soal' : 'Tambah Bank Soal Baru' }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ isset($bankSoal) ? route('admin.bank-soal.update', $bankSoal->id) : route('admin.bank-soal.store') }}" 
                          method="POST" enctype="multipart/form-data">
                        @csrf
                        @if(isset($bankSoal))
                            @method('PUT')
                        @endif

                        <div class="form-group">
                            <label for="nama_banksoal">Nama Bank Soal <span class="text-danger">*</span></label>
                            <input type="text" name="nama_banksoal" id="nama_banksoal" 
                                   class="form-control @error('nama_banksoal') is-invalid @enderror" 
                                   value="{{ old('nama_banksoal', $bankSoal->nama_banksoal ?? '') }}" 
                                   placeholder="Contoh: Bank Soal Matematika Dasar" required>
                            @error('nama_banksoal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mapel">Mata Pelajaran <span class="text-danger">*</span></label>
                                    <select name="mapel" id="mapel" class="form-control @error('mapel') is-invalid @enderror" required>
                                        <option value="">Pilih Mata Pelajaran</option>
                                        <option value="Matematika" {{ old('mapel', $bankSoal->mapel ?? '') == 'Matematika' ? 'selected' : '' }}>Matematika</option>
                                        <option value="TWK" {{ old('mapel', $bankSoal->mapel ?? '') == 'TWK' ? 'selected' : '' }}>TWK (Tes Wawasan Kebangsaan)</option>
                                        <option value="TIU" {{ old('mapel', $bankSoal->mapel ?? '') == 'TIU' ? 'selected' : '' }}>TIU (Tes Intelegensi Umum)</option>
                                        <option value="TKP" {{ old('mapel', $bankSoal->mapel ?? '') == 'TKP' ? 'selected' : '' }}>TKP (Tes Karakteristik Pribadi)</option>
                                        <option value="SKD" {{ old('mapel', $bankSoal->mapel ?? '') == 'SKD' ? 'selected' : '' }}>SKD (Seleksi Kompetensi Dasar)</option>
                                        <option value="Lainnya" {{ old('mapel', $bankSoal->mapel ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                    @error('mapel')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="batch_id">Batch</label>
                                    <select name="batch_id" id="batch_id" class="form-control @error('batch_id') is-invalid @enderror">
                                        <option value="">Pilih Batch (Opsional)</option>
                                        @foreach($batches as $batch)
                                            <option value="{{ $batch->id }}" 
                                                {{ old('batch_id', $bankSoal->batch_id ?? '') == $batch->id ? 'selected' : '' }}>
                                                {{ $batch->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('batch_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Opsional: Pilih batch jika bank soal ini untuk batch tertentu</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tentor_id">Tentor</label>
                            <select name="tentor_id" id="tentor_id" class="form-control @error('tentor_id') is-invalid @enderror">
                                <option value="">Pilih Tentor (Opsional)</option>
                                @foreach($tentors as $tentor)
                                    <option value="{{ $tentor->id }}" 
                                        {{ old('tentor_id', $bankSoal->tentor_id ?? '') == $tentor->id ? 'selected' : '' }}>
                                        {{ $tentor->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tentor_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Opsional: Pilih tentor pembuat soal</small>
                        </div>

                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" rows="3" 
                                      class="form-control @error('deskripsi') is-invalid @enderror"
                                      placeholder="Deskripsi bank soal">{{ old('deskripsi', $bankSoal->deskripsi ?? '') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="file_banksoal">File Bank Soal</label>
                            <input type="file" name="file_banksoal" id="file_banksoal" 
                                   class="form-control @error('file_banksoal') is-invalid @enderror"
                                   accept=".pdf,.doc,.docx,.zip">
                            @if(isset($bankSoal) && $bankSoal->file_banksoal)
                                <small class="form-text text-success">
                                    <i class="fas fa-check-circle"></i> File saat ini: 
                                    <a href="{{ Storage::url($bankSoal->file_banksoal) }}" target="_blank">Lihat File</a>
                                </small>
                            @endif
                            <small class="form-text text-muted">
                                Format: PDF, DOC, DOCX, ZIP. Maksimal 10MB. (Opsional)
                            </small>
                            @error('file_banksoal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> <strong>Catatan:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Bank soal ini dapat digunakan sebagai referensi untuk pembuatan ujian</li>
                                <li>File dapat berisi kumpulan soal dalam format dokumen</li>
                                <li>Untuk menambahkan soal langsung ke ujian, gunakan menu "Ujian" → "Soal"</li>
                            </ul>
                        </div>

                        <div class="form-group mt-4">
                            <a href="{{ route('admin.bank-soal.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary float-right">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection