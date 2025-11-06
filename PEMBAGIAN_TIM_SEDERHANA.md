# 🚀 PEMBAGIAN TIM - TRYOUT ONLINE

## 📌 RINGKAS & JELAS

---

## 👥 TIM 1: FRONTEND (Tampilan)

### Yang Dikerjakan:
**SEMUA FILE DI FOLDER INI:**
```
resources/css/              ← Edit CSS
resources/js/               ← Edit JavaScript  
resources/views/            ← Edit tampilan HTML
```

### Tugas Spesifik:

#### 1. Halaman User (Peserta Ujian)
```
resources/views/views_user/
├── dashboard.blade.php          ← Dashboard user
├── ujian/
│   ├── index.blade.php          ← List ujian
│   ├── show.blade.php           ← Detail ujian
│   └── tryout.blade.php         ← Halaman mengerjakan ujian
├── nilai/
│   └── index.blade.php          ← Lihat nilai
├── pembelian/
│   └── index.blade.php          ← Riwayat pembelian
├── materials/
│   ├── index.blade.php          ← List materi
│   └── show.blade.php           ← Baca materi
└── live_zoom/
    ├── index.blade.php          ← List kelas live
    └── show.blade.php           ← Detail kelas
```

#### 2. Halaman Admin
```
resources/views/admin/
├── dashboard.blade.php          ← Dashboard admin
├── soal/
│   ├── index.blade.php          ← List soal
│   ├── form.blade.php           ← Tambah/edit soal
│   └── bulk-import.blade.php    ← Import soal
├── ujian/
│   ├── index.blade.php          ← List ujian
│   └── form.blade.php           ← Tambah/edit ujian
├── user/
│   └── index.blade.php          ← Manajemen user
└── pembelian/
    └── index.blade.php          ← Data transaksi
```

#### 3. Halaman Tutor
```
resources/views/tutor/
├── dashboard.blade.php          ← Dashboard tutor
├── bank_soal/
│   ├── index.blade.php          ← List bank soal
│   ├── create.blade.php         ← Buat soal baru
│   └── edit.blade.php           ← Edit soal
└── live-classes/
    ├── index.blade.php          ← List kelas
    └── create.blade.php         ← Buat kelas baru
```

#### 4. Halaman Login/Register
```
resources/views/auth/
├── login.blade.php              ← Halaman login
├── register.blade.php           ← Halaman daftar
└── forgot-password.blade.php    ← Lupa password
```

#### 5. Styling
```
resources/css/
├── app.css                      ← CSS utama
├── custom.css                   ← CSS tambahan
└── custom-scoped.css            ← CSS khusus komponen
```

### Command Yang Sering Dipakai:
```bash
npm run dev         # Jalankan ini saat edit CSS/JS (auto reload)
npm run build       # Build untuk production
php artisan serve   # Test di browser
```

---

## 👥 TIM 2: BACKEND (Logika Program)

### Yang Dikerjakan:
**SEMUA FILE DI FOLDER INI:**
```
app/Http/Controllers/       ← Logic program
routes/                     ← URL & routing
app/Services/               ← Service khusus
```

### Tugas Spesifik:

#### 1. Controller User (Peserta)
```
app/Http/Controllers/
├── UjianController.php          ← Logic ujian user
├── SoalController.php           ← Logic soal user
├── JawabanController.php        ← Submit jawaban
├── PembelianController.php      ← Logic pembelian
├── UserBankSoalController.php   ← Bank soal user
├── UserMaterialController.php   ← Materi user
└── UserLiveClassController.php  ← Live class user
```

#### 2. Controller Admin
```
app/Http/Controllers/Admin/
├── UjianController.php          ← CRUD ujian admin
├── SoalController.php           ← CRUD soal admin
├── AdminController.php          ← Manajemen admin
├── VoucherController.php        ← CRUD voucher
└── PesertaUjianController.php   ← Data peserta ujian
```

#### 3. Controller Tutor
```
app/Http/Controllers/Tutor/
├── BankSoalController.php       ← CRUD bank soal
├── LiveClassController.php      ← CRUD live class
└── MaterialController.php       ← CRUD material
```

#### 4. Payment (Midtrans)
```
app/Services/Midtrans/
├── CreateSnapTokenService.php   ← Generate payment token
├── CallbackService.php          ← Handle payment callback
└── Midtrans.php                 ← Midtrans config
```

#### 5. Routes
```
routes/
├── web.php                      ← Route untuk halaman web
└── api.php                      ← Route untuk API
```

### Command Yang Sering Dipakai:
```bash
php artisan route:list              # Lihat semua route
php artisan make:controller         # Buat controller baru
php artisan cache:clear             # Clear cache
php artisan config:clear            # Clear config
```

---

## 👥 TIM 3: DATABASE (Data)

### Yang Dikerjakan:
**SEMUA FILE DI FOLDER INI:**
```
app/Models/                 ← Model data
database/migrations/        ← Struktur tabel
database/seeders/           ← Data dummy
```

### Tugas Spesifik:

#### 1. Models (File Data)
```
app/Models/
├── User.php                 ← Model user
├── Ujian.php                ← Model ujian
├── PaketUjian.php           ← Model paket ujian
├── Soal.php                 ← Model soal
├── Jawaban.php              ← Model jawaban
├── JawabanPeserta.php       ← Model jawaban peserta
├── Pembelian.php            ← Model pembelian
├── BankSoal.php             ← Model bank soal
├── LiveClass.php            ← Model live class
├── Material.php             ← Model material
├── Article.php              ← Model artikel
├── Voucher.php              ← Model voucher
├── Wilayah.php              ← Model wilayah
├── Prodi.php                ← Model prodi
└── Formasi.php              ← Model formasi
```

**Yang Dikerjakan di Model:**
- Definisi relationship (hasMany, belongsTo, dll)
- Fillable fields
- Hidden fields
- Casts (type data)

#### 2. Migrations (Struktur Tabel)
```
database/migrations/
├── xxxx_create_users_table.php
├── xxxx_create_ujian_table.php
├── xxxx_create_soal_table.php
├── xxxx_create_jawaban_table.php
├── xxxx_create_pembelian_table.php
└── ... (semua migration files)
```

**Yang Dikerjakan:**
- Bikin tabel baru
- Tambah kolom
- Edit struktur tabel
- Bikin foreign key
- Bikin index

#### 3. Seeders (Data Dummy)
```
database/seeders/
├── DatabaseSeeder.php           ← Main seeder
├── AdminUserSeeder.php          ← Data admin
├── RegularUserSeeder.php        ← Data user biasa
├── TutorSeeder.php              ← Data tutor
├── UjianSeeder.php              ← Data ujian dummy
├── SoalJawabanSeeder.php        ← Data soal & jawaban
├── WilayahSeeder.php            ← Data wilayah
├── ProdiSeeder.php              ← Data prodi
└── FormasiSeeder.php            ← Data formasi
```

### Command Yang Sering Dipakai:
```bash
php artisan make:model NamaModel           # Buat model baru
php artisan make:migration create_xxx      # Buat migration
php artisan make:seeder NamaSeeder         # Buat seeder
php artisan migrate                        # Jalankan migration
php artisan migrate:fresh --seed           # Reset DB + isi data
php artisan db:seed                        # Isi data aja
php artisan migrate:rollback               # Undo migration
```

---

## ⚡ QUICK REFERENCE

### Setup Pertama Kali (SEMUA TIM):
```bash
# 1. Clone project
git clone [url-repo]
cd tryout-master

# 2. Install
composer install      # Install PHP packages
npm install          # Install Node packages

# 3. Setup .env
cp .env.example .env
# Edit .env: DB_DATABASE, DB_USERNAME, DB_PASSWORD

# 4. Generate key
php artisan key:generate

# 5. Setup database
php artisan migrate --seed

# 6. Run project
php artisan serve     # Terminal 1 (Backend)
npm run dev          # Terminal 2 (Frontend)
```

### Buka di Browser:
- User: http://localhost:8000
- Admin: http://localhost:8000/admin
- Tutor: http://localhost:8000/tutor

### Login Default (dari seeder):
```
Admin:
Email: admin@example.com
Pass: password

Tutor:
Email: tutor@example.com
Pass: password

User:
Email: user@example.com
Pass: password
```

---

## 📋 KOORDINASI TIM

### Kapan Harus Koordinasi:

#### Frontend ↔ Backend:
- **Frontend:** "Gue butuh data ujian dalam format apa?"
- **Backend:** "Gue kirim JSON dengan struktur: {id, nama, waktu, dll}"

#### Backend ↔ Database:
- **Database:** "Gue nambah kolom 'status' di tabel ujian ya"
- **Backend:** "Ok, gue update controller untuk handle kolom baru"

#### Frontend ↔ Database:
- **Frontend:** "Gue butuh dropdown wilayah, ada?"
- **Database:** "Ada, pake seeder WilayahSeeder, bisa dipanggil dari backend"

### File Yang HARUS Diskusi Dulu:
- `.env` - Setting environment
- `composer.json` - Package PHP
- `package.json` - Package JavaScript
- `config/*.php` - Konfigurasi

---

## 🔄 WORKFLOW

### 1. Ambil Task
```bash
git pull origin develop
git checkout -b feature/[tim]-[fitur]
# Contoh: feature/frontend-dashboard
```

### 2. Kerjakan
- Frontend: Edit views & CSS
- Backend: Edit controllers & routes  
- Database: Edit models & migrations

### 3. Test
- Frontend: Cek di browser
- Backend: Test API/functionality
- Database: Cek data di database

### 4. Commit & Push
```bash
git add .
git commit -m "feat: deskripsi fitur"
git push origin feature/[tim]-[fitur]
```

### 5. Pull Request
- Bikin PR di GitHub/GitLab
- Minta review minimal 1 orang
- Merge kalau sudah OK

---

## 🆘 TROUBLESHOOTING

### Frontend:
```bash
# CSS ga berubah
npm run build
php artisan view:clear

# Error saat npm run dev
rm -rf node_modules package-lock.json
npm install
```

### Backend:
```bash
# Error 500
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Class not found
composer dump-autoload
```

### Database:
```bash
# Migration error
php artisan migrate:fresh --seed

# Rollback 1 migration
php artisan migrate:rollback --step=1

# Cek status
php artisan migrate:status
```

---

## ✅ CHECKLIST

### Sebelum Mulai:
- [ ] Git sudah setup
- [ ] Composer & Node.js terinstall
- [ ] Database sudah dibuat
- [ ] .env sudah diconfig
- [ ] php artisan serve jalan
- [ ] npm run dev jalan

### Sebelum Commit:
- [ ] Code sudah di-test
- [ ] No error di console
- [ ] Sesuai dengan task
- [ ] Code clean & rapi

### Sebelum Merge:
- [ ] Sudah direview
- [ ] No conflict
- [ ] Testing passed
- [ ] Documentation updated

---

## 📞 CONTACT

**Group Chat:** [Link grup]
**Project Manager:** [Nama & No HP]
**Git Repository:** [URL repo]

**Meeting:**
- Daily: [Jam] via [Platform]
- Review: [Hari & Jam]

---

## 💡 TIPS

### Frontend:
✅ Test di mobile & desktop
✅ Pakai component yang sudah ada
✅ Konsisten dengan design
✅ Optimize gambar

### Backend:
✅ Validate semua input
✅ Handle error dengan baik
✅ Kasih comment di logic kompleks
✅ Test API pakai Postman

### Database:
✅ Backup sebelum migrate
✅ Kasih foreign key
✅ Index untuk kolom yang sering dicari
✅ Test seeder data

---

**🎉 Selamat Mengerjakan! Semangat! 💪**

**Ingat:** Komunikasi adalah kunci! Jangan malu bertanya kalau ada yang bingung! 🚀