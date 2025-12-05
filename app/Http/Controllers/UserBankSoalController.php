<?php

namespace App\Http\Controllers;

use App\Models\BankSoal;
use App\Models\Pembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserBankSoalController extends Controller
{
    /**
     * Display a listing of bank soal
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $query = BankSoal::query();
        
        // Testing Mode: Show all bank soal
        if (env('TESTING_MODE', false)) {
            // In testing mode, show all available bank soal
            // No package restriction
        } else {
            // Production Mode: Check purchased packages
            $purchasedPackages = Pembelian::where('user_id', $user->id)
                ->where('status', 'Sukses')
                ->with('paketUjian')
                ->get()
                ->pluck('paketUjian')
                ->filter();

            // Only show bank soal from purchased packages
            if ($purchasedPackages->isNotEmpty()) {
                $packageIds = $purchasedPackages->pluck('id');
                $query->whereIn('batch_id', $packageIds);
            } else {
                // If no purchased packages, show empty result
                $query->whereRaw('1 = 0');
            }
        }

        // Filter by mapel
        if ($request->has('mapel') && !empty($request->mapel)) {
            $query->where('mapel', 'like', '%' . $request->mapel . '%');
        }

        // Search by nama
        if ($request->has('search') && !empty($request->search)) {
            $query->where('nama_banksoal', 'like', '%' . $request->search . '%');
        }

        $bankSoals = $query->with(['batch', 'tentor'])
            ->orderBy('tanggal_upload', 'desc')
            ->paginate(12);

        // Get purchased packages and subjects
        if (env('TESTING_MODE', false)) {
            $purchasedPackages = collect();
            $subjects = BankSoal::distinct()->pluck('mapel')->filter();
        } else {
            $purchasedPackages = Pembelian::where('user_id', $user->id)
                ->where('status', 'Sukses')
                ->with('paketUjian')
                ->get()
                ->pluck('paketUjian')
                ->filter();
            
            $subjects = BankSoal::whereIn('batch_id', $purchasedPackages->pluck('id'))
                ->distinct()
                ->pluck('mapel')
                ->filter();
        }

        return view('bank_soal.index', compact('bankSoals', 'purchasedPackages', 'subjects'));
    }

    /**
     * Display the specified bank soal
     */
    public function show(BankSoal $bankSoal)
    {
        $user = Auth::user();
        
        // Testing Mode: Bypass access check
        if (!env('TESTING_MODE', false)) {
            // Production Mode: Check if user has access
            $hasAccess = Pembelian::where('user_id', $user->id)
                ->where('paket_id', $bankSoal->batch_id)
                ->where('status', 'Sukses')
                ->exists();
            
            if (!$hasAccess) {
                abort(403, 'Anda tidak memiliki akses ke bank soal ini. Silakan beli paket terlebih dahulu.');
            }
        }

        return view('bank_soal.show', compact('bankSoal'));
    }

    /**
     * Download bank soal file
     */
    public function download(BankSoal $bankSoal)
    {
        $user = Auth::user();
        
        // Testing Mode: Bypass access check
        if (!env('TESTING_MODE', false)) {
            // Production Mode: Check if user has access
            $hasAccess = Pembelian::where('user_id', $user->id)
                ->where('paket_id', $bankSoal->batch_id)
                ->where('status', 'Sukses')
                ->exists();
            
            if (!$hasAccess) {
                abort(403, 'Anda tidak memiliki akses untuk mengunduh bank soal ini.');
            }
        }

        // Check if file exists
        if (!$bankSoal->file_banksoal || !Storage::disk('public')->exists($bankSoal->file_banksoal)) {
            abort(404, 'File bank soal tidak ditemukan.');
        }

        return response()->download(
            storage_path('app/public/' . $bankSoal->file_banksoal),
            $bankSoal->nama_banksoal . '.' . pathinfo($bankSoal->file_banksoal, PATHINFO_EXTENSION)
        );
    }
}