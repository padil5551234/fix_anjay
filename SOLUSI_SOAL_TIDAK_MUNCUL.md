# Solusi: Soal yang Ditambahkan di Admin Tidak Muncul di User

## Masalah
Setelah menambahkan soal di admin dan mem-publish ujian, soal tidak muncul di sisi user dengan pesan "Tidak Ada Soal" atau "Ujian ini belum memiliki soal".

## Penyebab
Ujian yang sudah di-publish **belum di-link ke Paket Ujian**. Dalam sistem ini, user hanya bisa melihat ujian yang:
1. ✓ Sudah di-publish (`isPublished = 1`)
2. ✗ **Sudah di-link ke Paket Ujian** (missing!)
3. User sudah membeli Paket Ujian tersebut (kecuali `TESTING_MODE = true`)

## Struktur Sistem
```
User → Membeli Paket Ujian → Paket berisi beberapa Ujian → Setiap Ujian punya Soal
```

Relasi database:
- `paket_ujian` ↔ `paket_ujian_ujian` (pivot) ↔ `ujian` ↔ `soal`

## Solusi: Link Ujian ke Paket Ujian

### Langkah 1: Buka Menu Paket Ujian di Admin
1. Login sebagai admin
2. Buka menu **"Paket Ujian"** di sidebar admin
3. Pilih paket yang ingin digunakan, atau buat paket baru

### Langkah 2: Edit Paket Ujian
1. Klik tombol **Edit** (ikon pensil) pada paket yang dipilih
2. Di form edit, Anda akan melihat daftar ujian yang tersedia
3. **Centang/pilih ujian** yang ingin di-link ke paket ini
4. Klik **Simpan**

### Langkah 3: Atau Buat Paket Ujian Baru
Jika belum ada paket yang sesuai:
1. Klik tombol **"Tambah Paket"**
2. Isi data paket:
   - Nama Paket
   - Deskripsi
   - Harga
   - Waktu Mulai & Akhir Pendaftaran
   - Link WhatsApp Group (opsional)
3. **Centang ujian** yang ingin dimasukkan ke paket
4. Klik **Simpan**

### Langkah 4: Verifikasi
1. Pastikan ujian sudah muncul di kolom **"Ujian"** dalam tabel Paket Ujian
2. Jika `TESTING_MODE = true` di `.env`:
   - Login sebagai user biasa
   - Buka halaman Tryout
   - Ujian seharusnya sudah muncul di daftar
3. Jika `TESTING_MODE = false`:
   - User harus membeli paket terlebih dahulu
   - Setelah pembayaran sukses, ujian akan muncul di halaman Tryout user

## Cara Cek Status Ujian

### Di Database
Jalankan query ini untuk cek apakah ujian sudah ter-link:

```sql
-- Cek ujian yang belum di-link ke paket manapun
SELECT u.id, u.nama, u.isPublished, COUNT(puu.paket_ujian_id) as jumlah_paket
FROM ujian u
LEFT JOIN paket_ujian_ujian puu ON u.id = puu.ujian_id
GROUP BY u.id, u.nama, u.isPublished
HAVING COUNT(puu.paket_ujian_id) = 0 AND u.isPublished = 1;
```

### Di Admin Panel
1. Buka menu **Paket Ujian**
2. Lihat kolom **"Ujian"** untuk setiap paket
3. Ujian yang sudah di-link akan muncul sebagai list

## Mode Testing

Jika Anda ingin testing tanpa harus membeli paket:

1. Edit file `.env`:
```env
TESTING_MODE=true
```

2. Restart server:
```bash
php artisan serve
```

3. Dengan `TESTING_MODE=true`:
   - User bisa melihat SEMUA ujian yang published dan ter-link ke paket
   - Tidak perlu membeli paket
   - Cocok untuk development/testing

4. Untuk production, set:
```env
TESTING_MODE=false
```

## Checklist Troubleshooting

- [ ] Ujian sudah di-publish? (kolom `isPublished` = 1)
- [ ] Ujian sudah ter-link ke minimal 1 Paket Ujian?
- [ ] Paket Ujian memiliki waktu pendaftaran yang valid?
- [ ] User sudah membeli paket? (jika bukan testing mode)
- [ ] Status pembayaran = "Sukses"?
- [ ] Jumlah soal sesuai dengan `jumlah_soal` di ujian?

## Kode Referensi

### User Side Controller
File: `app/Http/Controllers/UjianController.php` (baris 54-78)
```php
$pembelianQuery = Pembelian::with([
    'paketUjian.ujian' => function ($query) {
        $query->where('isPublished', 1)->orderBy('nama', 'asc');
    },
    ...
])
->where('user_id', auth()->id())
->where('status', 'Sukses')
->latest('updated_at');
```

### Admin Side - Link Ujian ke Paket
File: `app/Http/Controllers/Admin/PaketUjianController.php`
- Store (baris 86): `$paketUjian->ujian()->attach($request->ujians);`
- Update (baris 131): `$paketUjian->ujian()->sync($request->ujians);`

## Kesimpulan

**Ujian yang sudah di-publish HARUS di-link ke Paket Ujian** agar bisa dilihat oleh user. Tanpa link ini, sistem tidak tahu paket mana yang memiliki ujian tersebut, sehingga user tidak bisa mengaksesnya.

Workflow lengkap:
1. Buat Ujian di menu Ujian
2. Tambah Soal ke Ujian
3. Publish Ujian (jumlah soal harus sesuai)
4. **Link Ujian ke Paket Ujian** ← LANGKAH PENTING INI
5. User beli Paket
6. User bisa akses Ujian