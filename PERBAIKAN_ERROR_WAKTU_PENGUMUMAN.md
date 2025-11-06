# Perbaikan Error: Column waktu_pengumuman Not Found

## Masalah

Terjadi error SQL saat mencoba menyimpan data ujian:
```
SQLSTATE[HY000]: General error: 1 table ujian has no column named waktu_pengumuman
```

## Penyebab

Model [`Ujian.php`](app/Models/Ujian.php:33) memiliki kolom `waktu_pengumuman` dan [`random_pilihan`](app/Models/Ujian.php:40) dalam array `$fillable`, tetapi kolom-kolom ini tidak ada di tabel database `ujian`.

## Solusi

Dibuat migration baru untuk menambahkan kolom yang hilang ke tabel `ujian`:

### File Migration
[`database/migrations/2025_10_18_001400_add_missing_columns_to_ujian_table.php`](database/migrations/2025_10_18_001400_add_missing_columns_to_ujian_table.php)

### Kolom yang Ditambahkan

1. **waktu_pengumuman** (dateTime, nullable)
   - Kolom untuk menyimpan waktu pengumuman hasil ujian
   - Ditempatkan setelah kolom `waktu_akhir`
   - Dapat bernilai NULL

2. **random_pilihan** (tinyInteger, default: 0)
   - Kolom untuk mengatur apakah pilihan jawaban diacak
   - 0 = Tidak diacak
   - 1 = Diacak
   - Ditempatkan setelah kolom `random`

## Status

✅ **SELESAI** - Migration berhasil dijalankan dan kolom sudah ditambahkan ke database

## Testing

Setelah perbaikan ini, aplikasi seharusnya dapat:
- Menyimpan data ujian tanpa error
- Mengatur waktu pengumuman untuk ujian
- Mengatur opsi random pilihan jawaban

## Perintah yang Dijalankan

```bash
php artisan migrate
```

Output:
```
INFO  Running migrations.  
2025_10_18_001400_add_missing_columns_to_ujian_table ..... 16ms DONE