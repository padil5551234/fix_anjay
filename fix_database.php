<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

try {
    // Check if paket_id column exists
    if (!Schema::hasColumn('pembelian', 'paket_id')) {
        echo "Adding paket_id column to pembelian table...\n";
        
        Schema::table('pembelian', function (Blueprint $table) {
            // Add paket_id column
            $table->string('paket_id')->nullable()->after('id');
        });
        
        echo "Column paket_id added successfully.\n";
    } else {
        echo "Column paket_id already exists.\n";
    }
    
    // Check if ujian_id column exists and drop it if paket_id exists
    if (Schema::hasColumn('pembelian', 'ujian_id') && Schema::hasColumn('pembelian', 'paket_id')) {
        echo "Dropping ujian_id column...\n";
        
        Schema::table('pembelian', function (Blueprint $table) {
            $table->dropColumn('ujian_id');
        });
        
        echo "Column ujian_id dropped successfully.\n";
    }
    
    echo "Database fix completed.\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}