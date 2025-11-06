# Implementasi Integrasi Materi Pembelajaran

## Ringkasan Perubahan

Dokumen ini menjelaskan perubahan yang telah dibuat untuk mengintegrasikan sistem materi pembelajaran antara admin, user, dan tutor dalam aplikasi tryout.

## 1. Model Updates

### LiveClass Model (`app/Models/LiveClass.php`)
**Penambahan:**
- Scope `upcoming()` - Filter live class yang akan datang
- Scope `completed()` - Filter live class yang sudah selesai
- Scope `ongoing()` - Filter live class yang sedang berlangsung
- Method `getPlatformIcon()` - Mendapatkan icon platform (Zoom, Google Meet, dll)
- Method `getStatusBadgeClass()` - Mendapatkan class badge untuk status

### Material Model (`app/Models/Material.php`)
**Penambahan:**
- Scope `public()` - Filter materi publik
- Scope `featured()` - Filter materi featured
- Method `isDownloadable()` - Cek apakah materi bisa didownload
- Method `extractYoutubeVideoId()` - Extract ID dari URL YouTube
- Method `getYoutubeThumbnail()` - Mendapatkan thumbnail YouTube
- Method `getYoutubeEmbedUrl()` - Mendapatkan embed URL YouTube
- Method `getTypeIcon()` - Mendapatkan icon berdasarkan tipe materi
- Method `getTypeBadgeClass()` - Mendapatkan class badge untuk tipe
- Method `getFormattedFileSize()` - Format ukuran file
- Method `getFormattedDuration()` - Format durasi video

## 2. Database Migrations

### New Migration (`database/migrations/2024_12_14_120000_add_batch_id_and_mapel_to_live_classes_and_materials.php`)
**Menambahkan:**
- Field `batch_id` ke tabel `live_classes` (relasi ke paket_ujian)
- Field `batch_id` ke tabel `materials` (relasi ke paket_ujian)
- Field `mapel` (mata pelajaran) ke tabel `materials`

## 3. Controllers

### UserMaterialController (`app/Http/Controllers/UserMaterialController.php`)
**Controller baru untuk user mengakses materi:**
- `index()` - Menampilkan daftar materi yang bisa diakses user
- `show()` - Menampilkan detail materi
- `download()` - Download file materi
- `getMaterialsByPackage()` - API endpoint untuk mendapatkan materi berdasarkan paket

**Fitur:**
- User dapat melihat materi publik dan materi dari paket yang sudah dibeli
- Filter berdasarkan tipe, paket, mapel, dan pencarian
- Otomatis increment views dan downloads
- Access control berdasarkan pembelian paket

## 4. Views

### Tutor Views
**Dibuat views baru:**
- `resources/views/tutor/materials/index.blade.php` - Daftar materi tutor
- `resources/views/tutor/materials/edit.blade.php` - Edit materi
- `resources/views/tutor/materials/create.blade.php` - Buat materi baru (template sudah ada di controller)

**Fitur:**
- Upload materi (video, dokumen, YouTube, link eksternal)
- Filter dan pencarian materi
- Statistik views dan downloads
- Toggle public/featured status
- Assign materi ke paket/batch tertentu
- Kategorisasi berdasarkan mata pelajaran

### User Views
**Dibuat views baru:**
- `resources/views/views_user/materials/index.blade.php` - Daftar materi untuk user
- `resources/views/views_user/materials/show.blade.php` - Detail dan pemutaran materi

**Fitur:**
- Grid view dengan thumbnail
- Filter berdasarkan tipe, paket, dan mapel
- Pemutaran video YouTube inline
- Preview PDF inline
- Download materi yang diizinkan
- Statistik views
- Access control otomatis

## 5. Policies

### MaterialPolicy (`app/Policies/MaterialPolicy.php`)
**Authorization rules:**
- Tutor dapat view/update/delete materi mereka sendiri
- User dapat view materi publik atau materi dari paket yang dibeli
- Admin dapat force delete materi

### LiveClassPolicy (`app/Policies/LiveClassPolicy.php`)
**Authorization rules:**
- Tutor dapat manage live class mereka sendiri
- User dapat view live class dari paket yang dibeli
- Admin dapat force delete live class

## 6. Routes

### Routes Baru (`routes/web.php`)
**User Material Routes:**
```php
/materials - Daftar materi
/materials/{material} - Detail materi
/materials/{material}/download - Download materi
/materials/package/{packageId} - API get materi berdasarkan paket
```

## 7. Navbar Update

### User Navbar (`resources/views/layouts/user/navbar.blade.php`)
**Penambahan:**
- Link "Materi" di navbar (hanya muncul untuk user yang sudah login)
- Active state untuk highlight menu

## Cara Menggunakan

### 1. Jalankan Migrations

```bash
php artisan migrate
```

### 2. Assign Role Tutor (jika belum ada)

```bash
php artisan tinker
```

```php
// Buat role tutor jika belum ada
$role = Spatie\Permission\Models\Role::firstOrCreate(['name' => 'tutor']);

// Assign role ke user
$user = App\Models\User::find(USER_ID);
$user->assignRole('tutor');
```

### 3. Testing Flow

#### Sebagai Tutor:
1. Login sebagai user dengan role tutor
2. Akses `/tutor/dashboard` untuk melihat dashboard
3. Klik "Buat Live Class" atau "Upload Materi"
4. Isi form dan pilih paket/batch (opsional)
5. Upload file atau masukkan URL YouTube
6. Set visibility (public/private) dan featured status
7. Save materi

#### Sebagai User:
1. Beli paket ujian dari dashboard
2. Tunggu konfirmasi pembayaran (status: "Sudah Bayar")
3. Akses menu "Materi" di navbar
4. Lihat materi yang tersedia (publik + dari paket yang dibeli)
5. Klik materi untuk melihat detail
6. Tonton video atau download file

#### Sebagai Admin:
1. Admin dapat manage paket ujian
2. Admin dapat assign tutor ke paket
3. Admin dapat melihat semua materi

### 4. Integration Checklist

- [x] Model methods dan scopes
- [x] Database migrations
- [x] Controllers untuk tutor dan user
- [x] Views untuk tutor material management
- [x] Views untuk user material access
- [x] Authorization policies
- [x] Routes dan navigation
- [ ] Seeding data contoh (opsional)
- [ ] Testing fungsionalitas end-to-end

## Fitur yang Terintegrasi

### 1. User dapat:
- ✅ Membeli paket kelas
- ✅ Melihat materi dari paket yang dibeli
- ✅ Melihat materi publik
- ✅ Menonton video pembelajaran (YouTube dan upload)
- ✅ Download materi (PDF, dokumen, video)
- ✅ Filter materi berdasarkan tipe, paket, mapel
- ✅ Search materi

### 2. Tutor dapat:
- ✅ Menambahkan materi di kelas yang diampu
- ✅ Upload berbagai jenis materi (video, dokumen, YouTube, link)
- ✅ Assign materi ke paket/batch tertentu
- ✅ Kategorisasi berdasarkan mata pelajaran
- ✅ Set visibility (public/private)
- ✅ Mark materi as featured
- ✅ Lihat statistik views dan downloads
- ✅ Edit dan delete materi mereka sendiri

### 3. Admin dapat:
- ✅ Manage paket ujian
- ✅ Assign tutor ke paket
- ✅ Monitor semua materi
- ✅ Delete materi jika diperlukan

## Troubleshooting

### Issue: Dashboard tutor error "method not found"
**Solution:** Pastikan semua method dalam Model sudah ditambahkan (scopes dan helper methods)

### Issue: User tidak bisa akses materi
**Solution:** 
1. Pastikan user sudah membeli paket
2. Cek status pembelian (harus "Sudah Bayar")
3. Pastikan materi di-assign ke paket yang benar

### Issue: Video YouTube tidak muncul
**Solution:** 
1. Pastikan URL YouTube valid
2. Cek method `extractYoutubeVideoId()` dan `getYoutubeEmbedUrl()`
3. Pastikan format URL: `https://www.youtube.com/watch?v=VIDEO_ID` atau `https://youtu.be/VIDEO_ID`

### Issue: Upload file gagal
**Solution:**
1. Cek `php.ini` untuk `upload_max_filesize` dan `post_max_size`
2. Pastikan direktori `storage/app/public/materials` exists dan writable
3. Jalankan `php artisan storage:link` untuk symbolic link

## Notes

1. **Security:** 
   - Semua akses materi sudah dilindungi dengan policy
   - User hanya bisa akses materi publik atau dari paket yang dibeli
   - File storage menggunakan `storage/app/public` dengan proper access control

2. **Performance:**
   - Views dan downloads di-track untuk analytics
   - Pagination implemented untuk list view
   - Lazy loading untuk relationships

3. **Extensibility:**
   - Mudah menambahkan tipe materi baru
   - Support untuk berbagai format file
   - Flexible categorization dengan tags dan mapel

## Next Steps

1. Testing menyeluruh semua fitur
2. Seeding data contoh untuk demo
3. Implement notifikasi untuk materi baru
4. Analytics dashboard untuk tutor
5. Rating dan review untuk materi
6. Bookmark/favorite functionality
7. Progress tracking per user

## Contact

Jika ada pertanyaan atau issue, silakan hubungi tim development.