<?php

/**
 * Test script untuk simulasi flow ujian lengkap
 * Jalankan dengan: php test_ujian_flow.php
 */

require __DIR__.'/vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use App\Models\Ujian;
use App\Models\Soal;
use App\Models\UjianUser;
use App\Models\JawabanPeserta;
use App\Models\PaketUjian;
use App\Models\Pembelian;
use Carbon\Carbon;

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=================================================\n";
echo "TESTING UJIAN FLOW SIMULATION\n";
echo "=================================================\n\n";

// Get test user (admin)
$user = DB::table('users')->first();
if (!$user) {
    echo "❌ ERROR: No user found!\n";
    exit(1);
}

echo "Testing as: {$user->name} (ID: {$user->id})\n\n";

// STEP 1: Test index() method - Viewing available tryouts
echo "STEP 1: Testing UjianController@index (View Tryouts)\n";
echo "-------------------------------------------------\n";

$testingMode = env('TESTING_MODE', false);
echo "TESTING_MODE: " . ($testingMode ? 'ENABLED' : 'DISABLED') . "\n\n";

if ($testingMode) {
    echo "Mode: TESTING (Bypass payment)\n";
    $paketUjian = PaketUjian::with([
        'ujian' => function ($query) {
            $query->where('isPublished', 1)->orderBy('nama', 'asc');
        }
    ])->get();
    
    $tryoutCount = 0;
    foreach ($paketUjian as $paket) {
        $tryoutCount += $paket->ujian->count();
        echo "  Paket: {$paket->nama} - Ujian: {$paket->ujian->count()}\n";
        foreach ($paket->ujian as $ujian) {
            echo "    - {$ujian->nama} (ID: {$ujian->id})\n";
        }
    }
    echo "\n✓ Total tryouts available: {$tryoutCount}\n";
} else {
    echo "Mode: PRODUCTION (Payment required)\n";
    $pembelian = Pembelian::with(['paketUjian.ujian'])
        ->where('user_id', $user->id)
        ->where('status', 'Sukses')
        ->get();
    
    echo "  User purchases: {$pembelian->count()}\n";
    
    if ($pembelian->count() == 0) {
        echo "❌ ERROR: User has no successful purchases!\n";
        echo "  Solution: Either enable TESTING_MODE or create a successful purchase\n";
        exit(1);
    }
    
    $tryoutCount = 0;
    foreach ($pembelian as $p) {
        if ($p->paketUjian) {
            $tryoutCount += $p->paketUjian->ujian->count();
            echo "  Paket: {$p->paketUjian->nama} - Ujian: {$p->paketUjian->ujian->count()}\n";
        }
    }
    echo "\n✓ Total tryouts available: {$tryoutCount}\n";
}

// STEP 2: Test show() method - View specific ujian detail
echo "\n\nSTEP 2: Testing UjianController@show (View Ujian Detail)\n";
echo "-------------------------------------------------\n";

$ujian = Ujian::where('isPublished', 1)->first();
if (!$ujian) {
    echo "❌ ERROR: No published ujian found!\n";
    exit(1);
}

echo "Testing with Ujian: {$ujian->nama} (ID: {$ujian->id})\n";
echo "  Waktu Mulai: {$ujian->waktu_mulai}\n";
echo "  Waktu Akhir: {$ujian->waktu_akhir}\n";

$betweenTime = Carbon::now()->between($ujian->waktu_mulai, $ujian->waktu_akhir);
echo "  Is Between Time: " . ($betweenTime ? 'YES' : 'NO') . "\n";

if (!$betweenTime) {
    echo "⚠ WARNING: Ujian is not in active time window!\n";
    echo "  Current time: " . Carbon::now() . "\n";
}

// Check payment/access
if ($testingMode) {
    echo "✓ Access granted (Testing mode)\n";
} else {
    $hasAccess = PaketUjian::whereHas('ujian', function($q) use ($ujian) {
        $q->where('ujian.id', $ujian->id);
    })->whereHas('pembelian', function ($query) use ($user) {
        $query->where('user_id', $user->id)->where('status', 'Sukses');
    })->exists();
    
    if ($hasAccess) {
        echo "✓ Access granted (Valid purchase)\n";
    } else {
        echo "❌ ERROR: User doesn't have access to this ujian!\n";
        exit(1);
    }
}

// STEP 3: Test mulaiUjian() method - Starting the exam
echo "\n\nSTEP 3: Testing UjianController@mulaiUjian (Start Exam)\n";
echo "-------------------------------------------------\n";

// Check existing UjianUser
$existingUjianUser = UjianUser::where('ujian_id', $ujian->id)
    ->where('user_id', $user->id)
    ->latest()
    ->first();

if ($existingUjianUser) {
    echo "⚠ UjianUser already exists (ID: {$existingUjianUser->id})\n";
    echo "  Status: {$existingUjianUser->status} (0=not started, 1=in progress, 2=finished)\n";
    
    if ($existingUjianUser->status == 2 && $ujian->tipe_ujian == 1) {
        echo "❌ ERROR: Cannot retake - tipe_ujian=1 (single attempt only)\n";
        exit(1);
    }
} else {
    echo "Creating new UjianUser...\n";
    
    // Simulate soal generation
    echo "\nChecking soal generation:\n";
    if ($ujian->jenis_ujian == 'skd') {
        $twk = Soal::where('ujian_id', $ujian->id)->where('jenis_soal', 'twk')->limit(30)->get();
        $tiu = Soal::where('ujian_id', $ujian->id)->where('jenis_soal', 'tiu')->limit(35)->get();
        $tkp = Soal::where('ujian_id', $ujian->id)->where('jenis_soal', 'tkp')->limit(45)->get();
        
        echo "  TWK: {$twk->count()} / 30 required\n";
        echo "  TIU: {$tiu->count()} / 35 required\n";
        echo "  TKP: {$tkp->count()} / 45 required\n";
        
        if ($twk->count() < 30 || $tiu->count() < 35 || $tkp->count() < 45) {
            echo "❌ ERROR: Insufficient soal for SKD ujian!\n";
            exit(1);
        }
        
        $allSoal = collect()->merge($twk)->merge($tiu)->merge($tkp);
    } else {
        $allSoal = Soal::where('ujian_id', $ujian->id)->limit($ujian->jumlah_soal)->get();
        echo "  Total soal: {$allSoal->count()} / {$ujian->jumlah_soal} required\n";
        
        if ($allSoal->count() < $ujian->jumlah_soal) {
            echo "❌ ERROR: Insufficient soal! Only {$allSoal->count()} available, need {$ujian->jumlah_soal}\n";
            exit(1);
        }
    }
    
    echo "✓ Soal generation check passed ({$allSoal->count()} soal)\n";
    
    // Create test UjianUser
    $ujianUser = UjianUser::create([
        'ujian_id' => $ujian->id,
        'user_id' => $user->id,
        'status' => 1,
        'is_first' => 1,
        'waktu_mulai' => Carbon::now(),
        'waktu_akhir' => Carbon::now()->addMinutes($ujian->lama_pengerjaan),
    ]);
    
    echo "✓ UjianUser created (ID: {$ujianUser->id})\n";
    
    // Create JawabanPeserta
    $jawabanPesertaCreated = 0;
    foreach ($allSoal as $soal) {
        JawabanPeserta::create([
            'ujian_user_id' => $ujianUser->id,
            'soal_id' => $soal->id,
            'poin' => $soal->poin_kosong,
        ]);
        $jawabanPesertaCreated++;
    }
    
    echo "✓ Created {$jawabanPesertaCreated} JawabanPeserta records\n";
}

// STEP 4: Test ujian() method - Display exam page
echo "\n\nSTEP 4: Testing UjianController@ujian (Display Exam)\n";
echo "-------------------------------------------------\n";

$ujianUser = UjianUser::with('ujian')->where('ujian_id', $ujian->id)
    ->where('user_id', $user->id)
    ->latest()
    ->first();

if (!$ujianUser) {
    echo "❌ ERROR: UjianUser not found!\n";
    exit(1);
}

echo "UjianUser ID: {$ujianUser->id}\n";
echo "Status: {$ujianUser->status}\n";

if ($ujianUser->status == 2) {
    echo "❌ ERROR: Ujian already finished!\n";
    exit(1);
}

// Test the query from ujian() method
$jawabanPesertaQuery = JawabanPeserta::with([
    'soal', 
    'soal.jawaban' => function ($q) use ($ujianUser) {
        if ($ujianUser->ujian->random_pilihan == 1) {
            $q->inRandomOrder();
        }
    }, 
    'soal.ujian'
])->where('ujian_user_id', $ujianUser->id);

$totalJawabanPeserta = $jawabanPesertaQuery->count();
echo "Total JawabanPeserta: {$totalJawabanPeserta}\n";

if ($totalJawabanPeserta == 0) {
    echo "❌ ERROR: No JawabanPeserta found! Soal generation failed!\n";
    exit(1);
}

// Test pagination (simulating first page)
$soalPaginated = $jawabanPesertaQuery->paginate(1, ['*'], 'no');

echo "Paginated result:\n";
echo "  Total: {$soalPaginated->total()}\n";
echo "  Per Page: {$soalPaginated->perPage()}\n";
echo "  Current Page: {$soalPaginated->currentPage()}\n";

if ($soalPaginated->count() == 0) {
    echo "❌ ERROR: Pagination returned empty result!\n";
    exit(1);
}

echo "\nChecking first soal data:\n";
$firstJawabanPeserta = $soalPaginated->first();

if (!$firstJawabanPeserta) {
    echo "❌ ERROR: First JawabanPeserta is null!\n";
    exit(1);
}

echo "  JawabanPeserta ID: {$firstJawabanPeserta->id}\n";

if (!$firstJawabanPeserta->soal) {
    echo "❌ ERROR: Soal relationship is null!\n";
    echo "  This is the main issue - JawabanPeserta->soal is not loading!\n";
    exit(1);
}

echo "  Soal ID: {$firstJawabanPeserta->soal->id}\n";
echo "  Soal text: " . substr(strip_tags($firstJawabanPeserta->soal->soal), 0, 50) . "...\n";

if (!$firstJawabanPeserta->soal->ujian) {
    echo "❌ ERROR: Soal->ujian relationship is null!\n";
    exit(1);
}

echo "  Ujian: {$firstJawabanPeserta->soal->ujian->nama}\n";

$jawabanCount = $firstJawabanPeserta->soal->jawaban->count();
echo "  Jawaban count: {$jawabanCount}\n";

if ($jawabanCount == 0) {
    echo "❌ ERROR: No jawaban options for this soal!\n";
    exit(1);
}

echo "✓ All relationships loaded correctly\n";

// STEP 5: Success Summary
echo "\n\n=================================================\n";
echo "SUCCESS SUMMARY\n";
echo "=================================================\n";
echo "✅ All tests passed!\n";
echo "✅ Ujian flow is working correctly\n";
echo "\nIf you still see errors in the web interface:\n";
echo "1. Check browser console for JavaScript errors\n";
echo "2. Check network tab for failed AJAX requests\n";
echo "3. Verify session/authentication is working\n";
echo "4. Check that Alpine.js is loaded properly\n";
echo "\nTest UjianUser ID: {$ujianUser->id}\n";
echo "You can access the ujian at: /ujian/{$ujianUser->id}\n";
echo "=================================================\n";