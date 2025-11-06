# Perbaikan: Ujian Tidak Muncul di User Setelah Membeli Paket

## Masalah
Ketika admin membuat dan mempublish ujian, ujian tersebut tidak muncul di halaman user meskipun user sudah membeli paket yang seharusnya berisi ujian tersebut.

## Penyebab
Ujian yang dibuat oleh admin tidak terhubung dengan paket manapun karena form pembuatan ujian tidak memiliki field untuk memilih paket.

## Solusi

### 1. Form (resources/views/admin/ujian/form.blade.php)
Menambahkan multi-select dropdown untuk paket ujian setelah field "Jenis Ujian".

### 2. JavaScript (resources/views/admin/ujian/index.blade.php)
Menambahkan:
- Inisialisasi Select2 untuk dropdown paket
- Fungsi `loadPackageOptions()` untuk memuat data paket dari server
- Integrasi dengan form create dan edit

### 3. Controller (app/Http/Controllers/Admin/UjianController.php)
Menambahkan:
- Validasi field `paket_ujian` (required, array, minimal 1)
- Sync relasi dengan `$ujian->paketUjian()->sync($request->paket_ujian)` pada method store dan update
- Method baru `getPackages($id)` untuk mengambil paket yang terhubung dengan ujian

### 4. Route (routes/web.php)
Menambahkan route: `GET /admin/ujian/{id}/packages`

## Cara Kerja

### Membuat Ujian Baru:
1. Admin memilih paket ujian dari dropdown (multi-select)
2. Sistem menyimpan ujian dan relasi ke tabel `paket_ujian_ujian`
3. Ujian akan muncul di paket yang dipilih

### Mengedit Ujian:
1. Sistem load paket yang sudah terhubung
2. Admin bisa mengubah paket
3. Sistem update relasi menggunakan `sync()`

### User Mengakses:
1. User membeli paket
2. Sistem menampilkan ujian yang terhubung dengan paket tersebut
3. User bisa mengerjakan ujian

## Testing

### Test 1: Buat Ujian Baru
- Login admin → Menu Ujian → Tambah
- Pilih paket ujian
- Simpan
- Verifikasi: Ujian terhubung dengan paket

### Test 2: User Akses Ujian
- Login user → Beli paket
- Klik "Lihat Paket"
- Verifikasi: Ujian yang dipublish dan terhubung dengan paket muncul

## Fitur
- Multi-select: 1 ujian bisa di beberapa paket
- Required field: Minimal 1 paket harus dipilih
- Auto-load: Paket terpilih otomatis load saat edit

## Catatan
- Ujian lama yang belum terhubung perlu dihubungkan manual oleh admin
- Pastikan ujian sudah dipublish agar muncul di user
- Relasi many-to-many melalui tabel pivot `paket_ujian_ujian`