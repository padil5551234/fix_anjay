<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankSoal extends Model
{
    use HasFactory, Uuids;

    protected $table = 'bank_soal';

    protected $fillable = [
        'batch_id',
        'tentor_id',
        'nama_banksoal',
        'deskripsi',
        'mapel',
        'file_banksoal',
        'tanggal_upload',
    ];

    protected $casts = [
        'tanggal_upload' => 'date',
    ];

    /**
     * Get the batch that owns the BankSoal
     */
    public function batch()
    {
        return $this->belongsTo(PaketUjian::class, 'batch_id');
    }

    /**
     * Get the tentor that owns the BankSoal
     */
    public function tentor()
    {
        return $this->belongsTo(User::class, 'tentor_id');
    }
}