<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $thamrin = Area::where('area_name', 'Thamrin')->value('id');
        $mentengDpi = Area::where('area_name', 'Menteng DPI')->value('id');
        $kuningan = Area::where('area_name', 'Kuningan')->value('id');
        $karetSatrio = Area::where('area_name', 'Karet Satrio')->value('id');
        $senopati = Area::where('area_name', 'Senopati')->value('id');
        $senayan = Area::where('area_name', 'Senayan')->value('id');
        $blokM = Area::where('area_name', 'Blok M')->value('id');
        $pondokIndahPlaza = Area::where('area_name', 'Pondok Indah Plaza')->value('id');
        $gandaria = Area::where('area_name', 'Gandaria')->value('id');
        $pejaten = Area::where('area_name', 'Pejaten')->value('id');
        $kemang = Area::where('area_name', 'Kemang')->value('id');
        $fatmawati = Area::where('area_name', 'Fatmawati')->value('id');
        $bintaro = Area::where('area_name', 'Bintaro')->value('id');
        $ciledug = Area::where('area_name', 'Ciledug')->value('id');
        $pamulang = Area::where('area_name', 'Pamulang')->value('id');
        $pondokCabe = Area::where('area_name', 'Pondok Cabe')->value('id');
        $depok = Area::where('area_name', 'Depok')->value('id');
        $cimanggis = Area::where('area_name', 'Cimanggis')->value('id');
         Location::insert([

             //Area Thamrin
             ['lokasi' => 'Chillax Sudirman', 'id_lokasi' => '001', 'area_id' => $thamrin, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Jl.Timor', 'id_lokasi' => '002', 'area_id' => $thamrin, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Jl.Lombok', 'id_lokasi' => '003', 'area_id' => $thamrin, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],

             //Area Menteng DPI
             ['lokasi' => 'Jl.Menteng Atas', 'id_lokasi' => '001', 'area_id' => $mentengDpi, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Jl.Menteng Atas Barat', 'id_lokasi' => '002', 'area_id' => $mentengDpi, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Jl.Mulia Raya', 'id_lokasi' => '003', 'area_id' => $mentengDpi, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Jl.Makmur', 'id_lokasi' => '004', 'area_id' => $mentengDpi, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],

             //Area Kuningan
             ['lokasi' => 'Pasar Festival', 'id_lokasi' => '001', 'area_id' => $kuningan, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Ruko Akay', 'id_lokasi' => '002', 'area_id' => $kuningan, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Ruko Jl.beg Murad', 'id_lokasi' => '003', 'area_id' => $kuningan, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Ruko Sadamantra', 'id_lokasi' => '004', 'area_id' => $kuningan, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Ruko Setiabudi', 'id_lokasi' => '005', 'area_id' => $kuningan, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Grand Rubina Business Park', 'id_lokasi' => '006', 'area_id' => $kuningan, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],

             //Area Karet Satrio
             ['lokasi' => 'Pasar Rumput', 'id_lokasi' => '001', 'area_id' => $karetSatrio, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Jl.Dogol', 'id_lokasi' => '002', 'area_id' => $karetSatrio, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Jl.Prof Dr Satrio', 'id_lokasi' => '003', 'area_id' => $karetSatrio, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Jl.Dr Saharjo', 'id_lokasi' => '004', 'area_id' => $karetSatrio, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],

             //Area Senopati
             ['lokasi' => 'Pasar Santa', 'id_lokasi' => '001', 'area_id' => $senopati, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Jl.Senopati Raya', 'id_lokasi' => '002', 'area_id' => $senopati, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Jl.Bakti 1', 'id_lokasi' => '003', 'area_id' => $senopati, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Jl.Suryo', 'id_lokasi' => '004', 'area_id' => $senopati, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],

             //Area Senayan
             ['lokasi' => 'Ruko Permata Senayan', 'id_lokasi' => '001', 'area_id' => $senayan, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Sudirman Park', 'id_lokasi' => '002', 'area_id' => $senayan, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Jl.Blok S', 'id_lokasi' => '003', 'area_id' => $senayan, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Jl Benhil', 'id_lokasi' => '004', 'area_id' => $senayan, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Ruko Bendungan Hilir', 'id_lokasi' => '005', 'area_id' => $senayan, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],

             //Area Blok M
             ['lokasi' => 'Pasar Mayestic', 'id_lokasi' => '001', 'area_id' => $blokM, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Ruko Melawai', 'id_lokasi' => '002', 'area_id' => $blokM, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Ruko Kebayoran Baru', 'id_lokasi' => '003', 'area_id' => $blokM, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Ruko Grand Wijaya', 'id_lokasi' => '004', 'area_id' => $blokM, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],

             //Area Pondok Indah Plaza
             ['lokasi' => 'Ruko Pondok Plaza 1', 'id_lokasi' => '001', 'area_id' => $pondokIndahPlaza, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Ruko Pondok Plaza 2', 'id_lokasi' => '002', 'area_id' => $pondokIndahPlaza, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Ruko Pondok Plaza 3', 'id_lokasi' => '003', 'area_id' => $pondokIndahPlaza, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Ruko Pondok Plaza 5', 'id_lokasi' => '004', 'area_id' => $pondokIndahPlaza, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Ruko Gedung Hijau', 'id_lokasi' => '005', 'area_id' => $pondokIndahPlaza, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],

             //Area Gandaria
             ['lokasi' => 'Pasar Taman Puring', 'id_lokasi' => '001', 'area_id' => $gandaria, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Ruko Radio Dalam Raya', 'id_lokasi' => '002', 'area_id' => $gandaria, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Ruko Sentra Arteri Mas', 'id_lokasi' => '003', 'area_id' => $gandaria, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Pasar Palmerah', 'id_lokasi' => '004', 'area_id' => $gandaria, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Pasar Bunga Rawa Belong', 'id_lokasi' => '005', 'area_id' => $gandaria, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Ruko Grand Safari', 'id_lokasi' => '006', 'area_id' => $gandaria, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],

             //Area Pejaten
             ['lokasi' => 'Ruko Samali Pejaten', 'id_lokasi' => '001', 'area_id' => $pejaten, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Jl.Pejaten Raya', 'id_lokasi' => '002', 'area_id' => $pejaten, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Ruko Angsana', 'id_lokasi' => '003', 'area_id' => $pejaten, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],

             //Area Kemang
             ['lokasi' => 'Jl.Bangka', 'id_lokasi' => '001', 'area_id' => $kemang, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Jl.Mampang Prapatan', 'id_lokasi' => '002', 'area_id' => $kemang, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Jl.Wr Buncit', 'id_lokasi' => '003', 'area_id' => $kemang, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Ruko Kemang Raya', 'id_lokasi' => '004', 'area_id' => $kemang, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],

             //Area Fatmawati
             ['lokasi' => 'Jl.Terogong', 'id_lokasi' => '001', 'area_id' => $fatmawati, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Jl.Antasari', 'id_lokasi' => '002', 'area_id' => $fatmawati, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Ruko Duta Mas Fatmawati', 'id_lokasi' => '003', 'area_id' => $fatmawati, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Ruko Golden Fatmawati', 'id_lokasi' => '004', 'area_id' => $fatmawati, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],

             //Area Bintaro
             ['lokasi' => 'Pasar Modern Bintaro', 'id_lokasi' => '001', 'area_id' => $bintaro, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Bintaro Sektor 1-9', 'id_lokasi' => '002', 'area_id' => $bintaro, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Ruko Emerald', 'id_lokasi' => '003', 'area_id' => $bintaro, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Ruko Bintaro Trade Center', 'id_lokasi' => '004', 'area_id' => $bintaro, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Ruko Kebayoran Arcade', 'id_lokasi' => '005', 'area_id' => $bintaro, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Ruko Arcade Bintaro', 'id_lokasi' => '006', 'area_id' => $bintaro, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Jl.Ceger Raya', 'id_lokasi' => '007', 'area_id' => $bintaro, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Jl.Veteran', 'id_lokasi' => '008', 'area_id' => $bintaro, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Jl.Kesehatan', 'id_lokasi' => '009', 'area_id' => $bintaro, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],

             //Area Ciledug
             ['lokasi' => 'Ruko Ciledug Raya', 'id_lokasi' => '001', 'area_id' => $ciledug, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Jl.Hascokrominoto', 'id_lokasi' => '002', 'area_id' => $ciledug, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Ruko Saraswati', 'id_lokasi' => '003', 'area_id' => $ciledug, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Ruko Raden Saleh', 'id_lokasi' => '004', 'area_id' => $ciledug, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Jl.Ciledug Raya', 'id_lokasi' => '005', 'area_id' => $ciledug, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],

             //Ara Pamulang
             ['lokasi' => 'Ruko Pamulang Permai', 'id_lokasi' => '001', 'area_id' => $pamulang, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Ruko Urbana Square', 'id_lokasi' => '002', 'area_id' => $pamulang, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Ruko Surya Kencana', 'id_lokasi' => '003', 'area_id' => $pamulang, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Ruko Pamulang Terrace', 'id_lokasi' => '004', 'area_id' => $pamulang, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],

             //Area Pondok Cabe
             ['lokasi' => 'Ruko 52 Residence', 'id_lokasi' => '001', 'area_id' => $pondokCabe, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Ruko South City Square', 'id_lokasi' => '002', 'area_id' => $pondokCabe, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Jl.Pondok Cabe Raya', 'id_lokasi' => '003', 'area_id' => $pondokCabe, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],

             //Area Depok
             ['lokasi' => 'Ruko Cijagur', 'id_lokasi' => '001', 'area_id' => $depok, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Ruko Yonzikon', 'id_lokasi' => '002', 'area_id' => $depok, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Jl Raya Sanim', 'id_lokasi' => '003', 'area_id' => $depok, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Ruko Citayem Center', 'id_lokasi' => '004', 'area_id' => $depok, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Ruko Citralake', 'id_lokasi' => '005', 'area_id' => $depok, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Ruko Bojong Gede', 'id_lokasi' => '006', 'area_id' => $depok, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Ruko Parung', 'id_lokasi' => '007', 'area_id' => $depok, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Ruko ITC Depok', 'id_lokasi' => '008', 'area_id' => $depok, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Jl.Raya Sawangan', 'id_lokasi' => '009', 'area_id' => $depok, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],

             //Area Cimanggis
             ['lokasi' => 'Ruko Permata Cimanggis', 'id_lokasi' => '001', 'area_id' => $cimanggis, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Jl.RTM', 'id_lokasi' => '002', 'area_id' => $cimanggis, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Ruko Cisalak', 'id_lokasi' => '003', 'area_id' => $cimanggis, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Ruko Cibubur Indah', 'id_lokasi' => '004', 'area_id' => $cimanggis, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Ruko Rafles Hills', 'id_lokasi' => '005', 'area_id' => $cimanggis, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Ruko Jambore Park', 'id_lokasi' => '006', 'area_id' => $cimanggis, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Ruko Cibubur Country', 'id_lokasi' => '007', 'area_id' => $cimanggis, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Ruko Canadian', 'id_lokasi' => '008', 'area_id' => $cimanggis, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Jl.Raya Condet', 'id_lokasi' => '009', 'area_id' => $cimanggis, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['lokasi' => 'Jl.Raya Tengah', 'id_lokasi' => '010', 'area_id' => $cimanggis, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
