# Panduan Auto Verifikasi Email Setelah Pembelian

## Ringkasan

Sistem telah diupdate untuk **otomatis memverifikasi email user** setelah melakukan pembelian yang sukses. Fitur ini memastikan user dapat langsung mengakses seluruh konten tanpa perlu verifikasi email manual.

## Fitur Utama

### Verifikasi Otomatis Berlaku Untuk:
- ✅ Pembayaran via Midtrans (QRIS, Transfer Bank, E-wallet, Credit Card)
- ✅ Transfer Manual (setelah admin approve)
- ✅ Paket Gratis (langsung saat pembelian)
- ✅ Pembayaran Manual oleh Admin

### Keuntungan:
- User tidak perlu klik link verifikasi email
- Akses langsung ke tryout, materi, dan live zoom
- Mengurangi kompleksitas untuk user
- Meningkatkan conversion rate

## Cara Kerja

```
USER BELI PAKET
    ↓
CEK JENIS PEMBAYARAN
    ↓
┌─────────────────┬─────────────────┬──────────────────┐
│  PAKET GRATIS   │    MIDTRANS     │  TRANSFER MANUAL │
│  Auto Verify    │  Callback       │  Admin Approve   │
│  Langsung       │  Auto Verify    │  Auto Verify     │
└─────────────────┴─────────────────┴──────────────────┘
    ↓
EMAIL TERVERIFIKASI OTOMATIS
```

## Implementasi

### 1. Model User

File: [`app/Models/User.php`](app/Models/User.php:150-177)

```php
/**
 * Mark email as verified
 */
public function markEmailAsVerified()
{
    return $this->forceFill([
        'email_verified_at' => $this->freshTimestamp(),
    ])->save();
}

/**
 * Check if user email is verified
 */
public function hasVerifiedEmail()
{
    return ! is_null($this->email_verified_at);
}
```

### 2. Callback Midtrans

File: [`app/Http/Controllers/PembelianController.php`](app/Http/Controllers/PembelianController.php:346-363)

```php
if ($request->transaction_status == 'capture' || 
    $request->transaction_status == 'settlement') {
    
    $pembelian = Pembelian::find($order_id);
    $pembelian->status = 'Sukses';
    $pembelian->update();
    
    // Auto-verify user email
    $user = \App\Models\User::find($pembelian->user_id);
    if ($user && !$user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
    }
}
```

### 3. Verifikasi Manual Admin

File: [`app/Http/Controllers/Admin/PembelianController.php`](app/Http/Controllers/Admin/PembelianController.php:324-339)

```php
if ($request->action === 'approve') {
    $pembelian->status = 'Sukses';
    $pembelian->save();

    // Auto-verify user email
    $user = $pembelian->user;
    if ($user && !$user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
    }
}
```

### 4. Paket Gratis

File: [`app/Http/Controllers/PembelianController.php`](app/Http/Controllers/PembelianController.php:51-68)

```php
$pembelian = new Pembelian();
$pembelian->status = $paketUjian->harga == 0 ? 'Sukses' : 'Belum dibayar';
$pembelian->save();

// Auto-verify for free packages
if ($paketUjian->harga == 0) {
    $user = auth()->user();
    if ($user && !$user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
    }
}
```

### 5. Pembelian Manual Admin

File: [`app/Http/Controllers/Admin/PembelianController.php`](app/Http/Controllers/Admin/PembelianController.php:151-172)

```php
$pembelian = new Pembelian();
$pembelian->status = 'Sukses';
$pembelian->save();

// Auto-verify user email
$user = User::find($request->user);
if ($user && !$user->hasVerifiedEmail()) {
    $user->markEmailAsVerified();
}
```

## Testing

### Test Paket Gratis
1. Login sebagai user baru (email belum terverifikasi)
2. Pilih paket gratis dan klik "Beli Paket"
3. Cek database: `email_verified_at` harus terisi
4. User dapat langsung akses tryout

### Test Midtrans
1. Login sebagai user baru
2. Pilih paket berbayar
3. Bayar via Midtrans sandbox
4. Tunggu callback dari Midtrans
5. Cek database: `email_verified_at` harus terisi

### Test Transfer Manual
1. User upload bukti transfer
2. Admin approve pembayaran di halaman verifikasi
3. Cek database: `email_verified_at` harus terisi
4. User dapat langsung akses konten

### Test Manual Admin
1. Admin buat pembelian untuk user
2. Status langsung `Sukses`
3. Cek database: `email_verified_at` harus terisi

## SQL Query Monitoring

```sql
-- Cek user yang sudah terverifikasi setelah pembelian
SELECT 
    u.id,
    u.name,
    u.email,
    u.email_verified_at,
    p.status,
    p.jenis_pembayaran,
    p.created_at as tanggal_beli
FROM users u
INNER JOIN pembelian p ON p.user_id = u.id
WHERE p.status = 'Sukses'
ORDER BY p.created_at DESC;

-- Cek user yang belum terverifikasi tapi sudah beli (seharusnya kosong)
SELECT 
    u.id,
    u.name,
    u.email,
    u.email_verified_at,
    p.status
FROM users u
INNER JOIN pembelian p ON p.user_id = u.id
WHERE p.status = 'Sukses'
  AND u.email_verified_at IS NULL;
```

## Troubleshooting

### Email tidak terverifikasi setelah pembayaran Midtrans

```bash
# Cek log Laravel
tail -f storage/logs/laravel.log

# Manual verify via tinker
php artisan tinker
$user = User::find(USER_ID);
$user->markEmailAsVerified();
```

### Email tidak terverifikasi untuk paket gratis

```bash
# Cek kondisi harga di PembelianController
# Line 58-66

# Manual verify
php artisan tinker
$user = User::find(USER_ID);
$user->markEmailAsVerified();
```

### Email tidak terverifikasi saat admin approve

```bash
# Cek relasi user di Admin/PembelianController
# Pastikan menggunakan: $user = $pembelian->user;
```

## File yang Dimodifikasi

1. **[`app/Models/User.php`](app/Models/User.php)**
   - Method `markEmailAsVerified()`
   - Method `hasVerifiedEmail()`

2. **[`app/Http/Controllers/PembelianController.php`](app/Http/Controllers/PembelianController.php)**
   - Auto-verify di `callback()` (Midtrans)
   - Auto-verify di `beliPaket()` (Paket gratis)

3. **[`app/Http/Controllers/Admin/PembelianController.php`](app/Http/Controllers/Admin/PembelianController.php)**
   - Auto-verify di `prosesVerifikasi()` (Approve manual)
   - Auto-verify di `store()` (Tambah peserta manual)

## Keamanan

### Validasi User
```php
// Selalu cek user exists sebelum verify
if ($user && !$user->hasVerifiedEmail()) {
    $user->markEmailAsVerified();
}
```

### Prevent Double Verification
```php
// Method hasVerifiedEmail() mencegah verify ulang
if (!$user->hasVerifiedEmail()) {
    $user->markEmailAsVerified();
}
```

## Best Practices

### Selalu Cek Existing Verification
```php
// GOOD ✅
if ($user && !$user->hasVerifiedEmail()) {
    $user->markEmailAsVerified();
}

// BAD ❌
$user->markEmailAsVerified(); // Tidak cek existing
```

### Gunakan Method Helper
```php
// GOOD ✅
$user->markEmailAsVerified();

// BAD ❌
$user->email_verified_at = now();
$user->save();
```

## FAQ

**Q: Apakah user yang sudah terverifikasi akan di-verify ulang?**
A: Tidak, method `hasVerifiedEmail()` mencegah verifikasi ulang.

**Q: Bagaimana jika user membeli paket kedua?**
A: Sistem akan cek dulu, jika sudah terverifikasi tidak akan di-verify ulang.

**Q: Apakah berlaku untuk semua role?**
A: Ya, berlaku untuk semua user yang melakukan pembelian.

**Q: Bagaimana dengan user lama yang belum terverifikasi?**
A: Mereka akan otomatis terverifikasi saat melakukan pembelian berikutnya.

## Catatan Penting

⚠️ **PENTING:**
1. Fitur ini membypass verifikasi email standar Laravel
2. Pastikan validasi pembayaran sudah benar
3. Backup database sebelum deploy
4. Monitor log untuk mendeteksi masalah

## Changelog

### Version 1.0.0 (2025-11-06)
- ✅ Auto-verify untuk Midtrans callback
- ✅ Auto-verify untuk pembayaran manual
- ✅ Auto-verify untuk paket gratis
- ✅ Auto-verify untuk pembelian manual admin
- ✅ Method helper di User model
- ✅ Dokumentasi lengkap

---

**Dokumentasi dibuat:** 6 November 2025  
**Versi:** 1.0.0