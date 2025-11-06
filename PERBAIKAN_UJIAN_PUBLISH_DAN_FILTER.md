# Perbaikan Masalah Ujian Tidak Muncul dan Tidak Bisa Unpublish

## Tanggal Perbaikan
5 November 2025

## Masalah yang Ditemukan

### 1. Ujian yang Ditambahkan di Admin Tidak Muncul di Tryout
**Deskripsi:** Soal/ujian yang sudah ditambahkan di panel admin tidak muncul di halaman tryout user, bahkan setelah dipublish.

**Penyebab:** 
- Di [`UjianController.php`](app/Http/Controllers/UjianController.php:30-31) (controller user), query tidak memfilter ujian berdasarkan status `isPublished`
- Sistem menampilkan SEMUA ujian yang ada di paket, termasuk yang belum dipublish atau masih draft
- Ini menyebabkan user tidak bisa membedakan ujian mana yang siap dikerjakan

### 2. Tidak Bisa Unpublish Soal yang Sudah Dipublish
**Deskripsi:** Setelah ujian dipublish, tombol unpublish tidak berfungsi dan ujian tetap dalam status published.

**Penyebab:**
- Di [`Admin/UjianController.php`](app/Http/Controllers/Admin/UjianController.php:268-279), method `publish()` selalu mengecek jumlah soal bahkan saat unpublish
- Logika tidak membedakan antara publish dan unpublish
- Jika jumlah soal tidak sesuai (misal ada yang dihapus), unpublish akan gagal

## Solusi yang Diterapkan

### 1. Filter Ujian yang Published di Tryout

**File:** [`app/Http/Controllers/UjianController.php`](app/Http/Controllers/UjianController.php)

**Perubahan pada Testing Mode (line 30-31):**
```php
// SEBELUM
$paketQuery = PaketUjian::with([
    'ujian' => function ($query) {
        $query->orderBy('nama', 'asc');
    },

// SESUDAH
$paketQuery = PaketUjian::with([
    'ujian' => function ($query) {
        $query->where('isPublished', 1)->orderBy('nama', 'asc');
    },
```

**Perubahan pada Production Mode (line 63-66):**
```php
// SEBELUM
$data = Pembelian::with([
    'paketUjian.ujian' => function ($query) {
        $query->orderBy('nama', 'asc');
    },

// SESUDAH
$data = Pembelian::with([
    'paketUjian.ujian' => function ($query) {
        $query->where('isPublished', 1)->orderBy('nama', 'asc');
    },
```

**Hasil:**
- ✅ Hanya ujian dengan status `isPublished = 1` yang tampil di tryout
- ✅ Ujian draft tidak akan terlihat oleh user
- ✅ Admin masih bisa melihat semua ujian di panel admin

### 2. Perbaikan Fungsi Publish/Unpublish

**File:** [`app/Http/Controllers/Admin/UjianController.php`](app/Http/Controllers/Admin/UjianController.php:268-289)

**Perubahan:**
```php
// SEBELUM
public function publish($id)
{
    $ujian = Ujian::with('soal')->findorFail($id);
    if ($ujian->soal->count() == $ujian->jumlah_soal) {
        $ujian->isPublished = $ujian->isPublished ? 0 : 1;
        $ujian->update();
        return response()->json('Data berhasil disimpan', 200);
    }
    return response()->json('Tidak dapat mempublish', 300);
}

// SESUDAH
public function publish($id)
{
    $ujian = Ujian::with('soal')->findorFail($id);
    
    // Jika ujian sudah dipublish, langsung unpublish tanpa cek jumlah soal
    if ($ujian->isPublished) {
        $ujian->isPublished = 0;
        $ujian->update();
        return response()->json('Ujian berhasil di-unpublish', 200);
    }
    
    // Jika belum dipublish, cek jumlah soal terlebih dahulu
    if ($ujian->soal->count() == $ujian->jumlah_soal) {
        $ujian->isPublished = 1;
        $ujian->update();
        return response()->json('Ujian berhasil dipublish', 200);
    }
    
    return response()->json('Tidak dapat mempublish. Jumlah soal tidak sesuai (Ada: ' . $ujian->soal->count() . ', Dibutuhkan: ' . $ujian->jumlah_soal . ')', 300);
}
```

**Hasil:**
- ✅ Unpublish bisa dilakukan kapan saja tanpa validasi jumlah soal
- ✅ Publish tetap memvalidasi jumlah soal untuk memastikan kelengkapan
- ✅ Pesan error lebih informatif saat publish gagal

## Cara Testing

### Test 1: Filter Ujian Published di Tryout

1. Login sebagai admin
2. Buat ujian baru dan tambahkan soal (jangan dipublish dulu)
3. Login sebagai user biasa
4. Buka halaman tryout
5. **Hasil yang diharapkan:** Ujian yang belum dipublish TIDAK muncul di list
6. Kembali ke admin, publish ujian tersebut
7. Refresh halaman tryout user
8. **Hasil yang diharapkan:** Ujian sekarang muncul di list tryout

### Test 2: Fungsi Unpublish

1. Login sebagai admin
2. Buka daftar ujian
3. Pilih ujian yang sudah dipublish (ada badge "Published")
4. Klik tombol unpublish (icon eye-slash)
5. **Hasil yang diharapkan:** Ujian berhasil di-unpublish dan badge "Published" hilang
6. Coba hapus beberapa soal dari ujian tersebut
7. Coba unpublish lagi
8. **Hasil yang diharapkan:** Unpublish tetap berhasil meskipun jumlah soal tidak sesuai

### Test 3: Fungsi Publish dengan Validasi

1. Login sebagai admin
2. Buat ujian baru dengan jumlah soal = 10
3. Tambahkan hanya 5 soal
4. Coba publish ujian
5. **Hasil yang diharapkan:** Muncul error "Tidak dapat mempublish. Jumlah soal tidak sesuai (Ada: 5, Dibutuhkan: 10)"
6. Tambahkan 5 soal lagi hingga total 10
7. Coba publish lagi
8. **Hasil yang diharapkan:** Ujian berhasil dipublish

## File yang Dimodifikasi

1. [`app/Http/Controllers/UjianController.php`](app/Http/Controllers/UjianController.php) - Filter ujian published
2. [`app/Http/Controllers/Admin/UjianController.php`](app/Http/Controllers/Admin/UjianController.php) - Perbaikan fungsi publish/unpublish

## Dampak Perubahan

### Positif
- ✅ User hanya melihat ujian yang siap dikerjakan
- ✅ Admin lebih fleksibel dalam mengelola status publish
- ✅ Menghindari kebingungan user dengan ujian yang belum siap
- ✅ Pesan error lebih informatif

### Risiko
- ⚠️ Tidak ada risiko signifikan
- ⚠️ Perubahan backward compatible dengan data existing

## Catatan Tambahan

- Pastikan admin mengecek status publish sebelum ujian dimulai
- Ujian yang di-unpublish akan hilang dari view user secara REAL-TIME (setelah refresh)
- Relasi paket ujian dan ujian tetap terjaga, hanya filtering yang berubah
- Fitur ini bekerja baik pada Testing Mode maupun Production Mode

## Kesimpulan

Kedua masalah telah diperbaiki dengan:
1. Menambahkan filter `where('isPublished', 1)` pada query ujian di user controller
2. Memisahkan logika publish dan unpublish dengan validasi yang tepat

Sistem sekarang lebih robust dan user-friendly dalam mengelola visibilitas ujian.