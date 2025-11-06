# Perbaikan Fitur Hapus Ujian

## Masalah
Data ujian tidak dapat dihapus dan menampilkan pesan error "Tidak dapat menghapus data" tanpa informasi yang jelas tentang penyebabnya.

## Penyebab
1. **Ujian sudah dipublish** - Sistem mencegah penghapusan ujian yang sudah dipublish untuk menjaga integritas data
2. **Ujian memiliki peserta/pembelian** - Ujian yang sudah memiliki peserta atau data pembelian tidak dapat dihapus
3. **Error handling kurang informatif** - Pesan error tidak menjelaskan alasan spesifik mengapa ujian tidak dapat dihapus

## Solusi yang Diterapkan

### 1. Perbaikan Controller (`app/Http/Controllers/Admin/UjianController.php`)

#### Method `destroy()` - Line 220
Ditambahkan validasi dan error handling yang lebih baik:

```php
public function destroy($id)
{
    if (!auth()->user()->hasRole('admin')) {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    try {
        $ujian = Ujian::findOrFail($id);
        
        // Check if ujian is published
        if ($ujian->isPublished) {
            return response()->json([
                'message' => 'Tidak dapat menghapus ujian yang sudah dipublish. Silakan unpublish terlebih dahulu.'
            ], 422);
        }
        
        // Check if ujian has related data
        $hasParticipants = $ujian->ujianUser()->exists();
        $hasPurchases = $ujian->pembelian()->exists();
        
        if ($hasParticipants || $hasPurchases) {
            return response()->json([
                'message' => 'Tidak dapat menghapus ujian karena sudah memiliki peserta atau data pembelian. Ujian hanya dapat dihapus jika belum ada peserta yang mendaftar.'
            ], 422);
        }
        
        // Delete related data first (cascade should handle this, but being explicit)
        $ujian->soal()->delete();
        $ujian->delete();

        return response()->json(['message' => 'Data berhasil dihapus'], 200);
    } catch (\Exception $e) {
        \Log::error('Error deleting ujian: ' . $e->getMessage());
        return response()->json([
            'message' => 'Tidak dapat menghapus data. Error: ' . $e->getMessage()
        ], 500);
    }
}
```

**Validasi yang ditambahkan:**
- ✅ Cek apakah ujian sudah dipublish
- ✅ Cek apakah ujian memiliki peserta (ujian_user)
- ✅ Cek apakah ujian memiliki data pembelian
- ✅ Error handling dengan pesan yang informatif

#### Method `data()` - Line 63
Ditambahkan tombol publish/unpublish di kolom aksi:

```php
// Add publish/unpublish button
if (auth()->user()->hasRole('admin')) {
    if ($ujians->isPublished) {
        $text .= '<button onclick="togglePublish(`' . route('admin.ujian.publish', $ujians->id) . '`, false)" type="button" class="btn btn-outline-secondary m-1" title="Unpublish"><i class="fa fa-eye-slash"></i></button>';
    } else {
        $text .= '<button onclick="togglePublish(`' . route('admin.ujian.publish', $ujians->id) . '`, true)" type="button" class="btn btn-outline-primary m-1" title="Publish"><i class="fa fa-eye"></i></button>';
    }
}
```

### 2. Perbaikan View (`resources/views/admin/ujian/index.blade.php`)

#### Fungsi `deleteData()` - Line 268
Diperbaiki error handling untuk menampilkan pesan error yang lebih informatif:

```javascript
function deleteData(url) {
    Swal.fire({
        title: 'Apakah kamu yakin akan menghapus data?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post(url, {
                '_token': $('[name=csrf-token]').attr('content'),
                '_method': 'delete'
            })
            .done((response) => {
                tableUjian.ajax.reload();
                toastr.success(response.message || 'Data berhasil dihapus.');
                toastr.options = {"positionClass": "toast-bottom-right"};
            })
            .fail((errors) => {
                console.log('Error:', errors);
                let errorMessage = 'Tidak dapat menghapus data.';
                
                if (errors.status === 422 && errors.responseJSON && errors.responseJSON.message) {
                    errorMessage = errors.responseJSON.message;
                } else if (errors.status === 403) {
                    errorMessage = 'Anda tidak memiliki izin untuk menghapus data ini.';
                } else if (errors.responseJSON && errors.responseJSON.message) {
                    errorMessage = errors.responseJSON.message;
                }
                
                toastr.error(errorMessage);
                toastr.options = {
                    "positionClass": "toast-bottom-right",
                    "timeOut": "10000",
                    "extendedTimeOut": "5000"
                };
                return;
            })
        }
    })
}
```

#### Fungsi `togglePublish()` - Line 323 (Baru)
Ditambahkan fungsi baru untuk publish/unpublish ujian:

```javascript
function togglePublish(url, isPublishing) {
    const action = isPublishing ? 'publish' : 'unpublish';
    const actionText = isPublishing ? 'mempublish' : 'unpublish';
    
    Swal.fire({
        title: `Apakah kamu yakin akan ${actionText} ujian?`,
        text: isPublishing ? 'Ujian yang dipublish akan dapat diakses oleh peserta.' : 'Ujian yang di-unpublish tidak dapat diakses oleh peserta.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    tableUjian.ajax.reload();
                    toastr.success(response || `Ujian berhasil di-${actionText}.`);
                    toastr.options = {"positionClass": "toast-bottom-right"};
                },
                error: function(errors) {
                    console.log('Error:', errors);
                    let errorMessage = `Tidak dapat ${actionText} ujian.`;
                    
                    if (errors.responseJSON && errors.responseJSON.message) {
                        errorMessage = errors.responseJSON.message;
                    } else if (errors.status === 300) {
                        errorMessage = 'Tidak dapat mempublish ujian. Pastikan jumlah soal sudah sesuai.';
                    }
                    
                    toastr.error(errorMessage);
                    toastr.options = {
                        "positionClass": "toast-bottom-right",
                        "timeOut": "10000",
                        "extendedTimeOut": "5000"
                    };
                }
            });
        }
    });
}
```

## Fitur Baru

### Tombol Publish/Unpublish
- **Tombol Publish** (ikon mata) - Untuk mempublish ujian yang belum dipublish
- **Tombol Unpublish** (ikon mata dicoret) - Untuk unpublish ujian yang sudah dipublish
- Tombol ini memungkinkan admin untuk unpublish ujian sebelum menghapusnya

### Icon Tombol di Kolom Aksi
- ✏️ **Edit** - Edit ujian (hanya jika belum dipublish)
- 🗑️ **Delete** - Hapus ujian (hanya jika belum dipublish)
- 👁️ **Publish** - Publish ujian (toggle)
- 👁️‍🗨️ **Unpublish** - Unpublish ujian (toggle)
- 📋 **List** - Lihat daftar soal
- 📑 **Copy** - Duplikat ujian

## Kondisi Penghapusan Ujian

Ujian **HANYA DAPAT DIHAPUS** jika memenuhi semua kondisi berikut:
1. ✅ **Belum dipublish** (`isPublished = 0`)
2. ✅ **Belum memiliki peserta** (tidak ada data di tabel `ujian_user`)
3. ✅ **Belum memiliki pembelian** (tidak ada data di tabel `pembelian`)
4. ✅ **User memiliki role admin**

## Pesan Error yang Ditampilkan

### Error: Ujian Sudah Dipublish
```
Tidak dapat menghapus ujian yang sudah dipublish. Silakan unpublish terlebih dahulu.
```
**Solusi:** Klik tombol unpublish (ikon mata dicoret) terlebih dahulu, kemudian hapus ujian.

### Error: Ujian Memiliki Peserta/Pembelian
```
Tidak dapat menghapus ujian karena sudah memiliki peserta atau data pembelian. Ujian hanya dapat dihapus jika belum ada peserta yang mendaftar.
```
**Solusi:** Ujian tidak dapat dihapus karena sudah ada data peserta yang terkait. Pertimbangkan untuk meng-archive atau menonaktifkan ujian daripada menghapusnya.

### Error: Unauthorized
```
Anda tidak memiliki izin untuk menghapus data ini.
```
**Solusi:** Pastikan Anda login sebagai admin.

## Cara Menghapus Ujian

1. **Pastikan ujian belum dipublish**
   - Jika sudah dipublish, klik tombol unpublish (👁️‍🗨️) terlebih dahulu

2. **Pastikan ujian belum memiliki peserta**
   - Cek apakah ada peserta yang sudah mendaftar ujian tersebut
   - Jika ada peserta, ujian tidak dapat dihapus

3. **Klik tombol delete** (🗑️)
   - Konfirmasi penghapusan
   - Sistem akan menghapus ujian beserta semua soal yang terkait

## Database Relations

Berikut adalah relasi database yang berpengaruh pada penghapusan ujian:

```
ujian (CASCADE)
├── soal (CASCADE)
│   └── jawaban (CASCADE)
├── paket_ujian_ujian (CASCADE)
├── ujian_user (CASCADE) ← BLOCKING if exists
└── pembelian (CASCADE) ← BLOCKING if exists
```

- **CASCADE**: Data akan otomatis terhapus saat ujian dihapus
- **BLOCKING**: Mencegah penghapusan ujian jika data masih ada

## Testing

### Test Case 1: Hapus Ujian yang Belum Dipublish dan Belum Ada Peserta
✅ **Expected:** Ujian berhasil dihapus
✅ **Result:** "Data berhasil dihapus"

### Test Case 2: Hapus Ujian yang Sudah Dipublish
❌ **Expected:** Ujian tidak dapat dihapus
✅ **Result:** "Tidak dapat menghapus ujian yang sudah dipublish. Silakan unpublish terlebih dahulu."

### Test Case 3: Hapus Ujian yang Memiliki Peserta
❌ **Expected:** Ujian tidak dapat dihapus
✅ **Result:** "Tidak dapat menghapus ujian karena sudah memiliki peserta atau data pembelian."

### Test Case 4: Unpublish lalu Hapus Ujian
1. Klik tombol unpublish
2. Klik tombol delete
✅ **Expected:** Ujian berhasil dihapus (jika tidak ada peserta)

## Files Modified

1. `app/Http/Controllers/Admin/UjianController.php`
   - Method `destroy()` - Ditambahkan validasi dan error handling
   - Method `data()` - Ditambahkan tombol publish/unpublish

2. `resources/views/admin/ujian/index.blade.php`
   - Fungsi `deleteData()` - Diperbaiki error handling
   - Fungsi `togglePublish()` - Fungsi baru untuk publish/unpublish

## Rekomendasi

1. **Backup Database** sebelum menghapus ujian yang memiliki banyak soal
2. **Gunakan Duplicate** jika ingin membuat ujian serupa
3. **Pertimbangkan Archive** daripada menghapus ujian yang sudah memiliki peserta
4. **Unpublish dahulu** sebelum menghapus ujian yang sudah dipublish

## Catatan Penting

⚠️ **PERINGATAN:**
- Penghapusan ujian akan menghapus semua soal dan jawaban yang terkait
- Penghapusan ujian yang memiliki peserta atau pembelian **TIDAK DIIZINKAN** untuk menjaga integritas data
- Pastikan backup database sebelum melakukan penghapusan data penting

---

Tanggal: 18 Oktober 2025
Dibuat oleh: Kilo Code
Status: ✅ Completed