<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GelombangPendaftaran extends Model
{
    use HasFactory;

    protected $guarded  = ['id'];
    protected $fillable = [
        "nama_gelombang",
        "tahun_ajaran",
        "tanggal_mulai",
        "tanggal_selesai",
        "status",
        "deskripsi",
        "biaya_pendaftaran",
        "biaya_administrasi",
        "tanggal_ujian",
        "tempat_ujian",
        "kuota_pendaftar",
        'program_studi_1ids',
        'program_studi_2ids',
        'prodi_lain_id',
    ];

    public function pendaftar()
    {
        return $this->hasOne(Pendaftar::class);
    }
    public function ukts()
    {
        return $this->hasMany(Ukt::class);
    }

    public function berkas()
    {
        return $this->hasMany(BerkasGelombangTransaksi::class, 'berkas_id');
    }
    public function prodiLain()
    {
        return $this->belongsTo(ProdiLain::class, 'prodi_lain_id', 'id');
    }

    // Relasi ke Program Studi
    public function programStudi()
    {
        return $this->belongsToMany(ProgramStudi::class, 'gelombang_program_studi', 'gelombang_id', 'program_studi_id');
    }
    
    // Accessor untuk Program Studi 1
    public function getProgramStudi1Attribute()
    {
        $ids = json_decode($this->program_studi_1ids, true) ?? [];
        return ProgramStudi::whereIn('id', $ids)->get();
    }

    // Accessor untuk Program Studi 2
    public function getProgramStudi2Attribute()
    {
        $ids = json_decode($this->program_studi_2ids, true) ?? [];
        return ProdiLain::whereIn('id', $ids)->get();
    }

}
