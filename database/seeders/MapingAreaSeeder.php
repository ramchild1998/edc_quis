<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\MapingArea;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MapingAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jakarta = Area::where('area_name', 'Jakarta')->value('id');
        $tangerang = Area::where('area_name', 'Tangerang')->value('id');
        $surabaya = Area::where('area_name', 'Surabaya')->value('id');
        $bali = Area::where('area_name', 'Bali')->value('id');
        $bandung = Area::where('area_name', 'Bandung')->value('id');
         MapingArea::insert([
             ['sub_area' => 'Thamrin', 'area_id' => $jakarta, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Tanah Abang', 'area_id' => $jakarta, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Menteng', 'area_id' => $jakarta, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Kuningan', 'area_id' => $jakarta, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Karet Satrio', 'area_id' => $jakarta, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Senopati', 'area_id' => $jakarta, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Senayan', 'area_id' => $jakarta, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Blok M', 'area_id' => $jakarta, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Pondok Indah', 'area_id' => $jakarta, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Gandaria', 'area_id' => $jakarta, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Pejaten', 'area_id' => $jakarta, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Kemang', 'area_id' => $jakarta, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Kalibata', 'area_id' => $jakarta, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Fatmawati', 'area_id' => $jakarta, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Puri Indah', 'area_id' => $jakarta, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Slipi', 'area_id' => $jakarta, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Pluit', 'area_id' => $jakarta, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Cengkareng (Citra Garden, Taman Palem, Taman Surya)', 'area_id' => $jakarta, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Cakung', 'area_id' => $jakarta, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'PIK Jakarta', 'area_id' => $jakarta, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Kelapa Gading', 'area_id' => $jakarta, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Pasar Minggu', 'area_id' => $jakarta, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Sunter', 'area_id' => $jakarta, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Glodok Pancoran', 'area_id' => $jakarta, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Galaxy Bekasi', 'area_id' => $jakarta, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Summarecon Bekasi', 'area_id' => $jakarta, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Margonda Depok', 'area_id' => $jakarta, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],

             ['sub_area' => 'Karawaci', 'area_id' => $tangerang, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Alam Sutera', 'area_id' => $tangerang, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Gading Serpong', 'area_id' => $tangerang, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'BSD', 'area_id' => $tangerang, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Bintaro', 'area_id' => $tangerang, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'PIK Tangerang', 'area_id' => $tangerang, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Citra Raya', 'area_id' => $tangerang, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Green Lake', 'area_id' => $tangerang, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Ciledug', 'area_id' => $tangerang, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Pamulang', 'area_id' => $tangerang, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Pondok Cabe', 'area_id' => $tangerang, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],

             ['sub_area' => 'Tunjungan', 'area_id' => $surabaya, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()], 
             ['sub_area' => 'Embong Malang', 'area_id' => $surabaya, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()], 
             ['sub_area' => 'Genteng', 'area_id' => $surabaya, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()], 
             ['sub_area' => 'Gwalk', 'area_id' => $surabaya, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()], 
             ['sub_area' => 'Wiyung', 'area_id' => $surabaya, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()], 
             ['sub_area' => 'Pakuwon City', 'area_id' => $surabaya, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()], 
             ['sub_area' => 'Mayjend Yono Soewoyo', 'area_id' => $surabaya, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()], 
             ['sub_area' => 'Undaan - Jagalan', 'area_id' => $surabaya, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()], 
             ['sub_area' => 'Ir Soekarno MERR', 'area_id' => $surabaya, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()], 
             ['sub_area' => 'Bubutan', 'area_id' => $surabaya, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()], 
             ['sub_area' => 'Ahmad Yani', 'area_id' => $surabaya, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()], 
             ['sub_area' => 'Dupak', 'area_id' => $surabaya, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()], 

             ['sub_area' => 'Kuta', 'area_id' => $bali, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Seminyak', 'area_id' => $bali, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Kerobokan', 'area_id' => $bali, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Canggu', 'area_id' => $bali, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Jimbaran', 'area_id' => $bali, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Nusa Dua', 'area_id' => $bali, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Denpasar', 'area_id' => $bali, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Uluwatu', 'area_id' => $bali, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Glanyar', 'area_id' => $bali, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Ubud', 'area_id' => $bali, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Sanur', 'area_id' => $bali, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],

             ['sub_area' => 'Braga', 'area_id' => $bandung, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Asia Afrika', 'area_id' => $bandung, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Pasir Kaliki', 'area_id' => $bandung, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Pasteur', 'area_id' => $bandung, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Cihampelas', 'area_id' => $bandung, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Setiabudi', 'area_id' => $bandung, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Lembang', 'area_id' => $bandung, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Riau', 'area_id' => $bandung, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Taman Sari', 'area_id' => $bandung, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Sukajadi', 'area_id' => $bandung, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Mekarwangi', 'area_id' => $bandung, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Buah Batu', 'area_id' => $bandung, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Kota Baru Parahyangan', 'area_id' => $bandung, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
             ['sub_area' => 'Sudirman', 'area_id' => $bandung, 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
