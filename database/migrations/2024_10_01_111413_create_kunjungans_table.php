<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kunjungan', function (Blueprint $table) {
            $table->integerIncrements('id')->primary();
            // $table->string('order_id', 10);
            $table->string('nama_usaha', 45);
            $table->string('key_search');
            $table->string('alamat_usaha');
            $table->string('keterangan_lokasi');
            $table->string('nama_lokasi', 45);
            $table->string('alamat_edc_sesuai', 45);
            $table->string('mall', 45);
            $table->string('apakah_ada_edc', 10);
            $table->unsignedInteger('jumlah_edc');
            $table->char('mid', 9)->unique();
            $table->char('tid', 8);
            $table->string('nama_pemilik', 45);
            $table->string('nomor_kontak_pemilik', 20);
            $table->string('edc_bank_lain', 10);
            $table->string('daftar_edc_bank_lain', 45);
            $table->string('qris', 45);
            $table->string('qris_bank', 45);
            $table->string('cat_edukasi_penggunaan_edc');
            $table->string('cat_sosialisasi_aplikasi');
            $table->string('cat_informasi_brand');
            $table->string('cat_tes_transaksi');
            $table->string('ken_jaringan');
            $table->string('ken_baterai');
            $table->string('ken_adaptor');
            $table->string('ken_tombol');
            $table->string('ken_others');
            $table->string('ken_tidak_ada_kendala');
            $table->string('ken_hardware');
            $table->string('ken_komunikasi');
            $table->string('ken_lainnya');
            $table->integer('jumlah_kertas');
            $table->string('id_lapor_halo', 45);
            $table->string('request_tambahan_fasilitas');
            $table->string('request_ganti_ke_apos');
            $table->string('request_tambah_cabang');
            $table->string('request_tambah_terminal');
            $table->string('request_permintaan_struk');
            $table->string('request_others');
            $table->string('pengajuan_existing');
            $table->string('pengajuan_merchant_bca');
            $table->string('aplikasi_pendaftaran');
            $table->char('fdm_id', 9);
            $table->string('alasan_tidak_bersedia');
            $table->string('mempunyai_edc_bca');
            $table->string('keterangan_lain');
            $table->string('foto_struk_transaksi');
            $table->string('foto_tampak_depan');
            $table->string('foto_meja_kasir');
            $table->string('foto_qris_statis');
            $table->string('foto_selfie_dengan_pemilik');
            $table->string('foto_produk');
            $table->string('screen_capture');
            $table->date('tanggal_submit');
            $table->time('time_submit');
            $table->string('nama_surveyor', 45);
            $table->string('username', 45);
            $table->string('upline1', 45);
            $table->string('upline2', 45);
            $table->string('upline3', 45);
            $table->string('kota', 45);
            $table->string('nip', 45);
            $table->string('sales_code', 45);
            $table->string('verifikasi_mid', 45);
            $table->string('nomor_referensi', 45);
            $table->boolean('status');
            $table->unsignedInteger('area_id');
            $table->foreign('area_id')->references('id')->on('area');
            $table->unsignedInteger('maping_area_id');
            $table->foreign('maping_area_id')->references('id')->on('maping_area');
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users');
            $table->unsignedBigInteger('updated_by');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kunjungan');
    }
};
