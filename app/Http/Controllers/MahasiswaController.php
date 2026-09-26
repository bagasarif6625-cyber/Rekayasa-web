<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    //
    public function index()
    {
        $mahasiswa = [
            'nim' => '251011701159',
            'nama' => 'Bagas Muhammad Arif',
            'prodi' => 'Sistem Informasi',
            'email' => 'bagasarif6625@gmail.com',
            'kampus' => 'Universitas Pamulang',
            'status' => 'Aktif',
        ];

        return view('page.profile', compact('mahasiswa'));
    }
}
