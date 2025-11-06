# 📋 Dokumentasi Sistem Verifikasi Pembayaran Manual

## 🔄 Alur Verifikasi Pembayaran

### 1️⃣ **Sisi User (Peserta)**

#### Langkah Upload Bukti Transfer:
1. User memilih paket ujian dan klik "Lanjutkan"
2. Pilih metode pembayaran: **Transfer Manual**
3. Upload bukti transfer (format: JPG, PNG, JPEG, max 2MB)
4. Tambahkan catatan pembayaran (opsional)
5. Klik "Upload Bukti"

#### Status yang Ditampilkan:
- **Status Transaksi:** "Menunggu Verifikasi"
- **Status Verifikasi:** Badge biru "Menunggu Verifikasi Admin"
- **Pesan:** "Bukti transfer Anda sedang diverifikasi oleh admin."
- **Bukti Transfer:** Gambar yang sudah diupload ditampilkan dan bisa di-klik untuk full view
- **Button:** "Chat Admin" - Link ke WhatsApp admin untuk follow up

#### Cara User Tahu Sudah Diverifikasi:
**❌ SAAT INI:** User harus refresh halaman transaksi secara manual atau kembali cek halaman
**Status akan berubah menjadi:**
- ✅ **Jika Approved:** Status = "Sukses", email auto-verified, bisa mulai tryout
- ❌ **Jika Rejected:** Status = "Gagal", ada catatan admin tentang alasan penolakan

### 2️⃣ **Sisi Admin**

#### Menu Verifikasi:
Admin mengakses halaman khusus verifikasi pembayaran yang menampilkan:
- Daftar semua transaksi dengan `status_verifikasi = 'pending'`
- Informasi: Nama, Email, Paket, Harga, Tanggal Upload

#### Aksi Admin:
1. **Lihat Bukti Transfer:**
   - Button: "👁️ Lihat Bukti"
   - Menampilkan: Gambar bukti transfer, catatan user, detail transaksi

2. **Approve Pembayaran:**
   - Button: "✓ Approve"
   - Mengubah:
     - `status` → "Sukses"
     - `status_verifikasi` → "verified"
     - `verified_at` → timestamp saat ini
     - `verified_by` → ID admin yang approve
     - `jenis_pembayaran` → "Transfer Manual"
   - Bonus: Email user otomatis ter-verifikasi
   - Response: "Pembayaran berhasil diverifikasi dan email user telah diverifikasi"

3. **Reject Pembayaran:**
   - Button: "✗ Reject"
   - Mengubah:
     - `status` → "Gagal"
     - `status_verifikasi` → "rejected"
     - `verified_at` → timestamp saat ini
     - `verified_by` → ID admin yang reject
     - `catatan_admin` → Alasan penolakan (default: "Bukti transfer tidak valid")
   - Response: "Pembayaran ditolak"

## 📊 Status Flow

```
User Upload Bukti
     ↓
Status: "Menunggu Verifikasi"
status_verifikasi: "pending"
     ↓
   Admin Review
     ↓
  ┌─────┴─────┐
  ↓           ↓
Approve     Reject
  ↓           ↓
"Sukses"   "Gagal"
"verified" "rejected"
```

## 🔍 Kode Terkait

### Database Columns (table: pembelian)
```php
- status: 'Belum dibayar' | 'Menunggu Verifikasi' | 'Sukses' | 'Gagal'
- status_verifikasi: 'pending' | 'verified' | 'rejected'
- bukti_transfer: filename gambar
- catatan_pembayaran: catatan dari user
- catatan_admin: catatan dari admin
- verified_at: timestamp verifikasi
- verified_by: ID admin yang verifikasi
- whatsapp_admin: nomor WA admin (dari env)
```

### Routes
```php
// User
POST /pembelian/upload-bukti → PembelianController@uploadBuktiTransfer

// Admin
GET  /admin/pembelian/verifikasi → Admin\PembelianController@verifikasi
GET  /admin/pembelian/bukti/{id} → Admin\PembelianController@buktiTransfer
POST /admin/pembelian/verifikasi/{id} → Admin\PembelianController@prosesVerifikasi
```

### Files
- **User View:** [`resources/views/views_user/pembelian/index.blade.php`](resources/views/views_user/pembelian/index.blade.php:156-178)
- **User Controller:** [`app/Http/Controllers/PembelianController.php`](app/Http/Controllers/PembelianController.php:264-322)
- **Admin Controller:** [`app/Http/Controllers/Admin/PembelianController.php`](app/Http/Controllers/Admin/PembelianController.php:254-377)
- **Model:** [`app/Models/Pembelian.php`](app/Models/Pembelian.php:94-107)

## ⚠️ Catatan Penting

### Limitasi Sistem Saat Ini:
1. **Tidak Ada Notifikasi Otomatis:**
   - User tidak mendapat email/SMS saat pembayaran diverifikasi
   - User harus manual refresh halaman untuk cek status

2. **WhatsApp Manual:**
   - Link WhatsApp tersedia, tapi user harus klik manual
   - Tidak ada auto-message ke user

### Keuntungan Sistem:
1. ✅ Bukti transfer tersimpan permanen di storage
2. ✅ Admin dapat melihat bukti sebelum approve
3. ✅ Tracking lengkap (siapa approve, kapan)
4. ✅ Email user auto-verified setelah approve
5. ✅ Bisa reject dengan catatan alasan

## 💡 Rekomendasi Perbaikan

### 1. Tambahkan Notifikasi Email
Kirim email otomatis ke user saat:
- Status berubah menjadi "Sukses" (approved)
- Status berubah menjadi "Gagal" (rejected) dengan alasan

### 2. Real-time Notification
Implementasi notification bell di dashboard user untuk update status

### 3. Auto WhatsApp Message
Integrasi WhatsApp API untuk kirim pesan otomatis setelah verifikasi

### 4. Dashboard Monitoring
Tambahkan counter di admin dashboard:
- Jumlah pembayaran pending verifikasi
- Alert jika ada pending > 24 jam

## 🎯 FAQ

**Q: Berapa lama proses verifikasi?**
A: Tergantung admin, sistem tidak ada batasan waktu otomatis

**Q: Apakah user dapat re-upload bukti?**
A: Ya, user bisa upload ulang bukti yang akan replace file sebelumnya

**Q: Apa yang terjadi jika rejected?**
A: Status menjadi "Gagal" dan user bisa ulangi proses pembelian dari awal

**Q: Apakah ada log history verifikasi?**
A: Ya, tersimpan di database: verified_at, verified_by, catatan_admin
