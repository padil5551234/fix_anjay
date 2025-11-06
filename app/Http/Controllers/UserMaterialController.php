<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\PaketUjian;
use App\Models\Pembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserMaterialController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Display user's purchased materials
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Get user's purchased packages with verified payment only
        $purchasedPackages = Pembelian::forUser($user->id)
            ->verified()
            ->with('paketUjian')
            ->get()
            ->pluck('paketUjian')
            ->filter();

        $query = Material::query();

        // Filter materials by purchased packages or public materials
        $query->where(function($q) use ($purchasedPackages) {
            $q->where('is_public', true);
            
            if ($purchasedPackages->isNotEmpty()) {
                $packageIds = $purchasedPackages->pluck('id');
                $q->orWhereIn('batch_id', $packageIds);
            }
        });

        // Filter by type
        if ($request->has('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        // Filter by package
        if ($request->has('package') && $request->package !== 'all') {
            $query->where('batch_id', $request->package);
        }

        // Filter by mapel
        if ($request->has('mapel') && !empty($request->mapel)) {
            $query->where('mapel', 'like', '%' . $request->mapel . '%');
        }

        // Search by title
        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $materials = $query->with(['tutor', 'batch'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('views_user.materials.index', compact('materials', 'purchasedPackages'));
    }

    /**
     * Display the specified material
     */
    public function show(Material $material)
    {
        $user = Auth::user();
        
        // Check if user has purchased access to this material
        $hasFullAccess = false;
        $isPreviewMode = false;
        
        if ($material->is_public) {
            $hasFullAccess = true;
        } else {
            $hasFullAccess = Pembelian::forUser($user->id)
                ->forPackage($material->batch_id)
                ->verified()
                ->exists();
            
            // If no access, show preview mode
            if (!$hasFullAccess) {
                $isPreviewMode = true;
            }
        }

        // Increment views
        $material->incrementViews();

        return view('views_user.materials.show', compact('material', 'hasFullAccess', 'isPreviewMode'));
    }

    /**
     * Download material file
     */
    public function download(Material $material)
    {
        $user = Auth::user();
        
        // Check if material is downloadable
        if (!$material->isDownloadable()) {
            abort(404, 'Material tidak dapat diunduh.');
        }

        // Check if user has verified access
        if (!$material->is_public) {
            $hasAccess = Pembelian::forUser($user->id)
                ->forPackage($material->batch_id)
                ->verified()
                ->exists();
            
            if (!$hasAccess) {
                abort(403, 'Anda tidak memiliki akses untuk mengunduh materi ini. Pastikan pembayaran paket sudah diverifikasi.');
            }
        }

        // Increment downloads
        $material->incrementDownloads();

        return response()->download(
            storage_path('app/public/' . $material->file_path),
            $material->title . '.' . pathinfo($material->file_path, PATHINFO_EXTENSION)
        );
    }

    /**
     * Get materials by package (for API/AJAX)
     */
    public function getMaterialsByPackage($packageId)
    {
        $user = Auth::user();
        
        // Check if user has purchased this package with verified payment
        $hasPurchased = Pembelian::forUser($user->id)
            ->forPackage($packageId)
            ->verified()
            ->exists();

        if (!$hasPurchased) {
            return response()->json(['error' => 'Anda belum membeli paket ini atau pembayaran belum diverifikasi'], 403);
        }

        $materials = Material::where('batch_id', $packageId)
            ->with('tutor')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['materials' => $materials]);
    }
}