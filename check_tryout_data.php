<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Cek Data Tryout ===\n\n";

echo "Jumlah Paket Ujian: " . \App\Models\PaketUjian::count() . "\n";
echo "Jumlah Ujian Total: " . \App\Models\Ujian::count() . "\n";
echo "Jumlah Ujian Published: " . \App\Models\Ujian::where('isPublished', 1)->count() . "\n\n";

echo "=== Daftar Ujian Published ===\n";
$ujians = \App\Models\Ujian::where('isPublished', 1)->with('paketUjian')->get();
foreach ($ujians as $ujian) {
    echo "- " . $ujian->nama . " | ID: " . $ujian->id . "\n";
    echo "  Paket: ";
    if ($ujian->paketUjian->count() > 0) {
        foreach ($ujian->paketUjian as $paket) {
            echo $paket->nama . " (ID: " . $paket->id . "), ";
        }
        echo "\n";
    } else {
        echo "TIDAK ADA PAKET!\n";
    }
    echo "\n";
}

echo "\n=== Daftar Paket Ujian ===\n";
$pakets = \App\Models\PaketUjian::with('ujian')->get();
foreach ($pakets as $paket) {
    echo "- " . $paket->nama . " | ID: " . $paket->id . "\n";
    echo "  Ujian: " . $paket->ujian->count() . " ujian\n";
    foreach ($paket->ujian as $u) {
        echo "    * " . $u->nama . " (Published: " . ($u->isPublished ? 'Ya' : 'Tidak') . ")\n";
    }
    echo "\n";
}

echo "\n=== Test Query dari Controller ===\n";
$paketQuery = \App\Models\PaketUjian::with([
    'ujian' => function ($query) {
        $query->where('isPublished', 1)->orderBy('nama', 'asc');
    }
]);
$paketUjian = $paketQuery->get();

echo "Jumlah Paket: " . $paketUjian->count() . "\n";
foreach ($paketUjian as $paket) {
    echo "- Paket: " . $paket->nama . "\n";
    echo "  Ujian yang published: " . $paket->ujian->count() . "\n";
    foreach ($paket->ujian as $ujian) {
        echo "    * " . $ujian->nama . "\n";
    }
}