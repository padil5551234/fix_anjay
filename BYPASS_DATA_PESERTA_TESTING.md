# 🔧 Panduan Bypass Data Peserta & Testing Mode

## 📋 Ringkasan Perbaikan

Dokumen ini menjelaskan perbaikan yang telah dilakukan untuk mengatasi masalah-masalah berikut:

### ✅ Masalah yang Diperbaiki:

1. **Soal Tryout tidak muncul di user** ✓
2. **Live Zoom tidak muncul di user** ✓
3. **Bank Soal tidak muncul di user** ✓
4. **Admin tidak bisa review soal** ✓
5. **Tidak bisa mengisi data peserta untuk membeli paket** ✓
6. **Bypass untuk melewati isi data peserta** ✓

---

## 🔑 Mode Testing

### Mengaktifkan Testing Mode

Edit file `.env` dan set:

```env
TESTING_MODE=true
```

### Fitur Testing Mode:

Ketika `TESTING_MODE=true`, sistem akan:

1. ✅ **Bypass pembayaran** - Semua paket dapat diakses tanpa perlu membeli
2. ✅ **Bypass data peserta** - Tidak perlu mengisi profil lengkap untuk membeli paket
3. ✅ **Akses semua tryout** - Semua ujian tryout dapat diakses langsung
4. ✅ **Akses semua live zoom** - Semua kelas live zoom dapat dilihat
5. ✅ **Akses semua bank soal** - Semua bank soal dapat didownload

### Untuk Production Mode:

Set di file `.env`:

```env
TESTING_MODE=false
```

Sistem akan kembali normal dengan:
- Wajib pembayaran untuk akses paket
- Wajib mengisi data peserta lengkap
- Akses konten sesuai paket yang dibeli

---

## 📝 Detail Perbaikan

### 1. Perbaikan Status Pembelian

**Masalah:** Inkonsistensi status pembelian
- `UjianController` menggunakan status `'Sukses'`
- `UserLiveClassController` dan `UserBankSoalController` menggunakan `'Sudah Bayar'`

**Solusi:** Standardisasi ke status `'Sukses'` di semua controller

**File yang diperbaiki:**
- [`app/Http/Controllers/UserLiveClassController.php`](app/Http/Controllers/UserLiveClassController.php)
- [`app/Http/Controllers/UserBankSoalController.php`](app/Http/Controllers/UserBankSoalController.php)

### 2. Testing Mode untuk Tryout

**File:** [`app/Http/Controllers/UjianController.php`](app/Http/Controllers/UjianController.php:26-60)

```php
// Testing Mode: Bypass payment check
if (env('TESTING_MODE', false)) {
    // Ambil semua paket ujian yang tersedia
    $paketQuery = PaketUjian::with([
        'ujian' => function ($query) {
            $query->orderBy('nama', 'asc');
        },
        // ...
    ]);
    // ... semua tryout dapat diakses
}
```

### 3. Testing Mode untuk Live Zoom

**File:** [`app/Http/Controllers/UserLiveClassController.php`](app/Http/Controllers/UserLiveClassController.php:22-41)

```php
// Testing Mode: Show all live classes
if (env('TESTING_MODE', false)) {
    // In testing mode, show all available live classes
    // No package restriction
} else {
    // Production Mode: Check purchased packages
    // ...
}
```

### 4. Testing Mode untuk Bank Soal

**File:** [`app/Http/Controllers/UserBankSoalController.php`](app/Http/Controllers/UserBankSoalController.php:22-47)

```php
// Testing Mode: Show all bank soal
if (env('TESTING_MODE', false)) {
    // In testing mode, show all available bank soal
    // No package restriction
} else {
    // Production Mode: Check purchased packages
    // ...
}
```

### 5. Bypass Data Peserta

**File:** [`app/Http/Controllers/PembelianController.php`](app/Http/Controllers/PembelianController.php:78)

```php
// Skip profile check for tutors or in testing mode
if (!auth()->user()->hasRole('tutor') && !env('TESTING_MODE', false)) {
    // Cek kelengkapan profil
    // ...
}
```

### 6. Admin Preview Soal

**Sudah tersedia:** Admin dapat melihat preview soal melalui:

**Route:** `/admin/ujian/{id}/preview`

**File:** [`app/Http/Controllers/Admin/UjianController.php`](app/Http/Controllers/Admin/UjianController.php:168-182)

**Cara menggunakan:**
1. Login sebagai admin
2. Buka halaman daftar ujian
3. Klik tombol preview pada ujian yang ingin direview

---

## 🎯 Cara Penggunaan

### Untuk Testing/Development:

1. **Aktifkan Testing Mode**
   ```bash
   # Edit .env
   TESTING_MODE=true
   ```

2. **Login ke sistem** sebagai user biasa

3. **Akses langsung**:
   - `/tryout` - Lihat semua tryout
   - `/live-zoom` - Lihat semua live zoom
   - `/bank-soal` - Lihat semua bank soal
   - `/pembelian` - Beli paket tanpa isi data

### Untuk Production:

1. **Nonaktifkan Testing Mode**
   ```bash
   # Edit .env
   TESTING_MODE=false
   ```

2. **User harus**:
   - Lengkapi profil terlebih dahulu
   - Beli paket untuk akses konten
   - Bayar sesuai harga paket

### Untuk Admin Review Soal:

1. Login sebagai admin
2. Buka menu **Ujian**
3. Klik ikon **preview** (mata) pada ujian
4. Review semua soal dan pembahasannya

---

## ⚙️ Konfigurasi Environment

File `.env` yang relevan:

```env
# Testing Mode Configuration
# Set to true untuk mengizinkan akses tanpa pembayaran (untuk testing)
# Set to false untuk mode production normal
TESTING_MODE=true

# Midtrans Configuration (untuk production)
MIDTRANS_MERCHANT_ID=your-merchant-id
MIDTRANS_CLIENT_KEY=your-client-key
MIDTRANS_SERVER_KEY=your-server-key
MIDTRANS_TIPE=sandbox
```

---

## 🔒 Keamanan

### ⚠️ PENTING:

1. **Jangan aktifkan `TESTING_MODE=true` di production server!**
2. Testing mode hanya untuk development/testing
3. Pastikan `.env` tidak di-commit ke repository
4. Untuk production, selalu gunakan `TESTING_MODE=false`

### Checklist Before Production:

- [ ] `TESTING_MODE=false` di `.env`
- [ ] Midtrans credentials sudah diisi dengan benar
- [ ] Test payment flow sudah berjalan normal
- [ ] Profile validation sudah aktif

---

## 🧪 Testing Checklist

### Test dengan TESTING_MODE=true:

- [ ] User bisa akses semua tryout tanpa beli paket
- [ ] User bisa akses semua live zoom tanpa beli paket
- [ ] User bisa akses semua bank soal tanpa beli paket
- [ ] User bisa beli paket tanpa isi data peserta
- [ ] Admin bisa preview soal

### Test dengan TESTING_MODE=false:

- [ ] User tidak bisa akses tryout sebelum beli paket
- [ ] User tidak bisa akses live zoom sebelum beli paket
- [ ] User tidak bisa akses bank soal sebelum beli paket
- [ ] User harus isi data peserta lengkap untuk beli paket
- [ ] Payment flow berjalan normal
- [ ] Admin tetap bisa preview soal

---

## 📞 Troubleshooting

### Soal masih tidak muncul?

1. Pastikan ujian sudah di-**publish** oleh admin
2. Cek `TESTING_MODE` sudah `true` di `.env`
3. Clear cache: `php artisan config:clear`
4. Cek apakah ujian memiliki soal

### Live Zoom tidak muncul?

1. Cek `TESTING_MODE` sudah `true` di `.env`
2. Pastikan ada data live class di database
3. Clear cache: `php artisan config:clear`

### Bank Soal tidak muncul?

1. Cek `TESTING_MODE` sudah `true` di `.env`
2. Pastikan ada data bank soal di database
3. Cek field `batch_id` pada bank soal

### Masih diminta isi data peserta?

1. Cek `TESTING_MODE` sudah `true` di `.env`
2. Restart server: `php artisan serve`
3. Clear browser cache/cookies

---

## 📚 File yang Dimodifikasi

1. ✅ `app/Http/Controllers/UjianController.php`
2. ✅ `app/Http/Controllers/UserLiveClassController.php`
3. ✅ `app/Http/Controllers/UserBankSoalController.php`
4. ✅ `app/Http/Controllers/PembelianController.php`
5. ✅ `.env` (tambahan konfigurasi TESTING_MODE)

---

## 🎓 Kesimpulan

Semua fitur sudah diperbaiki dan siap digunakan:

✅ **Tryout** - Soal dapat diakses user (dengan testing mode atau setelah beli paket)
✅ **Live Zoom** - Kelas dapat diakses user (dengan testing mode atau setelah beli paket)
✅ **Bank Soal** - Materi dapat diakses user (dengan testing mode atau setelah beli paket)
✅ **Admin Preview** - Admin dapat mereview soal sebelum publish
✅ **Bypass Data** - Testing mode melewati requirement isi data peserta
✅ **Status Fix** - Konsistensi status pembelian di seluruh sistem

**Mode Testing aktif** - Set `TESTING_MODE=true` untuk bypass semua restriction!

---

Dibuat: 2025-10-19
Update terakhir: 2025-10-19