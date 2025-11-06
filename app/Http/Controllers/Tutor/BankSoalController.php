<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\BankSoal;
use App\Models\PaketUjian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BankSoalController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'role:tutor']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = BankSoal::where('tentor_id', Auth::id());

        // Filter by batch
        if ($request->has('batch_id') && !empty($request->batch_id)) {
            $query->where('batch_id', $request->batch_id);
        }

        // Filter by mapel
        if ($request->has('mapel') && !empty($request->mapel)) {
            $query->where('mapel', $request->mapel);
        }

        // Search by name
        if ($request->has('search') && !empty($request->search)) {
            $query->where('nama_banksoal', 'like', '%' . $request->search . '%');
        }

        $bankSoal = $query->with('batch')->orderBy('tanggal_upload', 'desc')->paginate(10);
        $batches = PaketUjian::all();

        return view('tutor.bank_soal.index', compact('bankSoal', 'batches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $batches = PaketUjian::all();
        return view('tutor.bank_soal.create', compact('batches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'batch_id' => 'required|exists:paket_ujian,id',
            'nama_banksoal' => 'required|string|max:255',
            'mapel' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'file_banksoal' => 'required|file|mimes:pdf,doc,docx,zip|max:10240',
        ]);

        $data = [
            'batch_id' => $request->batch_id,
            'tentor_id' => Auth::id(),
            'nama_banksoal' => $request->nama_banksoal,
            'mapel' => $request->mapel,
            'deskripsi' => $request->deskripsi,
            'tanggal_upload' => now(),
        ];

        if ($request->hasFile('file_banksoal')) {
            $file = $request->file('file_banksoal');
            $filename = time() . '_' . $file->getClientOriginalName();
            $data['file_banksoal'] = $file->storeAs('bank_soal', $filename, 'public');
        }

        BankSoal::create($data);

        return redirect()->route('tutor.bank-soal.index')
            ->with('success', 'Bank Soal berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BankSoal $bankSoal)
    {
        // Check if the tutor owns this bank soal
        if ($bankSoal->tentor_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $batches = PaketUjian::all();
        return view('tutor.bank_soal.edit', compact('bankSoal', 'batches'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BankSoal $bankSoal)
    {
        // Check if the tutor owns this bank soal
        if ($bankSoal->tentor_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'batch_id' => 'required|exists:paket_ujian,id',
            'nama_banksoal' => 'required|string|max:255',
            'mapel' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'file_banksoal' => 'nullable|file|mimes:pdf,doc,docx,zip|max:10240',
        ]);

        $data = [
            'batch_id' => $request->batch_id,
            'nama_banksoal' => $request->nama_banksoal,
            'mapel' => $request->mapel,
            'deskripsi' => $request->deskripsi,
        ];

        if ($request->hasFile('file_banksoal')) {
            // Delete old file
            if ($bankSoal->file_banksoal) {
                Storage::disk('public')->delete($bankSoal->file_banksoal);
            }

            $file = $request->file('file_banksoal');
            $filename = time() . '_' . $file->getClientOriginalName();
            $data['file_banksoal'] = $file->storeAs('bank_soal', $filename, 'public');
        }

        $bankSoal->update($data);

        return redirect()->route('tutor.bank-soal.index')
            ->with('success', 'Bank Soal berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BankSoal $bankSoal)
    {
        // Check if the tutor owns this bank soal
        if ($bankSoal->tentor_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete file if exists
        if ($bankSoal->file_banksoal) {
            Storage::disk('public')->delete($bankSoal->file_banksoal);
        }

        $bankSoal->delete();

        return redirect()->route('tutor.bank-soal.index')
            ->with('success', 'Bank Soal berhasil dihapus!');
    }

    /**
     * Download the bank soal file.
     */
    public function download(BankSoal $bankSoal)
    {
        if (!$bankSoal->file_banksoal) {
            abort(404);
        }

        return Storage::disk('public')->download($bankSoal->file_banksoal, $bankSoal->nama_banksoal);
    }
}