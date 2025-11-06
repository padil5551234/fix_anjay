# Panduan Pembatasan Akses Berdasarkan Pembelian Paket

## 📋 Ringkasan

Sistem sekarang **hanya mengizinkan akses** ke fitur Live Zoom, Materi, dan Tryout bagi pengguna yang telah **membeli paket DAN pembayaran sudah diverifikasi** oleh admin.

## 🔒 Fitur yang Dibatasi

### 1. **Tryout/Ujian** 
- Hanya pengguna dengan paket terverifikasi yang dapat melihat daftar tryout
- Hanya pengguna dengan paket terverifikasi yang dapat mengakses dan mengerjakan tryout
- Mode Testing (TESTING_MODE) telah **dihapus** untuk keamanan

### 2. **Materi (Materials)**
- Hanya pengguna dengan paket terverifikasi yang dapat mengakses materi berbayar
- Materi publik (`is_public = true`) tetap dapat diakses semua user
- Download materi hanya untuk user dengan akses terverifikasi

### 3. **Live Zoom**
- Hanya pengguna dengan paket terverifikasi yang dapat melihat jadwal kelas
- Hanya pengguna dengan paket terverifikasi yang dapat join kelas
- Mode Testing (TESTING_MODE) telah **dihapus**

## ✅ Status Verifikasi Pembayaran

Pembayaran dianggap **VERIFIED** jika memenuhi salah satu kondisi berikut:

1. `status_verifikasi = 'verified'` (Verifikasi manual oleh admin)
2. `status = 'Sukses'` (Pembayaran otomatis via Midtrans)

## 🔧 Perubahan Teknis

### 1. Model Pembelian (app/Models/Pembelian.php)

Ditambahkan **scope methods** untuk mempermudah query:

```php
// Scope untuk pembelian terverifikasi
Pembelian::verified()->get();

// Scope untuk pembelian user tertentu
Pembelian::forUser($userId)->get();

// Scope untuk paket tertentu
Pembelian::forPackage($paketId)->get();

// Kombinasi scope
Pembelian::forUser($userId)->forPackage($paketId)->verified()->exists();
```

### 2. UjianController (app/Http/Controllers/UjianController.php)

**Perubahan pada method `index()`:**
- Menghapus logika TESTING_MODE
- Hanya menampilkan tryout dari paket yang sudah diverifikasi
- Menggunakan scope `verified()` untuk filter pembelian

**Perubahan pada method `show()`:**
- Menghapus logika TESTING_MODE bypass
- Verifikasi akses sebelum menampilkan detail tryout
- Error message yang lebih informatif jika akses ditolak

### 3. UserMaterialController (app/Http/Controllers/UserMaterialController.php)

**Perubahan pada semua methods:**
- `index()`: Filter materi berdasarkan paket terverifikasi
- `show()`: Cek akses terverifikasi sebelum menampilkan materi
- `download()`: Cek akses terverifikasi sebelum download
- `getMaterialsByPackage()`: Validasi kepemilikan paket terverifikasi

### 4. UserLiveClassController (app/Http/Controllers/UserLiveClassController.php)

**Perubahan pada semua methods:**
- `index()`: Hanya tampilkan kelas dari paket terverifikasi
- `show()`: Cek akses terverifikasi sebelum join kelas
- Menghapus logika TESTING_MODE

## 📊 Flow Akses User

```
User Login
    ↓
Beli Paket
    ↓
Upload Bukti Transfer / Bayar via Midtrans
    ↓
Admin Verifikasi (Manual) / Auto Verified (Midtrans)
    ↓
status_verifikasi = 'verified' ATAU status = 'Sukses'
    ↓
User dapat akses Live Zoom, Materi, dan Tryout
```

## 🚫 Pesan Error

Jika user mencoba akses tanpa pembelian terverifikasi:

### Tryout:
```
403 Forbidden
"Anda tidak memiliki akses ke tryout ini. Silakan beli paket terlebih dahulu dan pastikan pembayaran sudah diverifikasi."
```

### Materi (Download):
```
403 Forbidden
"Anda tidak memiliki akses untuk mengunduh materi ini. Pastikan pembayaran paket sudah diverifikasi."
```

### Live Zoom:
```
403 Forbidden
"Anda tidak memiliki akses ke kelas ini. Silakan beli paket terlebih dahulu dan pastikan pembayaran sudah diverifikasi."
```

## 👨‍💼 Untuk Admin

### Verifikasi Pembayaran Manual

1. Login sebagai admin/bendahara
2. Buka menu **Pembelian** → **Verifikasi Pembayaran**
3. Lihat daftar pembayaran dengan status `pending`
4. Klik detail untuk melihat bukti transfer
5. Klik **Verifikasi** untuk approve atau **Tolak** untuk reject
6. Setelah diverifikasi, user otomatis dapat akses

### Status Pembelian

- `pending`: Menunggu verifikasi (ada bukti transfer)
- `verified`: Sudah diverifikasi oleh admin
- `rejected`: Ditolak oleh admin
- `Sukses`: Pembayaran berhasil (Midtrans)

## 🧪 Testing

### Test User dengan Akses

1. Login sebagai user biasa
2. Beli paket melalui menu **Pembelian**
3. Upload bukti transfer
4. Login sebagai admin dan verifikasi pembayaran
5. Login kembali sebagai user
6. Cek akses ke Live Zoom, Materi, dan Tryout - harus bisa diakses

### Test User tanpa Akses

1. Login sebagai user baru (belum beli paket)
2. Coba akses Live Zoom - harus kosong/tidak ada kelas
3. Coba akses Tryout - harus kosong/tidak ada tryout
4. Coba akses Materi - hanya materi public yang muncul

## ⚠️ Catatan Penting

1. **Mode Testing Dihapus**: Variabel `TESTING_MODE` tidak lagi berpengaruh untuk keamanan
2. **Verifikasi Wajib**: Admin/bendahara harus memverifikasi pembayaran manual
3. **Pembayaran Midtrans**: Otomatis terverifikasi tanpa perlu aksi admin
4. **Materi Public**: Tetap dapat diakses semua user tanpa pembayaran
5. **Relasi Database**: Pastikan relasi `pembelian` → `paket_ujian` → `ujian/materials/live_classes` tetap terjaga

## 🔄 Cara Rollback (Jika Diperlukan)

Jika ingin mengembalikan ke sistem lama dengan TESTING_MODE:

1. Restore file backup:
   - `app/Http/Controllers/UjianController.php`
   - `app/Http/Controllers/UserMaterialController.php`
   - `app/Http/Controllers/UserLiveClassController.php`

2. Atau tambahkan kembali kondisi TESTING_MODE di setiap controller

## 📞 Support

Jika ada masalah atau pertanyaan:
1. Cek error log di `storage/logs/laravel.log`
2. Pastikan relasi database sudah benar
3. Cek status verifikasi di tabel `pembelian`

---

**Tanggal Implementasi**: 2025-11-06  
**Versi**: 1.0  
**Status**: ✅ Production Ready