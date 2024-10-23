<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Visit extends Model
{
    use HasFactory;

    protected $table = 'visit';

    protected $casts = [
        'tags' => 'array',
    ];
    protected $fillable = [
        'id_visit',
        'vendor_id',
        'area_id',
        'location_id',
        'nama_lokasi',
        'keterangan_lokasi',
        'nama_usaha',
        'alamat_usaha',
        'province_id',
        'city_id',
        'district_id',
        'subdistrict_id',
        'poscode_id',
        'mid',
        'tid',
        'nomor_sn',
        'nama_pemilik',
        'no_kontak',
        'alamat_edc_sesuai',
        'ada_edc_bca',
        'jumlah_edc',
        'edc_bank_lain',
        'list_edc_bank_lain',
        'catatan_kunjungan_edc',
        'qris_bca',
        'nmid',
        'list_qris_bank_lain',
        'tes_transaksi',
        'catatan_kunjungan_program',
        'kendala',
        'request',
        'jumlah_struk',
        'id_lapor_halo',
        'pengajuan_merchant',
        'aplikasi_pendaftaran',
        'fdm_id',
        'alasan_tidak_bersedia',
        'mempunyai_edc',
        'keterangan_lain',
        'nomor_referensi',
        'foto_struk',
        'foto_tampak_depan',
        'foto_meja_kasir',
        'foto_qris_statis',
        'foto_selfie',
        'foto_produk',
        'screen_capture',
        'tanggal_submit',
        'waktu_submit',
        'nama_surveyor',
        'upline1',
        'sales_code',
        'is_merchant',
        'lat',
        'long',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class); // Pastikan ini sesuai dengan relasi yang Anda inginkan
    }

    public function location()
    {
        return $this->belongsTo(Location::class); // Pastikan ini sesuai dengan relasi yang Anda inginkan
    }

    public function province()
    {
        return $this->belongsTo(Province::class); // Pastikan ini sesuai dengan relasi yang Anda inginkan
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function subdistrict()
    {
        return $this->belongsTo(Subdistrict::class);
    }

    public function poscode()
    {
        return $this->belongsTo(Poscode::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
