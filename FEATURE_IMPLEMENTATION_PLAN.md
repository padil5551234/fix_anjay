# Feature Implementation Plan
**Project:** Tryout Master Application
**Date:** October 14, 2025
**Priority:** High

---

## Overview
This document outlines the implementation plan for missing features and improvements identified during testing of the Tryout Master application.

---

## Phase 1: Critical Fixes & Improvements (Immediate)

### 1.1 Fix Missing Image Assets ✅

**Issue:** Teacher photo returns 404/403 error on tutor dashboard

**Solution:**
```php
// Create default avatar placeholder
// Location: public/img/default-teacher.png
```

**Implementation:**
1. Add default avatar image to public/img/
2. Update view to use fallback image
3. Create image upload feature for tutors

### 1.2 Add Sample Data Seeder

**Purpose:** Provide demo data for testing and demonstration

**Files to Create:**
- `database/seeders/DemoDataSeeder.php`

**Data to Include:**
- 3 Sample Paket Ujian (Exam Packages)
- 10 Sample Ujian (Exams) per package
- 50 Sample questions with answers
- Sample announcements
- Sample FAQs

---

## Phase 2: User Dashboard Enhancement

### 2.1 Enhanced User Dashboard

**Current State:** Basic landing page redirect
**Target State:** Personalized user dashboard

**Features to Add:**

```php
// app/Http/Controllers/UserDashboardController.php

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        return view('user.dashboard', [
            'purchasedPackages' => $this->getPurchasedPackages($user),
            'examHistory' => $this->getExamHistory($user),
            'upcomingExams' => $this->getUpcomingExams($user),
            'recentMaterials' => $this->getRecentMaterials(),
            'progress' => $this->calculateProgress($user),
        ]);
    }
    
    private function getPurchasedPackages($user)
    {
        return $user->pembelian()
            ->with('paketUjian')
            ->where('status', 'success')
            ->latest()
            ->take(5)
            ->get();
    }
    
    private function getExamHistory($user)
    {
        return $user->ujianUser()
            ->with('ujian')
            ->where('is_first', false)
            ->latest()
            ->take(10)
            ->get();
    }
    
    private function getUpcomingExams($user)
    {
        // Get exams from purchased packages
        $packageIds = $user->pembelian()
            ->where('status', 'success')
            ->pluck('paket_id');
            
        return Ujian::whereHas('paketUjian', function($q) use ($packageIds) {
            $q->whereIn('id', $packageIds);
        })
        ->where('is_published', true)
        ->latest()
        ->take(5)
        ->get();
    }
    
    private function calculateProgress($user)
    {
        $totalExams = $this->getUpcomingExams($user)->count();
        $completedExams = $this->getExamHistory($user)->count();
        
        return [
            'total' => $totalExams,
            'completed' => $completedExams,
            'percentage' => $totalExams > 0 ? ($completedExams / $totalExams) * 100 : 0
        ];
    }
}
```

**View Structure:**
```blade
<!-- resources/views/user/dashboard.blade.php -->

<div class="container">
    <div class="row">
        <!-- Welcome Card -->
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h4>Selamat Datang, {{ auth()->user()->name }}!</h4>
                    <p>Dashboard pribadi Anda untuk mengakses tryout dan materi pembelajaran</p>
                </div>
            </div>
        </div>
        
        <!-- Statistics -->
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3>{{ $progress['completed'] }}</h3>
                    <p>Ujian Diselesaikan</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3>{{ $purchasedPackages->count() }}</h3>
                    <p>Paket Aktif</p>
                </div>
            </div>
        </div>
        
        <!-- Recent Activity -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Aktivitas Terakhir</h5>
                </div>
                <div class="card-body">
                    @foreach($examHistory as $exam)
                        <div class="activity-item">
                            <strong>{{ $exam->ujian->nama }}</strong>
                            <span class="text-muted">{{ $exam->created_at->diffForHumans() }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <!-- Upcoming Exams -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Ujian Mendatang</h5>
                </div>
                <div class="card-body">
                    @foreach($upcomingExams as $exam)
                        <div class="exam-item">
                            <h6>{{ $exam->nama }}</h6>
                            <p class="text-muted">{{ $exam->jumlah_soal }} soal - {{ $exam->lama_pengerjaan }} menit</p>
                            <a href="{{ route('ujian.index', $exam->id) }}" class="btn btn-sm btn-primary">Mulai</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
```

---

## Phase 3: Exam Enhancement Features

### 3.1 Exam Timer & Progress Indicator

**File:** `resources/views/user/ujian/show.blade.php`

```javascript
// Add real-time countdown timer
let timeRemaining = {{ $lamaWaktu }} * 60; // Convert minutes to seconds

function updateTimer() {
    const minutes = Math.floor(timeRemaining / 60);
    const seconds = timeRemaining % 60;
    
    document.getElementById('timer').innerHTML = 
        `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    
    if (timeRemaining <= 0) {
        // Auto-submit exam
        document.getElementById('exam-form').submit();
    }
    
    timeRemaining--;
}

setInterval(updateTimer, 1000);

// Progress indicator
function updateProgress() {
    const totalQuestions = {{ $totalSoal }};
    const answeredQuestions = document.querySelectorAll('input[type="radio"]:checked').length;
    const progress = (answeredQuestions / totalQuestions) * 100;
    
    document.getElementById('progress-bar').style.width = progress + '%';
    document.getElementById('progress-text').innerHTML = 
        `${answeredQuestions} dari ${totalQuestions} soal dijawab`;
}

// Call on every answer change
document.querySelectorAll('input[type="radio"]').forEach(radio => {
    radio.addEventListener('change', updateProgress);
});
```

### 3.2 Question Bookmark Feature

**Migration:**
```php
// database/migrations/xxxx_add_bookmark_to_jawaban_peserta_table.php

Schema::table('jawaban_peserta', function (Blueprint $table) {
    $table->boolean('is_bookmarked')->default(false);
});
```

**Controller Method:**
```php
// app/Http/Controllers/UjianController.php

public function toggleBookmark(Request $request)
{
    $jawabanPeserta = JawabanPeserta::where('pembelian_id', $request->pembelian_id)
        ->where('soal_id', $request->soal_id)
        ->first();
    
    if ($jawabanPeserta) {
        $jawabanPeserta->is_bookmarked = !$jawabanPeserta->is_bookmarked;
        $jawabanPeserta->save();
    }
    
    return response()->json(['success' => true]);
}
```

### 3.3 Detailed Score Analysis

**Controller Method:**
```php
// app/Http/Controllers/UjianController.php

public function detailedAnalysis($id)
{
    $pembelian = Pembelian::with(['ujian.soals.jawabanPesertas' => function($q) use ($id) {
        $q->where('pembelian_id', $id);
    }])->findOrFail($id);
    
    $analysis = [
        'total_correct' => 0,
        'total_wrong' => 0,
        'total_empty' => 0,
        'score' => 0,
        'time_spent' => 0,
        'by_category' => [],
        'by_difficulty' => [],
        'recommendations' => []
    ];
    
    foreach ($pembelian->ujian->soals as $soal) {
        $jawaban = $soal->jawabanPesertas->first();
        
        if (!$jawaban || !$jawaban->jawaban_id) {
            $analysis['total_empty']++;
        } else {
            $isCorrect = $soal->jawabans->where('id', $jawaban->jawaban_id)->where('is_correct', true)->count() > 0;
            
            if ($isCorrect) {
                $analysis['total_correct']++;
                $analysis['score'] += $soal->poin_benar;
            } else {
                $analysis['total_wrong']++;
                $analysis['score'] += $soal->poin_salah;
            }
        }
        
        // Group by category if exists
        // Group by difficulty if exists
    }
    
    return view('user.ujian.analysis', compact('pembelian', 'analysis'));
}
```

---

## Phase 4: Tutor Feature Enhancements

### 4.1 Live Class Scheduling

**Migration:**
```php
// Already exists in: database/migrations/2024_12_14_100000_create_live_classes_table.php
// Fields include: scheduled_at, duration, meeting_link, status
```

**Controller Enhancement:**
```php
// app/Http/Controllers/Tutor/LiveClassController.php

public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'scheduled_at' => 'required|date|after:now',
        'duration' => 'required|integer|min:30|max:240',
        'meeting_link' => 'required|url',
        'batch_id' => 'nullable|uuid',
        'mapel' => 'nullable|string|max:100'
    ]);
    
    $validated['tutor_id'] = auth()->id();
    $validated['status'] = 'scheduled';
    
    LiveClass::create($validated);
    
    // Send notifications to students in the batch
    $this->notifyStudents($validated['batch_id']);
    
    return redirect()->route('tutor.live-classes.index')
        ->with('success', 'Kelas live berhasil dijadwalkan');
}

public function start($id)
{
    $liveClass = LiveClass::findOrFail($id);
    $liveClass->status = 'ongoing';
    $liveClass->started_at = now();
    $liveClass->save();
    
    return redirect()->away($liveClass->meeting_link);
}

public function end($id)
{
    $liveClass = LiveClass::findOrFail($id);
    $liveClass->status = 'completed';
    $liveClass->ended_at = now();
    $liveClass->save();
    
    return redirect()->route('tutor.live-classes.index')
        ->with('success', 'Kelas live telah selesai');
}
```

### 4.2 Material Management with File Upload

**Controller:**
```php
// app/Http/Controllers/Tutor/MaterialController.php

public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'type' => 'required|in:pdf,video,document,youtube',
        'file' => 'required_if:type,pdf,document|file|max:10240', // 10MB
        'youtube_url' => 'required_if:type,youtube|url',
        'batch_id' => 'nullable|uuid',
        'mapel' => 'nullable|string|max:100',
        'is_public' => 'boolean'
    ]);
    
    $validated['tutor_id'] = auth()->id();
    
    if ($request->hasFile('file')) {
        $path = $request->file('file')->store('materials', 'public');
        $validated['file_path'] = $path;
    }
    
    Material::create($validated);
    
    return redirect()->route('tutor.materials.index')
        ->with('success', 'Materi berhasil ditambahkan');
}

public function getYouTubeInfo(Request $request)
{
    $url = $request->youtube_url;
    
    // Extract video ID from YouTube URL
    preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\?]+)/', $url, $matches);
    $videoId = $matches[1] ?? null;
    
    if ($videoId) {
        return response()->json([
            'video_id' => $videoId,
            'embed_url' => "https://www.youtube.com/embed/{$videoId}",
            'thumbnail' => "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg"
        ]);
    }
    
    return response()->json(['error' => 'Invalid YouTube URL'], 400);
}
```

### 4.3 Question Bank Management

**Controller:**
```php
// app/Http/Controllers/Tutor/BankSoalController.php

public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'category' => 'required|string|max:100',
        'difficulty' => 'required|in:easy,medium,hard',
        'file' => 'required|file|mimes:pdf,doc,docx,xlsx|max:5120'
    ]);
    
    $validated['tutor_id'] = auth()->id();
    
    if ($request->hasFile('file')) {
        $path = $request->file('file')->store('bank-soal', 'public');
        $validated['file_path'] = $path;
        $validated['file_name'] = $request->file('file')->getClientOriginalName();
    }
    
    BankSoal::create($validated);
    
    return redirect()->route('tutor.bank-soal.index')
        ->with('success', 'Soal berhasil ditambahkan ke bank soal');
}

public function importFromExcel(Request $request)
{
    $request->validate([
        'file' => 'required|file|mimes:xlsx,xls|max:5120'
    ]);
    
    // Import logic using Laravel Excel
    Excel::import(new SoalImport, $request->file('file'));
    
    return redirect()->back()
        ->with('success', 'Soal berhasil diimport dari Excel');
}
```

---

## Phase 5: Admin Analytics & Reports

### 5.1 Dashboard Statistics

**Controller:**
```php
// app/Http/Controllers/Admin/DashboardController.php

public function index()
{
    $stats = [
        'total_users' => User::role('user')->count(),
        'total_tutors' => User::role('tutor')->count(),
        'total_packages' => PaketUjian::count(),
        'total_exams' => Ujian::count(),
        'total_questions' => Soal::count(),
        'active_purchases' => Pembelian::where('status', 'success')->count(),
        'revenue' => [
            'today' => $this->getTodayRevenue(),
            'week' => $this->getWeekRevenue(),
            'month' => $this->getMonthRevenue(),
            'total' => $this->getTotalRevenue()
        ],
        'recent_purchases' => Pembelian::with('user', 'paketUjian')
            ->latest()
            ->take(10)
            ->get(),
        'popular_packages' => $this->getPopularPackages(),
        'user_growth' => $this->getUserGrowthData(),
        'exam_participation' => $this->getExamParticipation()
    ];
    
    return view('admin.dashboard', compact('stats'));
}

private function getTodayRevenue()
{
    return Pembelian::where('status', 'success')
        ->whereDate('created_at', today())
        ->sum('harga');
}

private function getPopularPackages()
{
    return PaketUjian::withCount('pembelian')
        ->orderBy('pembelian_count', 'desc')
        ->take(5)
        ->get();
}

private function getUserGrowthData()
{
    $months = [];
    $counts = [];
    
    for ($i = 11; $i >= 0; $i--) {
        $date = now()->subMonths($i);
        $months[] = $date->format('M Y');
        $counts[] = User::whereYear('created_at', $date->year)
            ->whereMonth('created_at', $date->month)
            ->count();
    }
    
    return [
        'labels' => $months,
        'data' => $counts
    ];
}
```

### 5.2 Revenue Reports

**Routes:**
```php
// routes/web.php

Route::prefix('admin')
    ->middleware(['auth', 'verified', 'role:admin'])
    ->group(function () {
        Route::get('/reports/revenue', [ReportController::class, 'revenue'])
            ->name('admin.reports.revenue');
        Route::get('/reports/users', [ReportController::class, 'users'])
            ->name('admin.reports.users');
        Route::get('/reports/exams', [ReportController::class, 'exams'])
            ->name('admin.reports.exams');
        Route::get('/reports/export/{type}', [ReportController::class, 'export'])
            ->name('admin.reports.export');
    });
```

**Controller:**
```php
// app/Http/Controllers/Admin/ReportController.php

class ReportController extends Controller
{
    public function revenue(Request $request)
    {
        $startDate = $request->start_date ?? now()->startOfMonth();
        $endDate = $request->end_date ?? now();
        
        $report = [
            'total_revenue' => Pembelian::where('status', 'success')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('harga'),
            'total_transactions' => Pembelian::where('status', 'success')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count(),
            'by_payment_method' => $this->getRevenueByPaymentMethod($startDate, $endDate),
            'by_package' => $this->getRevenueByPackage($startDate, $endDate),
            'daily_revenue' => $this->getDailyRevenue($startDate, $endDate)
        ];
        
        return view('admin.reports.revenue', compact('report', 'startDate', 'endDate'));
    }
    
    public function export($type)
    {
        switch ($type) {
            case 'revenue':
                return Excel::download(new RevenueExport, 'revenue-report.xlsx');
            case 'users':
                return Excel::download(new UsersExport, 'users-report.xlsx');
            case 'exams':
                return Excel::download(new ExamsExport, 'exams-report.xlsx');
        }
    }
}
```

---

## Phase 6: Security & Performance

### 6.1 Rate Limiting

**File:** `app/Http/Kernel.php`

```php
protected $middlewareGroups = [
    'web' => [
        // ... existing middleware
        \Illuminate\Routing\Middleware\ThrottleRequests::class.':web',
    ],
];

protected $middlewareAliases = [
    // ... existing aliases
    'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
];
```

**Routes:**
```php
Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1'); // 5 attempts per minute

Route::post('/register', [AuthController::class, 'register'])
    ->middleware('throttle:3,1'); // 3 attempts per minute
```

### 6.2 Activity Logging

**Migration:**
```php
// database/migrations/xxxx_create_activity_log_table.php

Schema::create('activity_log', function (Blueprint $table) {
    $table->id();
    $table->uuid('user_id');
    $table->string('action');
    $table->string('model_type')->nullable();
    $table->unsignedBigInteger('model_id')->nullable();
    $table->text('description')->nullable();
    $table->json('properties')->nullable();
    $table->string('ip_address', 45)->nullable();
    $table->text('user_agent')->nullable();
    $table->timestamps();
    
    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    $table->index(['user_id', 'created_at']);
});
```

**Model:**
```php
// app/Models/ActivityLog.php

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id', 'action', 'model_type', 'model_id',
        'description', 'properties', 'ip_address', 'user_agent'
    ];
    
    protected $casts = [
        'properties' => 'array'
    ];
    
    public static function log($action, $description, $model = null)
    {
        return self::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'model_type' => $model ? get_class($model) : null,
            'model_id' => $model?->id,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);
    }
}
```

### 6.3 Caching Strategy

**Config:** `config/cache.php`

```php
// Implement caching for frequently accessed data

// Cache package list
Cache::remember('packages.all', 3600, function () {
    return PaketUjian::with('ujians')->where('is_active', true)->get();
});

// Cache user statistics
Cache::remember("user.{$userId}.stats", 1800, function () use ($userId) {
    return [
        'total_exams' => UjianUser::where('user_id', $userId)->count(),
        'average_score' => UjianUser::where('user_id', $userId)->avg('score'),
        'packages_owned' => Pembelian::where('user_id', $userId)->count()
    ];
});

// Cache exam questions
Cache::remember("exam.{$examId}.questions", 3600, function () use ($examId) {
    return Soal::where('ujian_id', $examId)
        ->with('jawabans')
        ->get();
});
```

---

## Implementation Timeline

| Phase | Duration | Priority | Status |
|-------|----------|----------|--------|
| Phase 1: Critical Fixes | 1-2 days | High | 🔄 In Progress |
| Phase 2: User Dashboard | 3-5 days | High | ⏳ Pending |
| Phase 3: Exam Enhancements | 5-7 days | Medium | ⏳ Pending |
| Phase 4: Tutor Features | 5-7 days | Medium | ⏳ Pending |
| Phase 5: Admin Analytics | 3-5 days | Medium | ⏳ Pending |
| Phase 6: Security & Performance | 2-3 days | High | ⏳ Pending |

**Total Estimated Time:** 3-4 weeks

---

## Success Criteria

- ✅ All user roles can access their dashboards without errors
- ✅ Exam system includes timer, progress tracking, and bookmarks
- ✅ Tutors can create and manage live classes
- ✅ Tutors can upload and manage materials
- ✅ Admin can view comprehensive analytics
- ✅ System has proper security measures (rate limiting, logging)
- ✅ Application performance is optimized with caching
- ✅ All features are tested and bug-free

---

## Next Steps

1. ✅ Review and approve implementation plan
2. ⏳ Begin Phase 1 implementations
3. ⏳ Create unit and feature tests
4. ⏳ Deploy to staging environment
5. ⏳ User acceptance testing
6. ⏳ Production deployment

---

**Document Version:** 1.0
**Last Updated:** October 14, 2025
**Status:** Ready for Implementation