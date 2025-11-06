
# PANDUAN LENGKAP MENAMBAHKAN SOAL UJIAN
## Dari Login Admin Sampai Selesai

---

## 📋 DAFTAR ISI
1. [Login ke Sistem](#1-login-ke-sistem)
2. [Akses Dashboard Admin](#2-akses-dashboard-admin)
3. [Membuat Ujian Baru](#3-membuat-ujian-baru)
4. [Menambahkan Soal](#4-menambahkan-soal)
5. [Publish Ujian](#5-publish-ujian)
6. [Tips & Troubleshooting](#6-tips--troubleshooting)

---

## 1. LOGIN KE SISTEM

### Langkah 1.1: Akses Halaman Login
1. Buka browser (Chrome, Firefox, Edge, dll)
2. Ketik URL aplikasi di address bar: `http://localhost` atau sesuai domain Anda
3. Tekan Enter

### Langkah 1.2: Masukkan Kredensial
1. Masukkan **Email** admin Anda
2. Masukkan **Password** admin Anda
3. Klik tombol **"Login"**

> **⚠️ PENTING:** 
> - Pastikan Anda login dengan akun yang memiliki role **admin**, **panitia**, atau **bendahara**

## ➕ Cara Menambahkan Soal Manual

### Langkah 1: Klik Tombol Tambah
1. Di halaman daftar soal, klik tombol **"Tambah"** (warna hijau dengan icon +)
2. Anda akan dibawa ke halaman formulir tambah soal

### Langkah 2: Isi Formulir Soal

Formulir akan menampilkan field-field berikut:

#### A. **Jenis Soal** (Hanya muncul untuk ujian SKD)
- Pilih salah satu: **TWK**, **TIU**, atau **TKP**
- Untuk ujian umum/matematika, field ini tidak muncul

#### B. **Soal** (WAJIB)
- Ketik pertanyaan soal Anda di editor
- Editor mendukung format HTML (bold, italic, dll)
- Bisa memasukkan gambar, tabel, atau rumus matematika

**Contoh:**
```
Hasil dari 25 × 8 + 144 ÷ 12 adalah...
```

#### C. **Jawaban A sampai E** (WAJIB - 5 Pilihan)
- Isi 5 pilihan jawaban (A, B, C, D, E)
- Setiap jawaban bisa menggunakan editor HTML
- Minimal harus ada 5 pilihan

**Contoh:**
- Jawaban A: `210`
- Jawaban B: `212`
- Jawaban C: `214`
- Jawaban D: `216`
- Jawaban E: `218`

#### D. **Kunci Jawaban** (WAJIB - kecuali untuk TKP)
- Pilih huruf (A, B, C, D, atau E) yang merupakan jawaban benar
- Dropdown akan menampilkan pilihan A-E

**Contoh:**
```
Kunci Jawaban: B
```

#### E. **Nilai Benar, Kosong, Salah** (WAJIB - kecuali untuk TKP)
- **Nilai Benar**: Poin yang didapat jika jawaban benar (contoh: 4 atau 5)
- **Nilai Kosong**: Poin jika tidak menjawab (biasanya: 0)
- **Nilai Salah**: Poin jika jawaban salah (biasanya: -1)

**Contoh untuk Matematika:**
```
Nilai Benar: 4
Nilai Kosong: 0
Nilai Salah: -1
```

#### F. **Pembahasan** (OPSIONAL tapi sangat direkomendasikan)
- Tulis penjelasan cara menyelesaikan soal
- Pembahasan akan ditampilkan ke peserta setelah ujian selesai
- Gunakan step-by-step untuk memudahkan pemahaman

**Contoh:**
```
Pembahasan:
25 × 8 + 144 ÷ 12
= 200 + 12
= 212

Jadi jawabannya adalah 212 (B)
```

### Langkah 3: Simpan Soal
1. Setelah semua field diisi, scroll ke bawah
2. Klik tombol **"Save"** (warna hijau)
3. Jika berhasil, Anda akan kembali ke halaman daftar soal
4. Soal baru akan muncul di tabel

### Langkah 4: Ulangi untuk Soal Berikutnya
- Klik tombol **"Tambah"** lagi untuk menambahkan soal berikutnya
- Ulangi proses pengisian sampai jumlah soal terpenuhi

---

## 📝 Penjelasan Setiap Field

### 1️⃣ Field "Soal"
- **Tipe**: Rich Text Editor (Summernote)
- **Fungsi**: Tempat menulis pertanyaan soal
- **Tips**: 
  - Gunakan formatting untuk memperjelas soal
  - Bisa insert gambar dengan klik icon gambar
  - Untuk rumus matematika, bisa ketik manual atau gunakan special character

### 2️⃣ Field "Jawaban A-E"
- **Tipe**: Rich Text Editor (Summernote) - 5 field terpisah
- **Fungsi**: Tempat menulis pilihan jawaban
- **Tips**: 
  - Pastikan 5 pilihan sudah terisi semua
  - Usahakan panjang jawaban relatif sama
  - Untuk soal matematika, jawaban biasanya angka

### 3️⃣ Field "Kunci Jawaban"
- **Tipe**: Dropdown (A/B/C/D/E)
- **Fungsi**: Menandai jawaban yang benar
- **Tips**: 
  - WAJIB dipilih untuk soal non-TKP
  - Pastikan memilih huruf yang sesuai dengan jawaban benar

### 4️⃣ Field "Nilai Benar/Kosong/Salah"
- **Tipe**: Number Input
- **Fungsi**: Menentukan sistem penilaian
- **Tips**: 
  - **Nilai Benar**: Biasanya 4-5 poin
  - **Nilai Kosong**: Biasanya 0 poin
  - **Nilai Salah**: Biasanya -1 atau 0 poin (untuk mencegah menebak)

### 5️⃣ Field "Pembahasan"
- **Tipe**: Rich Text Editor (Summernote)
- **Fungsi**: Penjelasan cara menjawab soal
- **Tips**: 
  - Tulis step-by-step
  - Jelaskan rumus/konsep yang digunakan
  - Sangat membantu peserta untuk belajar

### 6️⃣ Field "Point" (Khusus TKP)
- **Tipe**: Number Input - 5 field (satu per jawaban)
- **Fungsi**: Menentukan poin untuk setiap pilihan jawaban TKP
- **Tips**: 
  - Setiap jawaban memiliki poin berbeda (1-5)
  - Tidak ada kunci jawaban untuk TKP

---

## 💡 Contoh Pengisian Soal

### Contoh 1: Soal Matematika Dasar

**Field Soal:**
```
Hasil dari 25 × 8 + 144 ÷ 12 adalah...
```

**Field Jawaban:**
- A: `210`
- B: `212` ← **Kunci Jawaban**
- C: `214`
- D: `216`
- E: `218`

**Kunci Jawaban:** `B`

**Penilaian:**
- Nilai Benar: `4`
- Nilai Kosong: `0`
- Nilai Salah: `-1`

**Pembahasan:**
```
Pembahasan:
Gunakan aturan operasi hitung (perkalian dan pembagian terlebih dahulu)

25 × 8 + 144 ÷ 12
= 200 + 12
= 212

Jadi jawabannya adalah B (212)
```

### Contoh 2: Soal Aljabar

**Field Soal:**
```
Jika 2x + 7 = 19, maka nilai x adalah...
```

**Field Jawaban:**
- A: `4`
- B: `5`
- C: `6` ← **Kunci Jawaban**
- D: `7`
- E: `8`

**Kunci Jawaban:** `C`

**Penilaian:**
- Nilai Benar: `5`
- Nilai Kosong: `0`
- Nilai Salah: `-1`

**Pembahasan:**
```
Pembahasan:
2x + 7 = 19
2x = 19 - 7
2x = 12
x = 12 ÷ 2
x = 6

Jadi jawabannya adalah C (6)
```

### Contoh 3: Soal Geometri

**Field Soal:**
```
Luas lingkaran dengan jari-jari 7 cm adalah... (π = 22/7)
```

**Field Jawaban:**
- A: `144 cm²`
- B: `150 cm²`
- C: `154 cm²` ← **Kunci Jawaban**
- D: `158 cm²`
- E: `162 cm²`

**Kunci Jawaban:** `C`

**Penilaian:**
- Nilai Benar: `5`
- Nilai Kosong: `0`
- Nilai Salah: `-1`

**Pembahasan:**
```
Pembahasan:
Rumus luas lingkaran = π × r²

L = 22/7 × 7²
L = 22/7 × 49
L = 22 × 7
L = 154 cm²

Jadi jawabannya adalah C (154 cm²)
```

---

## 🚀 Cara Menggunakan Seeder (Otomatis)

### Apa itu Seeder?
Seeder adalah cara otomatis untuk menambahkan banyak soal sekaligus menggunakan command line.

### Kapan Menggunakan Seeder?
- Ketika ingin menambahkan banyak soal sekaligus
- Untuk testing atau demo
- Ketika sudah memiliki database soal yang siap

### Langkah-langkah:

#### 1. Buka Terminal/Command Prompt
- **Windows**: Tekan `Win + R`, ketik `cmd`, Enter
- **Mac/Linux**: Buka Terminal
- Atau gunakan terminal di VS Code

#### 2. Navigasi ke Folder Project
```bash
cd c:\Users\padil\OneDrive\Documents\bimbel\tryout-master
```

#### 3. Jalankan Seeder
```bash
php artisan db:seed --class=SoalMatematikaSeeder
```

#### 4. Tunggu Proses Selesai
- Terminal akan menampilkan pesan jika berhasil
- Cek di admin panel, soal sudah masuk otomatis

### Keuntungan Menggunakan Seeder:
✅ Lebih cepat (bisa tambah 10-100 soal sekaligus)
✅ Tidak ada typo atau kesalahan manual
✅ Konsisten (format dan penilaian sama)
✅ Bisa diulang kapan saja

### Kekurangan Seeder:
❌ Harus edit file seeder terlebih dahulu
❌ Perlu pengetahuan programming dasar
❌ Tidak bisa preview langsung

---

## 📊 Progress Bar & Status Soal

### Progress Bar
Di halaman daftar soal, ada progress bar yang menunjukkan:
- **Jumlah soal yang sudah dibuat** vs **Target jumlah soal**
- **Warna hijau**: Masih bisa menambah soal
- **Warna merah**: Jumlah soal sudah penuh

**Contoh:**
```
15 dari 20 soal [=========>    ] 75%
```

### Status Soal untuk Ujian SKD
Untuk ujian SKD, ada breakdown per jenis soal:
- **TWK**: Target 30 soal
- **TIU**: Target 35 soal
- **TKP**: Target 45 soal

### Tombol Aksi
- **Tambah**: Muncul jika soal belum penuh
- **Edit**: Muncul jika ujian belum dipublish
