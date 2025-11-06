# Perbaikan Data Pembelian dan Peserta Ujian

## Masalah yang Ditemukan

### 1. Data Peserta Ujian Menampilkan Data Pembelian
**Lokasi:** [`app/Http/Controllers/Admin/PesertaUjianController.php`](app/Http/Controllers/Admin/PesertaUjianController.php:92)

**Masalah:**
- Method `showData()` memiliki bug kritis dimana variable `$peserta` yang awalnya berisi data dari tabel `ujian_user` di-overwrite dengan data dari tabel `pembelian`
- Hal ini menyebabkan dashboard admin menampilkan data pembelian (purchases) alih-alih data peserta ujian yang sebenarnya
- Data yang ditampilkan menjadi tidak sesuai karena mixing antara model `Pembelian` dan `UjianUser`

**Root Cause:**
```php
// Code lama yang bermasalah
$peserta = UjianUser::with([...])->get(); // Data ujian_user
// ...
foreach ($ujians->paketUjian as $paket) {
    foreach ($paket->pembelian as $pembelian) {
        $pembelian->status = '0';
        $peserta[] = $pembelian; // ❌ Overwriting dengan data pembelian!
    }
}
```

### 2. Pembelian User Tidak Muncul di Admin
**Lokasi:** [`app/Http/Controllers/Admin/PembelianController.php`](app/Http/Controllers/Admin/PembelianController.php:22)

**Masalah:**
- Method `data()` memfilter data berdasarkan `paket_ujian` tanpa mengecek apakah nilainya "all"
- Ketika user memilih "-- Pilih Paket Ujian --" (value="all"), query tetap melakukan `where('paket_id', 'all')` yang tidak akan mengembalikan data apapun
- Ini menyebabkan admin tidak bisa melihat semua pembelian tanpa filter

**Root Cause:**
```php
// Code lama yang bermasalah
$pembelians = Pembelian::with('user')
    ->with('voucher')
    ->where('paket_id', $request->paket_ujian) // ❌ Tidak handle nilai "all"
    ->orderBy('status', 'desc')
    ->orderBy('created_at', 'desc');
```

## Solusi yang Diterapkan

### 1. Perbaikan PesertaUjianController

**File:** [`app/Http/Controllers/Admin/PesertaUjianController.php`](app/Http/Controllers/Admin/PesertaUjianController.php:92-130)

**Perubahan:**
```php
public function showData($id)
{
    ini_set('memory_limit', -1);

    // Get the exam with packages and purchases
    $ujian = Ujian::with(['paketUjian.pembelian' => function($query) {
                $query->where('status', 'Sukses')->orderBy('created_at', 'desc');
            }])
            ->findOrFail($id);
    
    // Collect all users who have purchased the package
    $purchasedUsers = collect();
    foreach ($ujian->paketUjian as $paket) {
        foreach ($paket->pembelian as $pembelian) {
            $purchasedUsers->push($pembelian);
        }
    }
    $purchasedUsers = $purchasedUsers->unique('user_id');

    // Get actual exam participants (UjianUser) who have started the exam
    $peserta = UjianUser::with(['ujian', 'user', 'user.sessions', 'user.usersDetail'])
                ->where('ujian_id', $id)
                ->where('is_first', 1)
                ->orderBy('nilai', 'desc')
                ->get();

    // Merge: add users who purchased but haven't started the exam yet
    foreach ($purchasedUsers as $pembelian) {
        $exists = $peserta->firstWhere('user_id', $pembelian->user_id);
        if (!$exists) {
            // User has purchased but not started exam yet
            $ujianUser = new UjianUser();
            $ujianUser->user_id = $pembelian->user_id;
            $ujianUser->ujian_id = $id;
            $ujianUser->user = $pembelian->user;
            $ujianUser->status = '0'; // Not started
            $ujianUser->ujian = $ujian;
            $peserta->push($ujianUser);
        }
    }
    // ... rest of the method
}
```

**Keuntungan:**
- ✅ Memisahkan dengan jelas antara data `UjianUser` (peserta yang sudah mulai ujian) dan `Pembelian` (user yang beli paket)
- ✅ Menampilkan semua user yang membeli paket, baik yang sudah mengerjakan maupun belum
- ✅ Data ditampilkan dengan benar sesuai dengan model `UjianUser`
- ✅ Tidak ada lagi mixing data antara `Pembelian` dan `UjianUser`

### 2. Perbaikan PembelianController

**File:** [`app/Http/Controllers/Admin/PembelianController.php`](app/Http/Controllers/Admin/PembelianController.php:22-28)

**Perubahan:**
```php
public function data(Request $request)
{
    $pembelians = Pembelian::with('user')
                    ->with('voucher')
                    ->when($request->paket_ujian && $request->paket_ujian != 'all', function($query) use ($request) {
                        return $query->where('paket_id', $request->paket_ujian);
                    })
                    ->orderBy('status', 'desc')
                    ->orderBy('created_at', 'desc');
    // ... rest of the method
}
```

**Keuntungan:**
- ✅ Filter hanya diterapkan jika `paket_ujian` ada dan bukan "all"
- ✅ Ketika memilih "-- Pilih Paket Ujian --", semua data pembelian akan ditampilkan
- ✅ Admin bisa melihat overview semua pembelian atau filter berdasarkan paket tertentu

## Cara Testing

### Test Data Pembelian

1. Login sebagai admin
2. Navigasi ke menu **Pembelian Paket**
3. Pada dropdown "-- Pilih Paket Ujian --":
   - Pilih "-- Pilih Paket Ujian --" (value="all") → **Semua pembelian harus muncul**
   - Pilih paket tertentu → **Hanya pembelian paket tersebut yang muncul**
4. Verifikasi data yang ditampilkan:
   - Email pembeli
   - Nama pembeli
   - Tanggal pembelian
   - Metode pembayaran
   - Voucher (jika ada)
   - Total harga
   - Status pembayaran

### Test Data Peserta Ujian

1. Login sebagai admin
2. Navigasi ke menu **Peserta Ujian**
3. Pilih ujian tertentu
4. Verifikasi data yang ditampilkan menunjukkan peserta ujian yang benar:
   - Nama peserta
   - Email peserta
   - Kelompok (jika ada)
   - Waktu pengerjaan
   - Status pengerjaan (Belum Mengerjakan/Sedang Mengerjakan/Selesai)
   - Nilai (jika sudah selesai)
5. Pastikan data yang muncul adalah:
   - ✅ User yang sudah mulai mengerjakan ujian
   - ✅ User yang sudah membeli paket tapi belum mulai ujian
   - ❌ BUKAN data dari tabel pembelian

## File yang Dimodifikasi

1. [`app/Http/Controllers/Admin/PesertaUjianController.php`](app/Http/Controllers/Admin/PesertaUjianController.php) - Method `showData()`
2. [`app/Http/Controllers/Admin/PembelianController.php`](app/Http/Controllers/Admin/PembelianController.php) - Method `data()`

## Kesimpulan

Kedua bug ini telah diperbaiki dengan:
1. **Memisahkan logika** antara data peserta ujian (`UjianUser`) dan data pembelian (`Pembelian`)
2. **Menambahkan conditional filter** pada query pembelian untuk menangani nilai "all"
3. **Mempertahankan struktur data yang benar** sesuai dengan model yang digunakan

Perbaikan ini memastikan:
- ✅ Admin dapat melihat semua pembelian user dengan atau tanpa filter
- ✅ Data peserta ujian ditampilkan dengan benar dan tidak tercampur dengan data pembelian
- ✅ Dashboard admin menampilkan informasi yang akurat dan relevan

## Tanggal Perbaikan

5 November 2025 (UTC+7)