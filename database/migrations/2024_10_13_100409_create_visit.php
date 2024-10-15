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
        Schema::create('visit', function (Blueprint $table) {
            // Area Category
            $table->integerIncrements('id');
            $table->char('id_visit', 10)->unique();
            $table->unsignedInteger('vendor_id');
            $table->foreign('vendor_id')->references('id')->on('vendor');
            $table->unsignedInteger('area_id');
            $table->foreign('area_id')->references('id')->on('area');
            $table->unsignedInteger('location_id');
            $table->foreign('location_id')->references('id')->on('location');
            $table->string('nama_lokasi', 100)->nullable();
            $table->string('keterangan_lokasi', 22)->nullable();
            $table->string('nama_usaha', 100);
            $table->string('alamat_usaha');
            $table->unsignedInteger('province_id');
            $table->foreign('province_id')->references('id')->on('province');
            $table->unsignedInteger('city_id');
            $table->foreign('city_id')->references('id')->on('city');
            $table->unsignedInteger('district_id');
            $table->foreign('district_id')->references('id')->on('district');
            $table->unsignedInteger('subdistrict_id');
            $table->foreign('subdistrict_id')->references('id')->on('subdistrict');
            $table->unsignedInteger('poscode_id');
            $table->foreign('poscode_id')->references('id')->on('poscode');

            // Merchant Infromation Category
            $table->char('mid', 9)->unique()->nullable();
            $table->text('tid')->nullable();
            $table->char('nomor_sn', 24)->nullable();
            $table->string('nama_pemilik', 45)->nullable();
            $table->string('no_kontak', 20)->nullable();
            $table->boolean('alamat_edc_sesuai')->nullable();
            $table->boolean('ada_edc_bca')->nullable();
            $table->unsignedTinyInteger('jumlah_edc')->nullable();
            $table->boolean('edc_bank_lain')->nullable();
            $table->text('list_edc_bank_lain')->nullable();
            $table->string('catatan_kunjungan_edc', 22)->nullable();
            $table->boolean('qris_bca')->nullable();
            $table->string('nmid', 15)->nullable();
            $table->text('list_qris_bank_lain')->nullable();
            $table->boolean('tes_transaksi')->nullable();
            $table->string('catatan_kunjungan_program', 50)->nullable();
            $table->text('kendala')->nullable();
            $table->text('request')->nullable();
            $table->unsignedTinyInteger('jumlah_struk')->nullable();
            $table->string('id_lapor_halo', 8)->nullable();

            // Potential Merchant Category
            $table->string('pengajuan_merchant', 25)->nullable();
            $table->string('aplikasi_pendaftaran', 25)->nullable();
            $table->string('fdm_id', 7)->nullable();
            $table->string('alasan_tidak_bersedia', 50)->nullable();
            $table->boolean('mempunyai_edc')->nullable();
            $table->string('keterangan_lain', 50)->nullable();
            $table->string('nomor_referensi')->nullable();

            // Bukti Kunjungan
            $table->string('foto_struk')->nullable();
            $table->string('foto_tampak_depan')->nullable();
            $table->string('foto_meja_kasir')->nullable();
            $table->string('foto_qris_statis')->nullable();
            $table->string('foto_selfie')->nullable();
            $table->string('foto_produk')->nullable();
            $table->string('screen_capture')->nullable();
            $table->date('tanggal_submit');
            $table->time('waktu_submit');
            $table->string('nama_surveyor');
            $table->string('upline1')->nullable();
            $table->string('sales_code', 15)->nullable();

            // Tambahan
            $table->decimal('lat', 10, 8)->nullable();
            $table->decimal('long', 11, 8)->nullable();
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
        Schema::dropIfExists('visit');
        Schema::dropIfExists('kunjungan');
    }
};
