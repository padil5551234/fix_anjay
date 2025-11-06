# Panduan Sistem Pembayaran Manual

## Ringkasan Perubahan

Sistem pembayaran telah diubah menjadi **pembayaran manual** dengan upload bukti transfer dan verifikasi admin. User tidak lagi menggunakan Midtrans otomatis sebagai metode pembayaran utama, melainkan transfer manual yang memerlukan verifikasi dari admin.

## Fitur Utama

### 1. Upload Bukti Transfer (User)
- User dapat memilih metode "Transfer Manual" saat checkout
- User upload bukti transfer (screenshot/foto)
- User dapat menambahkan catatan pembayaran
- User langsung mendapat link WhatsApp untuk chat dengan admin
- Status pembayaran berubah menjadi "Menunggu Verifikasi"

### 2. Verifikasi Pembayaran (Admin)
- Admin dapat melihat semua pembayaran yang menunggu verifikasi
- Admin dapat melihat detail bukti transfer
- Admin dapat approve atau reject pembayaran
- Admin dapat menambahkan catatan saat verifikasi
- Notifikasi otomatis setelah verifikasi

### 3. Akses Konten
User hanya dapat mengakses tryout, materi, dan live zoom **setelah pembayaran diverifikasi** (status = "Sukses")

## Alur Pembayaran Manual

```
1. User pilih paket ujian
   ↓
2. User pilih "Transfer Manual"
   ↓
3. User upload bukti transfer
   ↓
4. Status: "Menunggu Verifikasi"
   ↓
5. User chat admin via WhatsApp
   ↓
6. Admin verifikasi pembayaran
   ↓
7. Status: "Sukses" (jika approved)
   ↓
8. User dapat akses tryout, materi, live zoom
```

## Instalasi & Konfigurasi

### 1. Migration
```bash
php artisan migrate
```

Migration akan menambahkan kolom-kolom berikut ke tabel `pembelian`:
- `bukti_transfer` - path file bukti transfer
- `catatan_pembayaran` - catatan dari user
- `status_verifikasi` - status verifikasi (pending/verified/rejected)
- `catatan_admin` - catatan dari admin
- `verified_at` - waktu verifikasi
- `verified_by` - admin yang memverifikasi
- `whatsapp_admin` - nomor WhatsApp admin

### 2. Konfigurasi Environment (.env)

Tambahkan nomor WhatsApp admin ke file `.env`:

```env
# WhatsApp Admin untuk Chat Manual Payment
WHATSAPP_ADMIN=6281234567890
```

**Format nomor:**
- Gunakan kode negara (62 untuk Indonesia)
- Tanpa tanda + atau spasi
- Contoh: 6281234567890

### 3. Storage Permission

Pastikan folder storage dapat diakses:

```bash
php artisan storage:link
```

## Cara Menggunakan

### Untuk User

#### 1. Membeli Paket
1. Pilih paket ujian yang diinginkan
2. Klik "Beli Paket"

#### 2. Upload Bukti Transfer
1. Pilih metode "Transfer Manual"
2. Klik tombol "Lanjutkan"
3. Lihat informasi rekening transfer
4. Transfer sesuai nominal yang ditampilkan
5. Upload bukti transfer (screenshot/foto)
6. Tambahkan catatan jika perlu
7. Klik "Upload Bukti"

#### 3. Chat Admin
1. Setelah upload berhasil, klik tombol "Chat Admin"
2. WhatsApp akan terbuka otomatis
3. Konfirmasi pembayaran ke admin
4. Tunggu verifikasi dari admin

#### 4. Akses Konten
Setelah pembayaran diverifikasi:
- Akses tryout melalui menu "Tryout"
- Akses materi melalui menu "Materi"
- Akses live zoom melalui menu "Live Zoom"

### Untuk Admin

#### 1. Mengakses Halaman Verifikasi
1. Login sebagai admin
2. Buka menu "Pembelian" > "Verifikasi Pembayaran"
3. Atau akses: `/admin/pembelian/verifikasi`

#### 2. Melihat Bukti Transfer
1. Klik tombol "Lihat Bukti" pada tabel
2. Modal akan menampilkan:
   - Detail pembayaran (nama, email, paket, harga)
   - Catatan dari user
   - Foto bukti transfer

#### 3. Verifikasi Pembayaran

**Untuk Approve:**
1. Klik tombol "Approve" (hijau)
2. Tambahkan catatan jika perlu (opsional)
3. Klik "Proses"
4. Status berubah menjadi "Sukses"
5. User dapat langsung akses konten

**Untuk Reject:**
1. Klik tombol "Reject" (merah)
2. **Wajib** tambahkan alasan penolakan
3. Klik "Proses"
4. Status berubah menjadi "Gagal"
5. User perlu upload ulang bukti transfer

## Informasi Rekening Transfer

Update informasi rekening di file:
`resources/views/views_user/pembelian/index.blade.php`

Cari bagian:
```html
<h6><i class="fas fa-info-circle"></i> Informasi Rekening Transfer:</h6>
<p class="mb-1"><strong>Bank:</strong> BCA / Mandiri / BNI</p>
<p class="mb-1"><strong>No. Rekening:</strong> 1234567890</p>
<p class="mb-1"><strong>Atas Nama:</strong> PT Bimbel Indonesia</p>
```

Ganti dengan informasi rekening yang sebenarnya.

## Status Pembayaran

| Status | Keterangan |
|--------|------------|
| Belum dibayar | User belum melakukan pembayaran |
| Menunggu Verifikasi | Bukti transfer sudah diupload, menunggu admin |
| Sukses | Pembayaran sudah diverifikasi admin |
| Gagal | Pembayaran ditolak admin |

## Status Verifikasi

| Status | Keterangan |
|--------|------------|
| pending | Menunggu verifikasi admin |
| verified | Sudah diverifikasi dan approved |
| rejected | Ditolak oleh admin |

## File-File yang Diubah

### Backend
1. **Migration:**
   - `database/migrations/2025_11_06_044626_add_manual_payment_fields_to_pembelian_table.php`

2. **Models:**
   - `app/Models/Pembelian.php` - Tambah field dan relasi

3. **Controllers:**
   - `app/Http/Controllers/PembelianController.php` - Method `uploadBuktiTransfer()`
   - `app/Http/Controllers/Admin/PembelianController.php` - Method verifikasi
   - `app/Http/Controllers/UjianController.php` - Cek status 'Sukses'
   - `app/Http/Controllers/UserMaterialController.php` - Cek status 'Sukses'
   - `app/Http/Controllers/UserLiveClassController.php` - Sudah cek status 'Sukses'

4. **Routes:**
   - `routes/web.php` - Route upload bukti dan verifikasi

### Frontend
1. **User Views:**
   - `resources/views/views_user/pembelian/index.blade.php` - Form upload bukti

2. **Admin Views:**
   - `resources/views/admin/pembelian/verifikasi.blade.php` - Halaman verifikasi (baru)

## Keamanan

### Validasi Upload
- Hanya file image yang diizinkan (jpg, png, jpeg)
- Maksimal ukuran file: 2MB
- File disimpan dengan nama unik untuk mencegah overwrite

### Akses Control
- User hanya bisa upload untuk pembelian miliknya sendiri
- Admin hanya bisa verifikasi dengan role admin/bendahara
- File bukti transfer hanya bisa diakses oleh admin dan pemilik pembelian

## Troubleshooting

### User tidak bisa upload bukti
**Solusi:**
1. Cek permission folder storage: `chmod -R 775 storage`
2. Pastikan symlink sudah dibuat: `php artisan storage:link`
3. Cek ukuran file (max 2MB)
4. Cek format file (harus jpg/png/jpeg)

### Admin tidak bisa akses halaman verifikasi
**Solusi:**
1. Pastikan user memiliki role 'admin' atau 'bendahara'
2. Cek route di `routes/web.php`
3. Clear cache: `php artisan config:clear`

### WhatsApp tidak terbuka otomatis
**Solusi:**
1. Cek nomor WhatsApp di `.env`
2. Pastikan format nomor benar (628xxx tanpa +)
3. Cek browser mendukung `wa.me` link

### Status tidak berubah setelah verifikasi
**Solusi:**
1. Cek database tabel pembelian
2. Cek log error: `storage/logs/laravel.log`
3. Refresh halaman user

## Testing

### Test Upload Bukti Transfer
```bash
# 1. Buat pembelian baru
# 2. Pilih transfer manual
# 3. Upload file test
# 4. Cek database: status harus 'Menunggu Verifikasi'
# 5. Cek file tersimpan di storage/app/public/bukti_transfer/
```

### Test Verifikasi Admin
```bash
# 1. Login sebagai admin
# 2. Buka /admin/pembelian/verifikasi
# 3. Approve/reject pembayaran
# 4. Cek perubahan status di database
# 5. Cek user bisa akses tryout
```

## Support

Untuk pertanyaan atau masalah, hubungi:
- Email: support@bimbel.com
- WhatsApp: +62 812-3456-7890

## Changelog

### Version 1.0.0 (2025-11-06)
- ✅ Implementasi sistem pembayaran manual
- ✅ Upload bukti transfer
- ✅ Verifikasi admin
- ✅ Integrasi WhatsApp admin
- ✅ Update akses konten berdasarkan status verifikasi
- ✅ UI/UX pembayaran manual
- ✅ Dokumentasi lengkap

## Catatan Penting

⚠️ **PENTING:**
1. Backup database sebelum melakukan migration
2. Test di environment development dulu
3. Update informasi rekening sebelum go live
4. Set nomor WhatsApp admin yang aktif
5. Informasikan perubahan sistem ke semua user
6. Siapkan SOP verifikasi pembayaran untuk admin