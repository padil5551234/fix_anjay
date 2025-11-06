# Perbaikan Error: User Tidak Bisa Mengerjakan Ujian yang Sudah Dibeli

## Masalah
User yang sudah membeli paket ujian tidak dapat mengerjakan ujian karena terjadi error:
```
ErrorException: Attempt to read property "soal" on null
```

Error ini terjadi di file `resources/views/views_user/ujian/index.blade.php` pada line 213 dan beberapa tempat lainnya.

## Penyebab
1. **Null Reference Error**: View mencoba mengakses `$soal[0]->soal->ujian` yang bisa bernilai null jika:
   - Collection `$soal` kosong
   - Record `JawabanPeserta` tidak memiliki relasi `Soal` yang valid

2. **Database Integrity**: Record `JawabanPeserta` yang orphaned (tidak memiliki relasi valid ke `Soal`) dapat menyebabkan error saat diakses.

## Solusi yang Diterapkan

### 1. Filter Invalid Records di Controller
**File**: `app/Http/Controllers/UjianController.php`

Menambahkan `whereHas('soal')` untuk memfilter record yang tidak memiliki relasi soal valid:

```php
public function ujian($id) {
    $ujianUser = UjianUser::with('ujian')->findOrFail($id);
    // ... validasi lainnya ...

    $preparation = JawabanPeserta::with(['soal', 'soal.jawaban' => function ($q) use ($ujianUser)
    {
        if ($ujianUser->ujian->random_pilihan == 1) {
            $q->inRandomOrder();
        }
    }, 'soal.ujian'])
            ->where('ujian_user_id', $id)
            ->whereHas('soal'); // ✅ Filter hanya record dengan soal valid
    
    // ... kode lainnya ...
    
    // ✅ Pass ujian langsung untuk menghindari null reference
    $ujian = $ujianUser->ujian;
    
    return view('views_user.ujian.index', compact('soal', 'ragu_ragu', 'ujianUser', 'rekap_jawaban', 'ujian'));
}
```

### 2. Update View untuk Menggunakan Variable $ujian
**File**: `resources/views/views_user/ujian/index.blade.php`

Mengubah semua referensi dari `$soal[0]->soal->ujian` menjadi `$ujian`:

**Sebelum:**
```blade
@section('title')
{{ $soal->count() > 0 ? $soal[0]->soal->ujian->nama : 'Ujian' }}
@endsection

@if($soal[0]->soal->ujian->jenis_ujian == 'skd')
    <!-- ... -->
@endif

@if($soal[0]->soal->ujian->tampil_poin)
    <!-- ... -->
@endif
```

**Sesudah:**
```blade
@section('title')
{{ $ujian->nama ?? 'Ujian' }}
@endsection

@if($ujian->jenis_ujian == 'skd')
    <!-- ... -->
@endif

@if($ujian->tampil_poin && $soal->count() > 0)
    <!-- ... -->
@endif
```

### 3. Command untuk Cleanup Orphaned Records
**File**: `app/Console/Commands/CleanupOrphanedJawabanPeserta.php`

Membuat artisan command untuk membersihkan record yang orphaned:

```bash
php artisan cleanup:orphaned-jawaban
```

Command ini akan:
- Mencari semua record `JawabanPeserta` yang tidak memiliki relasi `Soal` valid
- Menampilkan jumlah record orphaned yang ditemukan
- Meminta konfirmasi sebelum menghapus
- Menghapus record-record orphaned tersebut

## Cara Testing

### 1. Login sebagai User yang sudah membeli paket
```
Email: user@example.com (atau user test lainnya)
Password: password
```

### 2. Akses halaman tryout
```
http://localhost:8000/tryout
```

### 3. Pilih ujian yang tersedia dan klik "Mulai Ujian"

### 4. Verifikasi bahwa:
- ✅ Halaman ujian dapat diakses tanpa error
- ✅ Soal ditampilkan dengan benar
- ✅ Navigasi soal berfungsi
- ✅ Timer countdown berjalan
- ✅ User dapat memilih jawaban
- ✅ Tombol "Selesai" berfungsi

## Pencegahan di Masa Depan

### 1. Validasi Saat Generate Soal
Pastikan method `generateSoal()` di controller menghasilkan soal yang valid:

```php
private function generateSoal($id) {
    // ... kode generate soal ...
    
    // Validasi soal tidak kosong
    if ($soal->count() === 0) {
        throw new \Exception('Tidak ada soal tersedia untuk ujian ini');
    }
    
    return $soal;
}
```

### 2. Gunakan Database Transactions
Saat membuat `UjianUser` dan `JawabanPeserta`, gunakan transaction untuk memastikan data konsisten:

```php
DB::transaction(function () use ($ujianUser, $soal) {
    foreach ($soal as $key => $item) {
        $store = new JawabanPeserta();
        $store->ujian_user_id = $ujianUser->id;
        $store->soal_id = $item->id;
        $store->poin = $item->poin_kosong;
        $store->save();
    }
});
```

### 3. Tambahkan Foreign Key Constraints
Di migration, pastikan ada foreign key constraint:

```php
// Di migration jawaban_peserta
$table->foreignId('soal_id')->constrained('soal')->onDelete('cascade');
$table->foreignId('ujian_user_id')->constrained('ujian_user')->onDelete('cascade');
```

## Status Perbaikan
✅ **SELESAI** - Error telah diperbaiki dan user dapat mengerjakan ujian

## File yang Dimodifikasi
1. ✅ `app/Http/Controllers/UjianController.php` - Tambah filtering dan pass $ujian variable
2. ✅ `resources/views/views_user/ujian/index.blade.php` - Update references dari $soal[0]->soal->ujian ke $ujian
3. ✅ `app/Console/Commands/CleanupOrphanedJawabanPeserta.php` - Command baru untuk cleanup

## Catatan Tambahan
- Perbaikan ini bersifat defensive programming untuk mencegah null reference errors
- Database integrity dijaga dengan menambahkan whereHas filter
- View lebih robust dengan menggunakan null coalescing operator (??)
- Cleanup command tersedia untuk maintenance rutin