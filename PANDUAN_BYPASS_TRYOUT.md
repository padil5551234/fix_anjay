# Panduan Bypass Tryout - Mode Testing

## Overview
Sistem tryout sudah dilengkapi dengan **Testing Mode** yang memungkinkan user mengakses tryout tanpa harus membeli paket terlebih dahulu. Fitur ini sangat berguna untuk:
- Testing dan debugging sistem
- Demo kepada calon pengguna
- Pengembangan fitur baru
- Quality Assurance (QA)

## Cara Mengaktifkan Bypass

### 1. Setting Environment Variable

Buka file `.env` dan pastikan baris berikut sudah diset ke `true`:

```env
# Testing Mode Configuration
# Set to true untuk mengizinkan akses tryout tanpa pembayaran (untuk testing)
# Set to false untuk mode production normal
TESTING_MODE=true
```

**Status Saat Ini: ✅ SUDAH AKTIF**

### 2. Restart Server (Jika Diperlukan)

Jika Anda baru mengubah nilai `TESTING_MODE`, restart server Laravel:

```bash
# Hentikan server yang sedang berjalan (Ctrl+C)
# Kemudian jalankan kembali
php artisan serve
```

## Fitur yang Di-bypass

Ketika `TESTING_MODE=true`, sistem akan melewati validasi berikut:

### ✅ 1. Bypass Pemeriksaan Pembelian Paket
**File**: `app/Http/Controllers/UjianController.php`

**Method `index()` - Baris 27-60**
- User dapat melihat **SEMUA paket ujian** yang tersedia
- Tidak perlu membeli paket untuk melihat daftar tryout
- Semua ujian akan ditampilkan di halaman tryout

**Method `show()` - Baris 209-212**
- User dapat mengakses detail ujian
- Langsung bisa memulai tryout tanpa cek status pembelian

### ✅ 2. Bypass Validasi Profil Lengkap
**File**: `app/Http/Controllers/PembelianController.php`

**Method `beliPaket()` - Baris 78-109**
- User tidak perlu melengkapi profil
- Bisa langsung akses tanpa mengisi:
  - Nomor HP
  - Provinsi, Kabupaten, Kecamatan
  - Asal Sekolah
  - Sumber Informasi
  - Program Studi (Prodi)
  - Penempatan
  - Instagram

**Pengecualian**: Tutor (role tutor) otomatis di-bypass meskipun TESTING_MODE=false

## Cara Menggunakan

### Untuk User Biasa:

1. **Login** ke sistem dengan akun user biasa
2. **Buka halaman Tryout** dari menu dashboard
3. **Pilih tryout** yang ingin dikerjakan
4. **Klik "Mulai Ujian"** - sistem akan langsung memproses tanpa cek pembayaran
5. **Kerjakan tryout** seperti biasa

### Flow Normal (TESTING_MODE=false):
```
Login → Dashboard → Beli Paket → Bayar → Akses Tryout → Mulai Ujian
```

### Flow dengan Bypass (TESTING_MODE=true):
```
Login → Dashboard → Akses Tryout → Mulai Ujian
```

## Implementasi Teknis

### Kode di UjianController.php

```php
// Method index() - Menampilkan daftar tryout
if (env('TESTING_MODE', false)) {
    // Ambil SEMUA paket ujian tanpa cek pembelian
    $paketQuery = PaketUjian::with([
        'ujian' => function ($query) {
            $query->orderBy('nama', 'asc');
        },
        'ujian.ujianUser' => function ($query) {
            $query->where('user_id', auth()->user()->id);
        }
    ]);
    
    // ... proses data
    
    return view('views_user.ujian.tryout', compact('data', 'tryout'));
}
```

```php
// Method show() - Menampilkan detail ujian
if (env('TESTING_MODE', false)) {
    $betweenTime = Carbon::now()->between($ujian->waktu_mulai, $ujian->waktu_akhir);
    return view('views_user.ujian.show', compact('ujian', 'betweenTime'));
}
```

### Kode di PembelianController.php

```php
// Method beliPaket() - Bypass cek profil lengkap
if (!auth()->user()->hasRole('tutor') && !env('TESTING_MODE', false)) {
    // Validasi profil lengkap hanya jika bukan testing mode
    // ...
}
```

## Mode Production

### Cara Menonaktifkan Bypass

Ketika sistem sudah siap untuk production, ubah setting di `.env`:

```env
TESTING_MODE=false
```

Kemudian restart server:
```bash
php artisan config:clear
php artisan cache:clear
php artisan serve
```

### Validasi Mode Production

Setelah `TESTING_MODE=false`, pastikan:
- ✅ User harus membeli paket sebelum akses tryout
- ✅ User harus melengkapi profil sebelum pembelian
- ✅ Sistem pembayaran Midtrans berfungsi normal
- ✅ WhatsApp group link muncul setelah pembayaran sukses

## Troubleshooting

### ❌ Bypass Tidak Berfungsi

**Solusi**:
1. Periksa file `.env` pastikan `TESTING_MODE=true`
2. Clear cache Laravel:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```
3. Restart server:
   ```bash
   php artisan serve
   ```

### ❌ Masih Diminta Membeli Paket

**Solusi**:
1. Logout dan login kembali
2. Clear browser cache (Ctrl+Shift+Delete)
3. Periksa log error di `storage/logs/laravel.log`

### ❌ Error "Carbon now between"

**Solusi**:
- Pastikan `waktu_mulai` dan `waktu_akhir` ujian sudah diset dengan benar
- Testing mode tidak mem-bypass validasi waktu ujian

## Keamanan

### ⚠️ PENTING - Jangan Aktifkan di Production!

- **TESTING_MODE=true** hanya untuk development/testing
- **JANGAN** deploy ke production dengan testing mode aktif
- Gunakan file `.env.production` terpisah untuk server production

### Checklist Pre-Production

Sebelum deploy ke production, pastikan:
- [ ] `TESTING_MODE=false` di `.env` production
- [ ] Midtrans credentials sudah diisi dengan benar
- [ ] Database production terpisah dari testing
- [ ] SSL certificate sudah terpasang
- [ ] Backup database sudah dijadwalkan

## FAQ

**Q: Apakah data ujian di testing mode sama dengan production?**  
A: Ya, data ujian sama. Yang berbeda hanya akses tanpa pembayaran.

**Q: Apakah hasil ujian di testing mode tersimpan?**  
A: Ya, semua hasil ujian tersimpan di database seperti ujian normal.

**Q: Bisakah sebagian user bypass dan sebagian tidak?**  
A: Saat ini tidak. TESTING_MODE berlaku untuk semua user. Alternatif: buat role khusus atau voucher gratis.

**Q: Apakah tutor bisa bypass tanpa testing mode?**  
A: Ya, tutor otomatis bypass validasi profil lengkap meskipun TESTING_MODE=false.

## Kontak Support

Jika mengalami masalah dengan fitur bypass atau testing mode:
- Periksa dokumentasi ini
- Cek log error di `storage/logs/laravel.log`
- Review kode di `app/Http/Controllers/UjianController.php`
- Review kode di `app/Http/Controllers/PembelianController.php`

---

**Dibuat**: 2025-11-05  
**Versi**: 1.0  
**Status**: ✅ Bypass Aktif (TESTING_MODE=true)