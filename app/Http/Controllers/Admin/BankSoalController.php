<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankSoal;
use App\Models\PaketUjian;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class BankSoalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $batches = PaketUjian::all();
        $tentors = User::role('tutor')->get();
        return view('admin.bank_soal.index', compact('batches', 'tentors'));
    }

    /**
     * Get data for DataTables.
     */
    public function data()
    {
        $bankSoal = BankSoal::with(['batch', 'tentor'])->get();
        
        return DataTables::of($bankSoal)
            ->addIndexColumn()
            ->addColumn('batch_nama', function ($row) {
                return $row->batch->nama ?? '-';
            })
            ->addColumn('tentor_nama', function ($row) {
                return $row->tentor->name ?? '-';
            })
            ->addColumn('file', function ($row) {
                if ($row->file_banksoal) {
                    return '<a href="' . Storage::url($row->file_banksoal) . '" target="_blank" class="btn btn-sm btn-info">
                        <i class="fas fa-download"></i> Download
                    </a>';
                }
                return '-';
            })
            ->addColumn('action', function ($row) {
                $editBtn = '<a href="' . route('admin.bank-soal.edit', $row->id) . '" class="btn btn-sm btn-primary">
                    <i class="fas fa-edit"></i>
                </a>';
                $deleteBtn = '<button type="button" class="btn btn-sm btn-danger delete-btn" data-id="' . $row->id . '">
                    <i class="fas fa-trash"></i>
                </button>';
                return $editBtn . ' ' . $deleteBtn;
            })
            ->rawColumns(['file', 'action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $batches = PaketUjian::all();
        $tentors = User::role('tutor')->get();
        return view('admin.bank_soal.form', compact('batches', 'tentors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'batch_id' => 'required|exists:paket_ujian,id',
            'tentor_id' => 'required|exists:users,id',
            'nama_banksoal' => 'required|string|max:255',
            'mapel' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'file_banksoal' => 'nullable|file|mimes:pdf,doc,docx,zip|max:10240',
        ]);

        $data = $request->except('file_banksoal');
        $data['tanggal_upload'] = now();

        if ($request->hasFile('file_banksoal')) {
            $file = $request->file('file_banksoal');
            $filename = time() . '_' . $file->getClientOriginalName();
            $data['file_banksoal'] = $file->storeAs('bank_soal', $filename, 'public');
        }

        BankSoal::create($data);

        return redirect()->route('admin.bank-soal.index')
            ->with('success', 'Bank Soal berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BankSoal $bankSoal)
    {
        $batches = PaketUjian::all();
        $tentors = User::role('tutor')->get();
        return view('admin.bank_soal.form', compact('bankSoal', 'batches', 'tentors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BankSoal $bankSoal)
    {
        $request->validate([
            'batch_id' => 'required|exists:paket_ujian,id',
            'tentor_id' => 'required|exists:users,id',
            'nama_banksoal' => 'required|string|max:255',
            'mapel' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'file_banksoal' => 'nullable|file|mimes:pdf,doc,docx,zip|max:10240',
        ]);

        $data = $request->except('file_banksoal');

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

        return redirect()->route('admin.bank-soal.index')
            ->with('success', 'Bank Soal berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BankSoal $bankSoal)
    {
        // Delete file if exists
        if ($bankSoal->file_banksoal) {
            Storage::disk('public')->delete($bankSoal->file_banksoal);
        }
        
        $bankSoal->delete();

        return response()->json([
            'success' => true,
            'message' => 'Bank Soal berhasil dihapus'
        ]);
    }
}