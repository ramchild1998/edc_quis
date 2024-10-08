<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Visit extends Model
{
    use HasFactory;

    protected $table = 'kunjungan';

    protected $fillable = [
        'order_id',
        'nama_usaha',
        'key_search',
        'alamat_usaha',
        'keterangan_lokasi',
        'nama_lokasi',
        'alamat_edc_sesuai',
        'mall',
        'apakah_ada_edc',
        'jumlah_edc',
        'mid',
        'tid',
        'nama_pemilik',
        'nomor_kontak_pemilik',
        'edc_bank_lain',
        'daftar_edc_bank_lain',
        'qris',
        'qris_bank',
        'cat_edukasi_penggunaan_edc',
        'cat_sosialisasi_aplikasi',
        'cat_informasi_brand',
        'cat_tes_transaksi',
        'ken_jaringan',
        'ken_baterai',
        'ken_adaptor',
        'ken_tombol',
        'ken_others',
        'ken_tidak_ada_kendala',
        'ken_hardware',
        'ken_komunikasi',
        'ken_lainnya',
        'jumlah_kertas',
        'id_lapor_halo',
        'request_tambahan_fasilitas',
        'request_ganti_ke_apos',
        'request_tambah_cabang',
        'request_tambah_terminal',
        'request_permintaan_struk',
        'request_others',
        'pengajuan_existing',
        'pengajuan_merchant_bca',
        'aplikasi_pendaftaran',
        'fdm_id',
        'alasan_tidak_bersedia',
        'mempunyai_edc_bca',
        'keterangan_lain',
        'foto_struk_transaksi',
        'foto_tampak_depan',
        'foto_meja_kasir',
        'foto_qris_statis',
        'foto_selfie_dengan_pemilik',
        'foto_produk',
        'screen_capture',
        'tanggal_submit',
        'time_submit',
        'nama_surveyor',
        'username',
        'upline1',
        'upline2',
        'upline3',
        'kota',
        'nip',
        'sales_code',
        'verifikasi_mid',
        'nomor_referensi',
        'latitude',
        'longitude',
        'status',
        'area_id',
        'maping_area_id',
        'created_by',
        'updated_by',
        // 'province_id',
        // 'city_id',
        // 'district_id',
        // 'subdistrict_id',
        // 'poscode_id',
    ];

    public $timestamps = true;

    public function area()
    {
        return $this->belongsTo(Area::class); // Pastikan ini sesuai dengan relasi yang Anda inginkan
    }

    public function mapingArea()
    {
        return $this->belongsTo(MapingArea::class); // Pastikan ini sesuai dengan relasi yang Anda inginkan
    }

    // public function province()
    // {
    //     return $this->belongsTo(Province::class); // Pastikan ini sesuai dengan relasi yang Anda inginkan
    // }

    // public function city()
    // {
    //     return $this->belongsTo(City::class);
    // }

    // public function district()
    // {
    //     return $this->belongsTo(District::class);
    // }

    // public function subdistrict()
    // {
    //     return $this->belongsTo(Subdistrict::class);
    // }

    // public function poscode()
    // {
    //     return $this->belongsTo(Poscode::class);
    // }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
