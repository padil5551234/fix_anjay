# 🚀 Panduan Hosting Gratis untuk Aplikasi Tryout Laravel

## 📋 Ringkasan Aplikasi Anda
- **Framework**: Laravel 10
- **PHP Version**: ^8.1
- **Database**: MySQL
- **Fitur Khusus**: Midtrans Payment Gateway, AdminLTE, Livewire, Excel Import/Export

---

## 🌟 Pilihan Hosting Gratis Terbaik

### 1. **InfinityFree** ⭐ RECOMMENDED untuk Testing
**Website**: https://infinityfree.net

#### ✅ Kelebihan:
- Unlimited bandwidth
- 5GB storage gratis
- Support PHP 8.1 & MySQL
- cPanel included
- Subdomain gratis (.infinityfreeapp.com)
- Bisa custom domain
- No ads (tanpa iklan)

#### ❌ Kekurangan:
- Ada hit limit (50k hits/day)
- Tidak support beberapa fungsi PHP (mail, exec)
- Performance terbatas

#### 📝 Cara Deploy:
```bash
1. Daftar di infinityfree.net
2. Buat hosting account
3. Upload file via FileZilla/FTP atau File Manager
4. Import database via phpMyAdmin
5. Update .env dengan database credentials
6. Set APP_ENV=production
```

---

### 2. **Railway.app** ⭐⭐ BEST untuk Laravel
**Website**: https://railway.app

#### ✅ Kelebihan:
- $5 credit gratis per bulan
- Support PostgreSQL/MySQL gratis
- Git deployment otomatis
- Environment variables mudah
- Support background jobs
- Custom domain
- SSL gratis

#### ❌ Kekurangan:
- Credit habis untuk traffic tinggi
- Perlu kartu kredit untuk verify (tidak dicharge)

#### 📝 Cara Deploy:
```bash
# 1. Login dengan GitHub
# 2. New Project → Deploy from GitHub repo
# 3. Pilih repository Anda
# 4. Add MySQL database
# 5. Set environment variables:

APP_NAME=Tryout
APP_ENV=production
APP_KEY=<generate baru>
APP_DEBUG=false
APP_URL=https://your-app.railway.app

DB_CONNECTION=mysql
DB_HOST=${{MYSQL.MYSQLHOST}}
DB_PORT=${{MYSQL.MYSQLPORT}}
DB_DATABASE=${{MYSQL.MYSQLDATABASE}}
DB_USERNAME=${{MYSQL.MYSQLUSER}}
DB_PASSWORD=${{MYSQL.MYSQLPASSWORD}}

# Add Midtrans credentials
MIDTRANS_SERVER_KEY=your_key
MIDTRANS_CLIENT_KEY=your_key
MIDTRANS_IS_PRODUCTION=false

# 6. Add build command:
composer install --no-dev --optimize-autoloader
php artisan key:generate
php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

### 3. **Render.com** ⭐⭐
**Website**: https://render.com

#### ✅ Kelebihan:
- Web service gratis (750 hours/month)
- PostgreSQL gratis (90 hari)
- Git auto-deploy
- SSL gratis
- Custom domain
- Good performance

#### ❌ Kekurangan:
- Free tier sleep setelah 15 menit inaktif
- MySQL tidak gratis (pakai PostgreSQL)
- Database gratis hanya 90 hari

#### 📝 Cara Deploy:
```bash
# 1. Connect GitHub repository
# 2. Create Web Service
# 3. Set Build Command:
composer install --no-dev
php artisan key:generate
php artisan migrate --force
php artisan storage:link

# 4. Set Start Command:
php artisan serve --host=0.0.0.0 --port=$PORT

# 5. Add Environment Variables (sama seperti Railway)
```

---

### 4. **000webhost** (Alternatif)
**Website**: https://www.000webhost.com

#### ✅ Kelebihan:
- Gratis selamanya
- PHP & MySQL support
- cPanel-like interface
- 300MB storage
- 3GB bandwidth

#### ❌ Kekurangan:
- Ada ads di bottom page
- Performance lambat
- Server sering down
- Limited PHP functions

---

### 5. **Vercel** (Untuk Frontend Testing)
**Website**: https://vercel.com

#### ⚠️ Catatan:
Vercel bagus untuk static sites, tapi **TIDAK RECOMMENDED** untuk aplikasi Laravel yang full-stack seperti Anda.

---

## 🎯 Rekomendasi Berdasarkan Kebutuhan

### Untuk Testing Cepat (1-2 minggu):
**👉 InfinityFree** atau **000webhost**
- Setup cepat
- Tidak perlu kartu kredit
- Langsung bisa diakses

### Untuk Testing Professional (1-3 bulan):
**👉 Railway.app** atau **Render.com**
- Auto deployment
- Good performance
- Support penuh Laravel
- Mudah maintenance

### Untuk Production (Setelah testing):
Pertimbangkan upgrade ke:
- **Niagahoster** (Rp 10-20rb/bulan)
- **Hostinger** (mulai $2/month)
- **DigitalOcean** ($5/month)
- **Vultr** ($2.5/month)

---

## 📦 Persiapan Sebelum Deploy

### 1. Optimize Aplikasi
```bash
# Jalankan di local dulu:
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### 2. Update .env untuk Production
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

# Security
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=lax

# Log
LOG_CHANNEL=daily
LOG_LEVEL=error
```

### 3. File yang Harus Di-upload
```
✅ app/
✅ bootstrap/
✅ config/
✅ database/
✅ public/
✅ resources/
✅ routes/
✅ storage/ (dengan permissions 755)
✅ vendor/ (hasil composer install)
✅ .env (copy dari .env.example)
✅ artisan
✅ composer.json
```

### 4. File yang JANGAN Di-upload
```
❌ .git/
❌ node_modules/
❌ tests/
❌ .env.example
❌ .gitignore
❌ README.md (optional)
```

---

## 🔧 Setup Database di Hosting

### Cara Import Database:
```bash
# 1. Export database local
php artisan migrate:fresh --seed
mysqldump -u root tryout > database_backup.sql

# 2. Login ke hosting phpMyAdmin
# 3. Create database baru
# 4. Import database_backup.sql
# 5. Update .env dengan credentials baru
```

---

## 🐛 Troubleshooting Umum

### Error 500 - Internal Server Error
```bash
# Cek permissions:
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/

# Regenerate key:
php artisan key:generate

# Clear cache:
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### Error Database Connection
```bash
# Pastikan di .env:
DB_CONNECTION=mysql
DB_HOST=localhost  # atau IP dari hosting
DB_PORT=3306
DB_DATABASE=nama_database_dari_hosting
DB_USERNAME=username_dari_hosting
DB_PASSWORD=password_dari_hosting
```

### Error Midtrans
```bash
# Set ke sandbox mode untuk testing:
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true
```

### Error File Upload
```bash
# Buat symlink storage:
php artisan storage:link

# Set permissions:
chmod -R 755 storage/
chmod -R 755 public/storage/
```

---

## 🚀 Quick Start: Deploy ke Railway (RECOMMENDED)

### Step 1: Persiapan Repository
```bash
# 1. Push code ke GitHub (jika belum)
git add .
git commit -m "Prepare for deployment"
git push origin main
```

### Step 2: Deploy ke Railway
1. Buka https://railway.app
2. Sign in dengan GitHub
3. Click "New Project" → "Deploy from GitHub repo"
4. Pilih repository tryout Anda
5. Tunggu build selesai

### Step 3: Add Database
1. Click "New" → "Database" → "Add MySQL"
2. Database otomatis terhubung

### Step 4: Set Environment Variables
1. Click project → "Variables"
2. Paste semua isi file .env Anda
3. Railway otomatis inject database credentials

### Step 5: Run Migrations
1. Settings → Deploy → Add Start Command:
```bash
php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT
```

### Step 6: Get Your URL
1. Settings → Domains → Generate Domain
2. Copy URL dan test aplikasi Anda!

---

## 💡 Tips Penting

### 1. Keamanan
```bash
# Always set production mode:
APP_ENV=production
APP_DEBUG=false

# Generate new APP_KEY:
php artisan key:generate
```

### 2. Performance
```bash
# Cache everything:
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 3. Midtrans Testing
```bash
# Gunakan sandbox credentials untuk testing:
MIDTRANS_IS_PRODUCTION=false

# Test cards:
# Visa: 4811 1111 1111 1114
# MasterCard: 5211 1111 1111 1117
```

### 4. Backup
```bash
# Selalu backup database sebelum migration:
php artisan backup:run  # jika pakai spatie/laravel-backup
# atau manual:
mysqldump -u user -p database_name > backup.sql
```

---

## 📞 Resource Tambahan

### Tutorial Deploy Laravel:
- Railway: https://dev.to/railway/deploy-laravel-on-railway-4df2
- Render: https://render.com/docs/deploy-laravel
- InfinityFree: https://forum.infinityfree.com/t/how-to-deploy-laravel

### Laravel Production Best Practices:
- https://laravel.com/docs/10.x/deployment
- https://laravel.com/docs/10.x/optimization

---

## ✅ Kesimpulan

**Untuk Anda, saya rekomendasikan Railway.app karena:**
1. ✅ Support penuh untuk Laravel + MySQL
2. ✅ Auto deployment dari GitHub
3. ✅ Midtrans bisa jalan tanpa masalah
4. ✅ Performance bagus untuk testing
5. ✅ Free tier cukup generous ($5 credit/month)
6. ✅ Mudah scale ke production nanti

**Alternative: InfinityFree jika:**
- Tidak punya kartu kredit
- Butuh setup cepat tanpa Git
- Traffic rendah untuk testing internal

---

## 🎓 Next Steps

1. Pilih hosting (Railway recommended)
2. Backup database local
3. Push code ke GitHub
4. Deploy ke hosting pilihan
5. Test semua fitur (terutama Midtrans)
6. Share link dengan team untuk testing

Selamat mencoba! 🚀