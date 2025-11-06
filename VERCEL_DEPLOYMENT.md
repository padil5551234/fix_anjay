# Panduan Deploy ke Vercel

## Persiapan

### 1. Install Dependencies
```bash
npm install
```

### 2. Build Assets
```bash
npm run build
```

## Deploy ke Vercel

### Opsi 1: Deploy via Vercel CLI

1. Install Vercel CLI:
```bash
npm install -g vercel
```

2. Login ke Vercel:
```bash
vercel login
```

3. Deploy:
```bash
vercel
```

4. Untuk production:
```bash
vercel --prod
```

### Opsi 2: Deploy via GitHub

1. Push kode ke GitHub repository
2. Login ke [Vercel Dashboard](https://vercel.com)
3. Import repository dari GitHub
4. Vercel akan otomatis mendeteksi konfigurasi dari `vercel.json`
5. Deploy akan berjalan otomatis

## Environment Variables

Setelah deploy, tambahkan environment variables di Vercel Dashboard:

### Required Variables:
```
APP_NAME=Tryout
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.vercel.app
APP_KEY=base64:your-app-key-here

DB_CONNECTION=mysql
DB_HOST=your-database-host
DB_PORT=3306
DB_DATABASE=your-database-name
DB_USERNAME=your-database-user
DB_PASSWORD=your-database-password

SESSION_DRIVER=database
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
```

### Generate APP_KEY:
```bash
php artisan key:generate --show
```

## Database Setup

Untuk Vercel, gunakan database eksternal:
- **PlanetScale** (MySQL gratis)
- **Railway** (PostgreSQL/MySQL)
- **Supabase** (PostgreSQL gratis)
- **AWS RDS** (berbayar)

## File Storage

Untuk file upload, gunakan:
- **Cloudinary** (gratis untuk basic)
- **AWS S3** (berbayar)
- **Vercel Blob** (berbayar)

Update `.env`:
```
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your-key
AWS_SECRET_ACCESS_KEY=your-secret
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your-bucket-name
```

## Troubleshooting

### Error: "Route not found"
- Pastikan file `api/index.php` ada
- Check `vercel.json` routing configuration

### Error: "Permission denied"
- Pastikan folder `storage` dan `bootstrap/cache` ada
- Check `.gitkeep` files di dalam folder tersebut

### Error: Build failed
- Jalankan `npm run build` lokal dulu untuk test
- Pastikan semua dependencies terpasang

### Error: Database connection
- Pastikan database eksternal sudah setup
- Verify environment variables di Vercel Dashboard

## Update Aplikasi

### Via GitHub (Recommended):
1. Push perubahan ke GitHub repository
```bash
git add .
git commit -m "Update: description"
git push origin main
```
2. Vercel akan otomatis rebuild dan deploy

### Via Vercel CLI:
```bash
vercel --prod
```

## Struktur File Penting

```
tryout-master/
├── api/
│   └── index.php           # Entry point untuk Vercel
├── public/
│   └── build/              # Built assets dari Vite
├── storage/
│   └── framework/
│       ├── cache/.gitkeep
│       ├── sessions/.gitkeep
│       └── views/.gitkeep
├── .gitignore
├── .vercelignore
├── vercel.json            # Konfigurasi Vercel
├── package.json
└── tailwind.config.js
```

## Tips Optimasi

1. **Caching**: Enable edge caching di Vercel
2. **CDN**: Assets otomatis di-serve via Vercel CDN
3. **Monitoring**: Gunakan Vercel Analytics
4. **Logs**: Check di Vercel Dashboard → Functions → Logs

## Support

Untuk masalah deployment:
- [Vercel Documentation](https://vercel.com/docs)
- [Laravel on Vercel Guide](https://vercel.com/guides/deploying-laravel)