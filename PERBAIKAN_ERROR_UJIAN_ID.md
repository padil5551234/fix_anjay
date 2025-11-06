# Perbaikan Error: SQLSTATE[HY000]: General error: 1 no such column: pembelian.ujian_id

## Deskripsi Masalah
Error terjadi pada halaman **Data Ujian** ketika sistem mencoba mengakses kolom `pembelian.ujian_id` yang sudah tidak ada di database.

### Error Message
```
SQLSTATE[HY000]: General error: 1 no such column: pembelian.ujian_id 
(Connection: sqlite, SQL: select exists(select * from "pembelian" where "pembelian"."ujian_id" = c1422891-a51a-43f3-902d-7e43a5b3a6ac and "pembelian"."ujian_id" is not null) as "exists")
```

## Akar Masalah
1. Migration [`2024_01_28_152949_change_ujian_id_to_paket_id_in_pembelian_table.php`](database/migrations/2024_01_28_152949_change_ujian_id_to_paket_id_in_pembelian_table.php) telah mengubah struktur tabel `pembelian`:
   - Kolom `ujian_id` dihapus
   - Diganti dengan `paket_id`

2. Model [`Ujian.php`](app/Models/Ujian.php) masih memiliki relationship lama:
   ```php
   public function pembelian()
   {
       return $this->hasMany(Pembelian::class, 'ujian_id');
   }
   ```

3. Controller [`UjianController.php`](app/Http/Controllers/Admin/UjianController.php) pada method `destroy()` masih menggunakan relationship ini:
   ```php
   $hasPurchases = $ujian->pembelian()->exists();
   ```

## Solusi yang Diterapkan

### 1. Hapus Relationship yang Tidak Valid
**File:** `app/Models/Ujian.php`

Menghapus method `pembelian()` karena relationship ini sudah tidak valid setelah perubahan struktur database.

```php
// DIHAPUS - relationship ini tidak valid lagi
public function pembelian()
{
    return $this->hasMany(Pembelian::class, 'ujian_id');
}
```

### 2. Update Controller
**File:** `app/Http/Controllers/Admin/UjianController.php`

Menghapus pengecekan `$hasPurchases` karena relationship sudah tidak ada:

**Sebelum:**
```php
$hasParticipants = $ujian->ujianUser()->exists();
$hasPurchases = $ujian->pembelian()->exists();

if ($hasParticipants || $hasPurchases) {
    return response()->json([
        'message' => 'Tidak dapat menghapus ujian karena sudah memiliki peserta atau data pembelian.'
    ], 422);
}
```

**Sesudah:**
```php
$hasParticipants = $ujian->ujianUser()->exists();

if ($hasParticipants) {
    return response()->json([
        'message' => 'Tidak dapat menghapus ujian karena sudah memiliki peserta.'
    ], 422);
}
```

## Penjelasan Arsitektur

### Perubahan Struktur Database
Perubahan dari `ujian_id` ke `paket_id` di tabel `pembelian` menunjukkan perubahan konsep:
- **Sebelumnya:** Pembelian langsung terkait dengan Ujian
- **Sekarang:** Pembelian terkait dengan Paket Ujian, di mana satu paket bisa berisi beberapa ujian

### Relationship yang Masih Valid
1. **Ujian → Soal:** `$ujian->soal()` ✅
2. **Ujian → PaketUjian:** `$ujian->paketUjian()` ✅
3. **Ujian → UjianUser:** `$ujian->ujianUser()` ✅
4. **Pembelian → PaketUjian:** `$pembelian->paketUjian()` ✅

### Relationship yang Dihapus
1. **Ujian → Pembelian:** ❌ (sudah tidak valid)

## Testing
Setelah perbaikan ini, halaman **Data Ujian** (`/admin/ujian`) seharusnya:
1. ✅ Dapat diakses tanpa error
2. ✅ Menampilkan daftar ujian dengan benar
3. ✅ Fungsi hapus ujian bekerja dengan validasi peserta
4. ✅ Semua operasi CRUD berjalan normal

## Catatan Penting
- Jika di masa depan perlu mengecek apakah ujian terkait dengan pembelian, harus dilakukan melalui `PaketUjian`:
  ```php
  // Cara yang benar
  $paketIds = $ujian->paketUjian()->pluck('id');
  $hasPurchases = Pembelian::whereIn('paket_id', $paketIds)->exists();
  ```

## Files Modified
1. [`app/Models/Ujian.php`](app/Models/Ujian.php) - Menghapus relationship `pembelian()`
2. [`app/Http/Controllers/Admin/UjianController.php`](app/Http/Controllers/Admin/UjianController.php) - Update method `destroy()`