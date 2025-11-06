# Panduan Upload Proyek Laravel ke InfinityFree.net

## 📋 Persiapan Sebelum Upload

### 1. Persyaratan InfinityFree
- **PHP Version**: InfinityFree mendukung PHP 7.4 - 8.2
- **Database**: MySQL dengan batasan tertentu
- **File Manager**: cPanel dengan File Manager atau FTP
- **Batasan**: 
  - Storage: 5GB
  - Bandwidth: Unlimited
  - MySQL Databases: 400
  - Tidak ada SSH access

### 2. Hal yang Perlu Diperhatikan untuk InfinityFree
⚠️ **PENTING**: InfinityFree memiliki beberapa keterbatasan:
- Tidak ada `composer install` atau `npm install` di server
- Tidak bisa menjalankan `php artisan` commands di server
- Harus upload semua dependencies (`vendor` folder)
- File `.env` harus dikonfigurasi manual

## 🚀 Langkah-Langkah Upload

### STEP 1: Persiapan Proyek di Local

#### 1.1 Install Semua Dependencies
```bash
composer install --optimize-autoloader --no-dev
```

#### 1.2 Optimize untuk Production
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

#### 1.3 Generate Application Key (jika belum ada)
```bash
php artisan key:generate
```

#### 1.4 Edit File `.env` untuk Production
Buat file `.env.production` dengan konfigurasi berikut:

```env
APP_NAME="Bimbel Tryout"
APP_ENV=production
APP_KEY=base64:your_generated_key_here
APP_DEBUG=false
APP_URL=https://yourdomain.infinityfreeapp.com

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=sql123.infinityfree.com
DB_PORT=3306
DB_DATABASE=epiz_xxxxx_database
DB_USERNAME=epiz_xxxxx
DB_PASSWORD=your_database_password

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database
SESSION_DRIVER=file
SESSION_LIFETIME=120

# Midtrans Configuration
MIDTRANS_SERVER_KEY=your_midtrans_key
MIDTRANS_CLIENT_KEY=your_midtrans_client_key
MIDTRANS_IS_PRODUCTION=true
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true

# Mail Configuration (Optional)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

### STEP 2: Buat Akun InfinityFree

1. **Daftar di**: https://infinityfree.net/
2. **Pilih**: "Create Account"
3. **Domain Options**:
   - Gunakan subdomain gratis: `yourdomain.infinityfreeapp.com`
   - Atau gunakan custom domain Anda sendiri

4. **Setelah akun dibuat**, catat informasi berikut:
   - FTP Hostname
   - FTP Username
   - FTP Password
   - MySQL Hostname
   - MySQL Database Name
   - MySQL Username
   - MySQL Password

### STEP 3: Struktur Folder di InfinityFree

InfinityFree menggunakan struktur folder khusus:
```
/htdocs/           <- Root public folder (document root)
    index.php      <- Laravel's public index
    .htaccess
    css/
    js/
    images/
/laravel/          <- Buat folder ini untuk Laravel files
    app/
    bootstrap/
    config/
    database/
    resources/
    routes/
    storage/
    vendor/
    .env
```

### STEP 4: Upload Files

#### 4.1 Menggunakan File Manager cPanel

1. **Login ke cPanel** InfinityFree
2. **Buka File Manager**
3. **Buat folder `laravel`** di root (sejajar dengan htdocs)
4. **Upload semua file Laravel** ke folder `/laravel/` KECUALI folder `public`
   - app/
   - bootstrap/
   - config/
   - database/
   - resources/
   - routes/
   - storage/
   - vendor/ (PENTING: Upload folder vendor)
   - .env (rename dari .env.production)
   - artisan
   - composer.json
   - composer.lock

5. **Upload isi folder `public`** ke `/htdocs/`
   - index.php
   - .htaccess
   - css/
   - js/
   - images/
   - semua asset lainnya

#### 4.2 Menggunakan FileZilla (FTP)

1. **Download FileZilla**: https://filezilla-project.org/
2. **Koneksi FTP**:
   - Host: ftp.yourdomain.infinityfreeapp.com
   - Username: epiz_xxxxx
   - Password: your_ftp_password
   - Port: 21

3. **Upload files** sesuai struktur di atas

### STEP 5: Edit File `index.php` di htdocs

Edit file `/htdocs/index.php`:

```php
<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Check If The Application Is Under Maintenance
|--------------------------------------------------------------------------
*/

if (file_exists($maintenance = __DIR__.'/../laravel/storage/framework/maintenance.php')) {
    require $maintenance;
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
*/

require __DIR__.'/../laravel/vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
*/

$app = require_once __DIR__.'/../laravel/bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
```

### STEP 6: Edit File `.htaccess` di htdocs

Buat/Edit file `/htdocs/.htaccess`:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

### STEP 7: Set Permission Storage Folder

Di cPanel File Manager:
1. **Klik kanan** pada folder `/laravel/storage`
2. **Pilih** "Change Permissions"
3. **Set** permission ke `755` atau `775`
4. **Centang** "Recurse into subdirectories"
5. **Apply**

Lakukan hal yang sama untuk:
- `/laravel/storage/framework/`
- `/laravel/storage/logs/`
- `/laravel/bootstrap/cache/`

### STEP 8: Import Database

#### 8.1 Export Database dari Local

```bash
php artisan migrate:fresh --seed
# Atau jika sudah ada data
mysqldump -u root -p database_name > database_backup.sql
```

#### 8.2 Import ke InfinityFree

1. **Login ke cPanel**
2. **Buka phpMyAdmin**
3. **Pilih database** yang sudah dibuat
4. **Klik Import**
5. **Choose File** -> pilih `database_backup.sql`
6. **Click Go**

**ATAU Manual Migration:**

Buat file `migrate.php` di `/htdocs/`:

```php
<?php
// migrate.php
require __DIR__.'/../laravel/vendor/autoload.php';
$app = require_once __DIR__.'/../laravel/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$status = $kernel->call('migrate:fresh', ['--seed' => true, '--force' => true]);
echo "Migration status: " . $status . "\n";
```

Akses: `https://yourdomain.infinityfreeapp.com/migrate.php`

**⚠️ HAPUS file migrate.php setelah selesai!**

### STEP 9: Update File .env

Edit file `/laravel/.env` melalui File Manager:

```env
APP_URL=https://yourdomain.infinityfreeapp.com
DB_HOST=sql123.infinityfree.com
DB_DATABASE=epiz_xxxxx_dbname
DB_USERNAME=epiz_xxxxx
DB_PASSWORD=your_db_password
```

### STEP 10: Clear Cache (Jika Perlu)

Buat file `clear-cache.php` di `/htdocs/`:

```php
<?php
// clear-cache.php
require __DIR__.'/../laravel/vendor/autoload.php';
$app = require_once __DIR__.'/../laravel/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

echo "Clearing config cache...\n";
$kernel->call('config:clear');

echo "Clearing route cache...\n";
$kernel->call('route:clear');

echo "Clearing view cache...\n";
$kernel->call('view:clear');

echo "Cache cleared successfully!";
```

Akses: `https://yourdomain.infinityfreeapp.com/clear-cache.php`

**⚠️ HAPUS file clear-cache.php setelah selesai!**

## 🔧 Troubleshooting

### Error: "The stream or file could not be opened"
**Solusi**: Set permission `755` atau `775` untuk folder storage dan bootstrap/cache

### Error 500 Internal Server Error
**Solusi**: 
1. Check `.env` file configuration
2. Check `.htaccess` file
3. Check error logs di cPanel

### Database Connection Error
**Solusi**:
1. Verifikasi kredensial database di `.env`
2. Pastikan database sudah dibuat di cPanel
3. Test koneksi database di phpMyAdmin

### Asset Files (CSS/JS) Not Loading
**Solusi**:
1. Pastikan file asset ada di `/htdocs/`
2. Update `APP_URL` di `.env`
3. Gunakan `asset()` helper, bukan URL hardcode

### Midtrans Payment Not Working
**Solusi**:
1. Update `APP_URL` di `.env`
2. Update Callback URL di Midtrans Dashboard
3. Set `MIDTRANS_IS_PRODUCTION=true`

## 📝 Checklist Upload

- [ ] Install dependencies (`composer install --no-dev`)
- [ ] Optimize Laravel (`config:cache`, `route:cache`, `view:cache`)
- [ ] Buat akun InfinityFree
- [ ] Catat semua credentials (FTP, Database)
- [ ] Upload Laravel files ke `/laravel/`
- [ ] Upload public files ke `/htdocs/`
- [ ] Edit `index.php` di htdocs
- [ ] Edit `.htaccess` di htdocs
- [ ] Set permissions untuk storage dan cache
- [ ] Buat database di cPanel
- [ ] Import database
- [ ] Update `.env` file
- [ ] Test website
- [ ] Hapus file helper (migrate.php, clear-cache.php)

## ⚠️ Limitasi InfinityFree untuk Proyek Ini

### Yang TIDAK Akan Berfungsi:
1. **Email Verification** - InfinityFree membatasi mail functions
2. **Queue Jobs** - Tidak ada cron jobs
3. **Real-time Features** - Tidak ada WebSocket support
4. **Large File Uploads** - Batasan upload size

### Solusi Alternatif:
1. **Email**: Gunakan service eksternal seperti Mailgun, SendGrid
2. **Queue**: Gunakan `sync` driver
3. **Cron Jobs**: Gunakan external cron service (cron-job.org)
4. **File Storage**: Gunakan cloud storage (Cloudinary, AWS S3)

## 🔒 Security Tips

1. **Protect .env file**: Pastikan tidak bisa diakses public
2. **Disable debug**: Set `APP_DEBUG=false` di production
3. **Use HTTPS**: InfinityFree otomatis support SSL
4. **Update regularly**: Keep Laravel dan dependencies up-to-date
5. **Backup database**: Export database secara berkala

## 📞 Support

Jika ada masalah:
- InfinityFree Forum: https://forum.infinityfree.net/
- InfinityFree Support: https://infinityfree.net/support

## 🎯 Alternatif Hosting Gratis Lain

Jika InfinityFree tidak sesuai, pertimbangkan:
1. **000webhost** - Support composer
2. **Heroku** - Support full Laravel deployment (free tier)
3. **Railway.app** - Modern deployment
4. **Render** - Easy Laravel deployment

---

**Catatan**: Untuk proyek production yang serius, disarankan menggunakan paid hosting yang mendukung SSH, composer, dan artisan commands.