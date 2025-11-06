# 📋 PEMBAGIAN TUGAS TIM - TRYOUT ONLINE

## 🎯 RINGKASAN
Proyek: Aplikasi Tryout/Ujian Online (Laravel)
Tim: 3 kelompok (Frontend, Backend, Database)

---

## 👥 TIM 1: FRONTEND (UI/UX)

### 🎨 Tanggung Jawab:
Tampilan visual, user interface, responsiveness

### 📂 Folder Kerja Utama:
```
resources/
├── css/
│   ├── app.css
│   ├── custom.css
│   └── custom-scoped.css
├── js/
│   ├── app.js
│   └── bootstrap.js
└── views/
    ├── welcome.blade.php
    ├── dashboard.blade.php
    ├── views_user/         ← Halaman User
    ├── admin/              ← Halaman Admin
    ├── tutor/              ← Halaman Tutor
    ├── auth/               ← Login/Register
    ├── components/         ← Komponen reusable
    └── layouts/            ← Template layout
```

### ✅ Task List:
- [ ] **Landing Page** (`welcome.blade.php`)
- [ ] **Dashboard User** (`views_user/dashboard.blade.php`)
- [ ] **Halaman Ujian** (`views_user/ujian/*.blade.php`)
- [ ] **Halaman Nilai** (`views_user/nilai/*.blade.php`)
- [ ] **Halaman Pembelian** (`views_user/pembelian/*.blade.php`)
- [ ] **Dashboard Admin** (`admin/dashboard.blade.php`)
- [ ] **Manajemen Soal Admin** (`admin/soal/*.blade.php`)
- [ ] **Dashboard Tutor** (`tutor/dashboard.blade.php`)
- [ ] **Authentication Pages** (`auth/*.blade.php`)
- [ ] **Responsive Design** (mobile, tablet, desktop)
- [ ] **Custom CSS Styling** (`css/custom.css`)
- [ ] **Component Styling** (`components/*.blade.php`)

### 🔧 Tools & Commands:
```bash
npm run dev          # Development mode (watch)
npm run build        # Production build
php artisan serve    # Test server
```

---

## 👥 TIM 2: BACKEND (Logic & API)

### ⚙️ Tanggung Jawab:
Business logic, API endpoints, integrations

### 📂 Folder Kerja Utama:
```
app/
├── Http/
│   ├── Controllers/
│   │   ├── UjianController.php
│   │   ├── SoalController.php
│   │   ├── PembelianController.php
│   │   ├── Admin/           ← Controller Admin
│   │   └── Tutor/           ← Controller Tutor
│   ├── Middleware/
│   └── Requests/            ← Form validation
├── Services/
│   └── Midtrans/            ← Payment integration
└── Policies/                ← Authorization

routes/
├── web.php                  ← Web routes
└── api.php                  ← API routes
```

### ✅ Task List:
- [ ] **Ujian System** (`UjianController.php`)
- [ ] **Soal & Jawaban** (`SoalController.php`, `JawabanController.php`)
- [ ] **Payment Integration** (`Services/Midtrans/`)
- [ ] **Admin Controllers** (`Controllers/Admin/`)
- [ ] **Tutor Controllers** (`Controllers/Tutor/`)
- [ ] **Authentication Logic** (`GoogleController.php`)
- [ ] **API Endpoints** (`routes/api.php`)
- [ ] **Authorization Policies** (`Policies/`)
- [ ] **Form Validation** (`Requests/`)
- [ ] **Middleware** (`Middleware/Authenticate.php`)
- [ ] **Email Notifications** (`Mail/Message.php`)
- [ ] **File Upload Handling**

### 🔧 Tools & Commands:
```bash
php artisan route:list        # List all routes
php artisan make:controller   # Create controller
php artisan make:request      # Create form request
php artisan tinker            # Test code
```

---

## 👥 TIM 3: DATABASE (Data Structure)

### 🗄️ Tanggung Jawab:
Database schema, models, relationships

### 📂 Folder Kerja Utama:
```
app/Models/
├── User.php
├── Ujian.php
├── Soal.php
├── Jawaban.php
├── Pembelian.php
├── BankSoal.php
├── LiveClass.php
└── ... (all models)

database/
├── migrations/              ← Table structures
├── seeders/                ← Sample data
│   ├── DatabaseSeeder.php
│   ├── AdminUserSeeder.php
│   ├── UjianSeeder.php
│   └── SoalJawabanSeeder.php
└── factories/              ← Test data
```

### ✅ Task List:
- [ ] **User Models** (`User.php`, `UsersDetail.php`)
- [ ] **Ujian Models** (`Ujian.php`, `PaketUjian.php`, `UjianUser.php`)
- [ ] **Soal Models** (`Soal.php`, `Jawaban.php`, `BankSoal.php`)
- [ ] **Payment Models** (`Pembelian.php`, `Voucher.php`)
- [ ] **Learning Models** (`LiveClass.php`, `Material.php`)
- [ ] **Model Relationships** (hasMany, belongsTo, etc.)
- [ ] **Migrations** - Create all tables
- [ ] **Seeders** - Sample data untuk testing
- [ ] **Foreign Keys & Indexes**
- [ ] **Database Optimization**

### 🔧 Tools & Commands:
```bash
php artisan make:model        # Create model
php artisan make:migration    # Create migration
php artisan make:seeder       # Create seeder
php artisan migrate           # Run migrations
php artisan migrate:fresh --seed   # Reset & seed
php artisan db:seed           # Run seeders only
```

---

## 🔄 KOORDINASI ANTAR TIM

### 📢 Yang HARUS Dikomunikasikan:

#### Frontend → Backend:
- Struktur form (field apa saja yang ada)
- API endpoint yang dibutuhkan
- Format response data yang diinginkan

#### Backend → Frontend:
- API endpoint tersedia
- Struktur response JSON
- Validation rules

#### Database → Backend:
- Perubahan struktur tabel
- Penambahan/pengurangan kolom
- Nama relationship methods

#### Backend → Database:
- Query yang kompleks perlu optimization
- Data apa yang perlu di-seed

---

## ⚠️ ATURAN PENTING

### ❌ JANGAN Edit Bersamaan:
- `.env` file
- `composer.json` / `package.json`
- `config/*.php` files

### ✅ Best Practice:
```bash
# 1. Selalu pull dulu sebelum mulai
git pull origin develop

# 2. Buat branch untuk fitur
git checkout -b feature/[tim]-[nama-fitur]
# Contoh: feature/frontend-dashboard-user

# 3. Commit dengan pesan jelas
git commit -m "feat: tambah halaman dashboard user"

# 4. Push ke branch sendiri
git push origin feature/[tim]-[nama-fitur]

# 5. Buat Pull Request
# Review oleh minimal 1 orang sebelum merge
```

---

## 🚀 QUICK START

### Setup Awal (Semua Tim):
```bash
# 1. Clone repo
git clone [repo-url]
cd tryout-master

# 2. Install dependencies
composer install
npm install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Setup database (edit .env dulu)
php artisan migrate --seed

# 5. Run development
php artisan serve      # Terminal 1
npm run dev           # Terminal 2
```

### Test URL:
- Frontend: http://localhost:8000
- Admin: http://localhost:8000/admin
- API: http://localhost:8000/api

### Default Login (dari seeder):
**Admin:**
- Email: admin@example.com
- Password: password

**Tutor:**
- Email: tutor@example.com  
- Password: password

**User:**
- Email: user@example.com
- Password: password

---

## 📁 STRUKTUR FILE LENGKAP

### Frontend Files:
```
resources/css/          → Styling
resources/js/           → JavaScript
resources/views/        → Blade templates
public/                 → Assets (images, fonts)
tailwind.config.js      → Tailwind config
postcss.config.js       → PostCSS config
```

### Backend Files:
```
app/Http/Controllers/   → Business logic
app/Services/           → Service classes
app/Mail/              → Email templates
app/Policies/          → Authorization
routes/                → Route definitions
```

### Database Files:
```
app/Models/            → Eloquent models
database/migrations/   → Table schemas
database/seeders/      → Sample data
database/factories/    → Test data
config/database.php    → DB config
```

---

## 📞 CONTACT

**Koordinator:** [Nama Koordinator]
**Frontend Lead:** [Nama]
**Backend Lead:** [Nama]
**Database Lead:** [Nama]

**Meeting:**
- Daily: [Jam]
- Review: [Hari & Jam]

---

## ✅ CHECKLIST PROGRESS

### Week 1:
- [ ] Setup environment semua tim
- [ ] Database schema & migrations
- [ ] Basic CRUD controllers
- [ ] Landing page & auth pages

### Week 2:
- [ ] User dashboard & ujian flow
- [ ] Admin panel basic
- [ ] API endpoints complete
- [ ] Payment integration

### Week 3:
- [ ] Tutor dashboard
- [ ] Live class & materials
- [ ] Styling & responsive
- [ ] Testing & bug fixes

### Week 4:
- [ ] Final testing
- [ ] Documentation
- [ ] Deployment preparation
- [ ] Presentation prep

---

**💪 Semangat mengerjakan! Komunikasi adalah kunci sukses kerja kelompok!**