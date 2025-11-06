<?php

/**
 * Test script untuk diagnosa error tryout
 * Jalankan dengan: php test_tryout_error.php
 */

require __DIR__.'/vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use App\Models\Ujian;
use App\Models\Soal;
use App\Models\UjianUser;
use App\Models\JawabanPeserta;
use App\Models\PaketUjian;

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=================================================\n";
echo "TESTING TRYOUT ERROR DIAGNOSIS\n";
echo "=================================================\n\n";

// Test 1: Check Ujian Records
echo "TEST 1: Checking Ujian Records\n";
echo "-------------------------------------------------\n";
$ujianCount = Ujian::count();
echo "Total Ujian: {$ujianCount}\n";

if ($ujianCount > 0) {
    $ujian = Ujian::where('isPublished', 1)->first();
    if ($ujian) {
        echo "Sample Published Ujian:\n";
        echo "  - ID: {$ujian->id}\n";
        echo "  - Nama: {$ujian->nama}\n";
        echo "  - Published: " . ($ujian->isPublished ? 'YES' : 'NO') . "\n";
        echo "  - Jumlah Soal Expected: {$ujian->jumlah_soal}\n";
        
        // Test 2: Check Soal for this Ujian
        echo "\nTEST 2: Checking Soal Records for Ujian ID {$ujian->id}\n";
        echo "-------------------------------------------------\n";
        $soalCount = Soal::where('ujian_id', $ujian->id)->count();
        echo "Total Soal for this Ujian: {$soalCount}\n";
        
        if ($soalCount == 0) {
            echo "❌ ERROR: No soal found for this ujian!\n";
            echo "  This is the main issue - ujian has no questions!\n";
        } else {
            echo "✓ Soal exists\n";
            
            // Check if soal has jawaban
            $soal = Soal::where('ujian_id', $ujian->id)->first();
            $jawabanCount = $soal->jawaban()->count();
            echo "  Sample Soal ID: {$soal->id}\n";
            echo "  Jawaban count: {$jawabanCount}\n";
            
            if ($jawabanCount == 0) {
                echo "❌ ERROR: Soal has no jawaban (answer options)!\n";
            } else {
                echo "✓ Jawaban exists\n";
            }
        }
        
        // Test 3: Check Paket Ujian
        echo "\nTEST 3: Checking Paket Ujian\n";
        echo "-------------------------------------------------\n";
        $paketUjian = PaketUjian::whereHas('ujian', function($q) use ($ujian) {
            $q->where('ujian.id', $ujian->id);
        })->first();
        
        if ($paketUjian) {
            echo "✓ Paket Ujian found: {$paketUjian->nama}\n";
            echo "  Paket ID: {$paketUjian->id}\n";
        } else {
            echo "❌ ERROR: Ujian is not linked to any PaketUjian!\n";
        }
        
        // Test 4: Simulate User Starting Ujian
        echo "\nTEST 4: Simulating User Starting Ujian\n";
        echo "-------------------------------------------------\n";
        
        // Get first user (biasanya admin)
        $user = DB::table('users')->first();
        if ($user) {
            echo "Testing with User: {$user->name} (ID: {$user->id})\n";
            
            // Check if UjianUser exists
            $ujianUser = UjianUser::where('ujian_id', $ujian->id)
                ->where('user_id', $user->id)
                ->first();
            
            if ($ujianUser) {
                echo "✓ UjianUser record found (ID: {$ujianUser->id})\n";
                echo "  Status: {$ujianUser->status}\n";
                
                // Test 5: Check JawabanPeserta
                echo "\nTEST 5: Checking JawabanPeserta Records\n";
                echo "-------------------------------------------------\n";
                $jawabanPesertaCount = JawabanPeserta::where('ujian_user_id', $ujianUser->id)->count();
                echo "Total JawabanPeserta: {$jawabanPesertaCount}\n";
                
                if ($jawabanPesertaCount == 0) {
                    echo "❌ ERROR: No JawabanPeserta records generated!\n";
                    echo "  This means the soal generation failed in mulaiUjian method\n";
                } else {
                    echo "✓ JawabanPeserta records exist\n";
                    
                    // Check if JawabanPeserta has soal relationship
                    $jawabanPeserta = JawabanPeserta::with('soal')->where('ujian_user_id', $ujianUser->id)->first();
                    if ($jawabanPeserta && $jawabanPeserta->soal) {
                        echo "✓ JawabanPeserta has soal relationship\n";
                        
                        if ($jawabanPeserta->soal->ujian) {
                            echo "✓ Soal has ujian relationship\n";
                            echo "\n✅ ALL CHECKS PASSED - Tryout should work!\n";
                        } else {
                            echo "❌ ERROR: Soal missing ujian relationship!\n";
                        }
                    } else {
                        echo "❌ ERROR: JawabanPeserta missing soal relationship!\n";
                    }
                }
            } else {
                echo "⚠ No UjianUser record found - User hasn't started this ujian yet\n";
            }
        } else {
            echo "❌ ERROR: No users found in database!\n";
        }
        
    } else {
        echo "❌ ERROR: No published ujian found!\n";
    }
} else {
    echo "❌ ERROR: No ujian records in database!\n";
}

// Test 6: Check Database Structure
echo "\n\nTEST 6: Database Structure Validation\n";
echo "-------------------------------------------------\n";

$tables = ['ujian', 'soal', 'jawaban', 'paket_ujian', 'ujian_user', 'jawaban_peserta'];
foreach ($tables as $table) {
    $exists = DB::getSchemaBuilder()->hasTable($table);
    echo ($exists ? '✓' : '❌') . " Table '{$table}': " . ($exists ? 'EXISTS' : 'MISSING') . "\n";
}

// Summary
echo "\n\n=================================================\n";
echo "DIAGNOSIS SUMMARY\n";
echo "=================================================\n";

$issues = [];

if ($ujianCount == 0) {
    $issues[] = "No ujian records in database";
}

if (isset($soalCount) && $soalCount == 0) {
    $issues[] = "Ujian exists but has no soal (questions)";
}

if (isset($jawabanCount) && $jawabanCount == 0) {
    $issues[] = "Soal exists but has no jawaban (answer options)";
}

if (!isset($paketUjian)) {
    $issues[] = "Ujian not linked to PaketUjian";
}

if (isset($jawabanPesertaCount) && $jawabanPesertaCount == 0 && isset($ujianUser)) {
    $issues[] = "JawabanPeserta not generated when user started ujian";
}

if (count($issues) > 0) {
    echo "\n⚠ ISSUES FOUND:\n";
    foreach ($issues as $i => $issue) {
        echo ($i + 1) . ". {$issue}\n";
    }
    
    echo "\n📝 RECOMMENDED SOLUTIONS:\n";
    if (in_array("No ujian records in database", $issues)) {
        echo "- Run seeder: php artisan db:seed\n";
    }
    if (in_array("Ujian exists but has no soal (questions)", $issues)) {
        echo "- Add soal through admin panel or run soal seeder\n";
        echo "- Check if bulk import soal feature is working\n";
    }
    if (in_array("Soal exists but has no jawaban (answer options)", $issues)) {
        echo "- Each soal must have jawaban records (A, B, C, D, E options)\n";
        echo "- Check soal creation/import process\n";
    }
    if (in_array("Ujian not linked to PaketUjian", $issues)) {
        echo "- Link ujian to paket through paket_ujian_ujian pivot table\n";
        echo "- Or run: php artisan db:seed --class=LinkUjianToPaketSeeder\n";
    }
} else {
    echo "✅ No critical issues found!\n";
    echo "If you still experience errors, check the Laravel logs:\n";
    echo "storage/logs/laravel.log\n";
}

echo "\n=================================================\n";