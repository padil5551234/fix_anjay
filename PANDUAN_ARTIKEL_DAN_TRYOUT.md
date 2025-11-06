# Panduan Lengkap: Artikel dan Tryout

## Daftar Isi
1. [Menambahkan Artikel di Admin](#1-menambahkan-artikel-di-admin)
2. [Menambahkan Soal Tryout di Admin](#2-menambahkan-soal-tryout-di-admin)
3. [User Mengerjakan Soal Tryout](#3-user-mengerjakan-soal-tryout)

---

## 1. Menambahkan Artikel di Admin

### Akses Halaman Artikel Admin
1. Login sebagai **Admin** di: `http://127.0.0.1:8000/login`
2. Setelah login, klik menu **Artikel** di sidebar admin
3. Atau akses langsung: `http://127.0.0.1:8000/admin/article`

### Membuat Artikel Baru
1. **Klik tombol "Tambah Artikel"** atau akses: `http://127.0.0.1:8000/admin/article/create`

2. **Isi form artikel:**
   - **Title (Judul)**: Masukkan judul artikel (contoh: "Tips Lolos SPMB STIS 2024")
   - **Excerpt (Ringkasan)**: Ringkasan singkat artikel (opsional, auto-generate dari konten jika kosong)
   - **Content (Konten)**: Isi lengkap artikel (support HTML formatting)
   - **Featured Image**: Upload gambar utama artikel (opsional, max 2MB)
   - **Category (Kategori)**: Pilih salah satu:
     - Tips
     - Strategi Belajar
     - Pengumuman
     - Motivasi
     - Umum
   - **Status**: Pilih:
     - `draft` - Artikel belum dipublikasikan
     - `published` - Artikel akan langsung dipublikasikan
   - **Is Featured**: Centang jika artikel ini ingin ditampilkan sebagai artikel unggulan
   - **Tags**: Masukkan tag dipisahkan koma (contoh: stis, matematika, tips)
   - **Meta Description**: Deskripsi untuk SEO (opsional)

3. **Klik tombol "Simpan"**

### Mengedit Artikel
1. Di halaman daftar artikel, klik tombol **Edit** (icon pensil) pada artikel yang ingin diedit
2. Ubah data yang diperlukan
3. Klik **Update**

### Menghapus Artikel
1. Di halaman daftar artikel, klik tombol **Delete** (icon tempat sampah)
2. Konfirmasi penghapusan

### Artikel Muncul di Dashboard User
Setelah artikel dibuat dengan status **published**, artikel akan:
- **Muncul di dashboard utama** (3 artikel terbaru di bagian "Artikel & Tips Belajar")
- **Tersedia di halaman Artikel** (`/articles`) - bisa diakses melalui menu navigasi
- **Dapat dicari dan difilter** berdasarkan kategori

---

## 2. Menambahkan Soal Tryout di Admin

### Struktur Sistem Tryout
Sistem tryout memiliki hirarki:
```
Paket Ujian → Ujian → Soal
```

### A. Membuat/Menggunakan Paket Ujian

#### Akses Paket Ujian
1. Login sebagai **Admin**
2. Klik menu **Paket Ujian** di sidebar
3. Atau akses: `http://127.0.0.1:8000/admin/paket`

#### Membuat Paket Ujian Baru
1. Klik **Tambah Paket Ujian**
2. Isi form:
   - **Nama Paket**: Contoh "Paket SPMB STIS 2024"
   - **Harga**: Masukkan harga (Rp)
   - **Deskripsi**: Deskripsi paket (support HTML)
   - **Waktu Mulai**: Kapan paket mulai dijual
   - **Waktu Akhir**: Kapan paket berhenti dijual
   - **WhatsApp Group Link**: Link grup WA untuk peserta (opsional)
3. Klik **Simpan**

### B. Membuat Ujian dalam Paket

#### Akses Menu Ujian
1. Klik menu **Ujian** di sidebar admin
2. Atau akses: `http://127.0.0.1:8000/admin/ujian`

#### Membuat Ujian Baru
1. Klik **Tambah Ujian**
2. Isi form:
   - **Nama Ujian**: Contoh "TPA - Tryout 1"
   - **Paket Ujian**: Pilih paket ujian yang sudah dibuat
   - **Jenis Tryout**: Pilih SKD, Matematika, atau TPA
   - **Lama Pengerjaan**: Dalam menit (contoh: 90)
   - **Jumlah Soal**: Total soal dalam ujian
   - **Waktu Mulai**: Kapan ujian bisa dikerjakan
   - **Waktu Akhir**: Deadline mengerjakan ujian
   - **Passing Grade**: Nilai minimum kelulusan (opsional)
   - **Instruksi**: Petunjuk pengerjaan untuk peserta
   - **Is Published**: Centang untuk mempublikasikan ujian
3. Klik **Simpan**

### C. Menambahkan Soal ke Ujian

#### Metode 1: Tambah Soal Manual (Satu per Satu)

1. **Akses halaman soal ujian:**
   - Dari daftar ujian, klik tombol **Soal** pada ujian yang ingin ditambahkan soal
   - Atau akses: `http://127.0.0.1:8000/admin/ujian/{ujian_id}/soal`

2. **Klik "Tambah Soal"**

3. **Isi form soal:**
   - **Jenis Soal**: Pilih:
     - `Pilihan Ganda` - Soal dengan 5 pilihan (A-E)
     - `Pilihan Ganda Kompleks` - Soal dengan jawaban benar lebih dari 1
   - **Pertanyaan**: Isi soal (support HTML, bisa insert gambar)
   - **Pilihan Jawaban A-E**: Isi setiap pilihan jawaban
   - **Kunci Jawaban**: 
     - Untuk Pilihan Ganda: Pilih A, B, C, D, atau E
     - Untuk PG Kompleks: Centang semua pilihan yang benar
   - **Pembahasan**: Penjelasan jawaban (akan ditampilkan setelah ujian)
   - **Point/Bobot Soal**: Nilai untuk jawaban benar
   - **Point Salah**: Nilai pengurangan untuk jawaban salah (bisa 0 atau negatif)
   - **Point Kosong**: Nilai jika tidak dijawab (biasanya 0)

4. **Klik "Simpan"**

#### Metode 2: Bulk Import (Import Banyak Soal Sekaligus)

1. **Akses bulk import:**
   - Dari halaman soal ujian, klik **"Bulk Import"**
   - Atau akses: `http://127.0.0.1:8000/admin/ujian/{ujian_id}/soal/bulk-import`

2. **Format Excel yang diperlukan:**
   
   Buat file Excel dengan kolom berikut:
   
   | no | jenis_soal | pertanyaan | pilihan_a | pilihan_b | pilihan_c | pilihan_d | pilihan_e | kunci_jawaban | pembahasan | point | nilai_salah | poin_kosong |
   |---|---|---|---|---|---|---|---|---|---|---|---|---|
   | 1 | Pilihan Ganda | Berapakah 2+2? | 2 | 3 | 4 | 5 | 6 | C | 2+2 = 4 | 5 | -1 | 0 |
   | 2 | Pilihan Ganda | Ibu kota Indonesia? | Jakarta | Bandung | Surabaya | Medan | Bali | A | Jakarta adalah ibu kota | 5 | -1 | 0 |

   **Keterangan Kolom:**
   - `no`: Nomor urut soal
   - `jenis_soal`: "Pilihan Ganda" atau "Pilihan Ganda Kompleks"
   - `pertanyaan`: Teks soal
   - `pilihan_a` sampai `pilihan_e`: Pilihan jawaban
   - `kunci_jawaban`: Huruf jawaban yang benar (A/B/C/D/E)
     - Untuk PG Kompleks gunakan format: "A,C" (jika A dan C benar)
   - `pembahasan`: Penjelasan jawaban
   - `point`: Nilai jika benar (angka positif)
   - `nilai_salah`: Nilai jika salah (angka negatif atau 0)
   - `poin_kosong`: Nilai jika tidak dijawab (biasanya 0)

3. **Upload file:**
   - Klik **"Choose File"**
   - Pilih file Excel (.xlsx atau .xls)
   - Klik **"Import"**

4. **Sistem akan:**
   - Validasi format
   - Import semua soal sekaligus
   - Menampilkan hasil import (berapa soal berhasil/gagal)

#### Tips untuk Gambar dalam Soal

Untuk menambahkan gambar dalam soal:
1. Upload gambar terlebih dahulu melalui **CKEditor** atau **TinyMCE** jika tersedia
2. Atau gunakan URL gambar eksternal
3. Format HTML: `<img src="URL_GAMBAR" alt="description">`

### D. Preview dan Publish Ujian

1. **Preview ujian:**
   - Klik tombol **Preview** pada daftar ujian
   - Periksa semua soal dan jawaban

2. **Publish ujian:**
   - Pastikan checkbox **"Is Published"** sudah dicentang saat membuat/edit ujian
   - Ujian hanya bisa diakses user jika sudah published

---

## 3. User Mengerjakan Soal Tryout

### A. Membeli Paket Tryout

1. **User login/register** di: `http://127.0.0.1:8000/register`

2. **Lengkapi profil** (jika diminta)

3. **Pilih paket di dashboard:**
   - Scroll ke bagian **"Pilihan Paket Kedinasan"**
   - Klik **"Beli Paket"** pada paket yang diinginkan

4. **Proses pembayaran:**
   - Pilih metode pembayaran (jika ada Midtrans)
   - Atau admin manual approve pembayaran
   - Tunggu hingga status pembayaran **"Sukses"**

### B. Mengakses Tryout

1. **Setelah pembayaran sukses:**
   - Dashboard akan menampilkan tombol **"Lihat Paket"**
   - Atau akses menu **Tryout** di navigasi

2. **Pilih ujian yang ingin dikerjakan:**
   - Klik pada ujian yang tersedia
   - Periksa informasi ujian (waktu, jumlah soal, dll)

### C. Mengerjakan Ujian

1. **Mulai ujian:**
   - Klik tombol **"Mulai Ujian"**
   - Timer akan otomatis berjalan

2. **Saat mengerjakan:**
   - **Navigasi soal**: Klik nomor soal untuk pindah ke soal lain
   - **Pilih jawaban**: Klik pilihan A, B, C, D, atau E
   - **Ragu-ragu**: Centang checkbox "Ragu-ragu" untuk menandai soal
   - **Auto-save**: Jawaban otomatis tersimpan setiap kali dipilih

3. **Soal yang ragu-ragu:**
   - Ditandai dengan warna berbeda pada nomor soal
   - Bisa dikerjakan ulang sebelum waktu habis

4. **Menyelesaikan ujian:**
   - Klik tombol **"Selesai Ujian"**
   - Atau ujian otomatis selesai saat waktu habis
   - Konfirmasi penyelesaian ujian

### D. Melihat Hasil

1. **Setelah ujian selesai:**
   - Sistem akan menghitung nilai otomatis
   - Tampil halaman **Nilai** dengan:
     - Total nilai
     - Jumlah benar/salah/kosong
     - Grafik nilai (jika ada)

2. **Melihat pembahasan:**
   - Klik tombol **"Lihat Pembahasan"**
   - Review semua soal dengan:
     - Jawaban user
     - Jawaban yang benar
     - Penjelasan/pembahasan
     - Warna indikator (hijau=benar, merah=salah, abu=tidak dijawab)

3. **Mengulang ujian:**
   - Jika sistem mengizinkan
   - Klik **"Kerjakan Lagi"** (jika tersedia)

---

## Fitur-Fitur Penting

### Untuk Admin:

1. **Data Tables Artikel & Ujian:**
   - Sorting dan filtering
   - Search
   - Pagination

2. **Manage soal dengan mudah:**
   - Edit soal individual
   - Hapus soal
   - Duplicate ujian

3. **Monitoring peserta:**
   - Lihat siapa saja yang mengerjakan
   - Lihat nilai peserta
   - Export data nilai

### Untuk User:

1. **Artikel tersedia di:**
   - Dashboard utama (3 artikel terbaru)
   - Halaman khusus artikel (`/articles`)
   - Filter berdasarkan kategori
   - Search artikel

2. **Tryout features:**
   - Timer countdown
   - Auto-save jawaban
   - Navigasi mudah antar soal
   - Penanda soal ragu-ragu
   - Pembahasan lengkap setelah ujian

---

## Troubleshooting

### Artikel tidak muncul di dashboard?
- Pastikan artikel berstatus **"published"**
- Pastikan `published_at` sudah diset (otomatis saat publish)
- Clear browser cache

### User tidak bisa akses tryout?
- Pastikan user sudah membeli paket
- Pastikan status pembayaran **"Sukses"**
- Pastikan ujian sudah **"isPublished = true"**
- Cek waktu mulai dan akhir ujian

### Soal tidak tersimpan saat bulk import?
- Periksa format Excel sesuai template
- Pastikan tidak ada kolom yang kosong (kecuali opsional)
- Cek format kunci_jawaban (huruf kapital A-E)

### Timer tidak berjalan?
- Clear browser cache
- Pastikan JavaScript enabled
- Coba refresh halaman

---

## Contoh Data Sample

### Sample Artikel:
```
Title: Tips & Trik Lolos SPMB STIS 2024
Excerpt: Pelajari strategi jitu untuk menghadapi seleksi masuk Polstat STIS
Category: Tips
Status: published
Is Featured: Yes
Tags: stis, tips, strategi, 2024
```

### Sample Ujian:
```
Nama: TPA - Tryout 1
Paket: Paket Premium STIS 2024
Jenis: TPA
Lama Pengerjaan: 90 menit
Jumlah Soal: 100
Is Published: Yes
```

### Sample Soal:
```
Jenis: Pilihan Ganda
Pertanyaan: Jika 2x + 3 = 11, maka nilai x adalah?
A: 2
B: 3
C: 4
D: 5
E: 6
Kunci: C
Pembahasan: 2x + 3 = 11, maka 2x = 8, sehingga x = 4
Point: 5
Nilai Salah: -1
Poin Kosong: 0
```

---

## Kesimpulan

Sistem sekarang sudah mendukung:
✅ **Artikel** di admin dapat dibuat dan langsung muncul di dashboard user
✅ **Soal tryout** dapat ditambahkan manual atau bulk import
✅ **User dapat mengerjakan** tryout dengan fitur lengkap (timer, auto-save, ragu-ragu)
✅ **Pembahasan** tersedia setelah ujian selesai
✅ **Sistem penilaian** otomatis dengan bobot soal custom

Untuk pertanyaan lebih lanjut, hubungi developer atau lihat dokumentasi teknis di folder `docs/`.