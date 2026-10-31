<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $projects = [
            [
                'title'=> 'Sistem Informasi Akademik',
                'description'=> 'Aplikasi berbasis web untuk pengelolaan data mahasiswa, jadwal kuliah dan nilai perkuliahan',
                'teknologi'=> 'Laravel & Bootsrap',
                'image'=> 'project1.jgp',
                'status'=> 'Selesai',
            ],
            [
                'title'=> 'E-Commerce SEO Optimization',
                'description'=> 'Aplikasi optimalisasi struktur heading dan indexing halaman web toko online',
                'teknologi'=> 'PHP & Google Search Console',
                'image'=> 'project2.jgp',
                'status'=> 'In Progress',
            ],
            [
                'title'=> 'Redesign Cover dan Branding',
                'description'=> 'Perancangan element grafis personal branding dan desain sampul buku rekayasa web',
                'teknologi'=> 'Figma & Canva',
                'image'=> 'project3.jgp',
                'status'=> 'Selesai',
            ],
            [
                'title'=> 'Portal Berita Mahasiswa',
                'description'=> 'Tentang hal terkini yang dialami mahasiswa',
                'teknologi'=> 'Liputan & Kompas',
                'image'=> 'project4.jgp',
                'status'=> 'Selesai',
            ],
            // [
            //     'title'=> 'Portal Berita Mahasiswa',
            //     'description'=> 'Tentang hal terkini yang dialami mahasiswa',
            //     'teknologi'=> 'Liputan & Kompas',
            //     'image'=> 'project9.jpg',
            //     'status'=> 'Selesai',
            // ],
            // [
            //     'title'=> 'Portal Berita Mahasiswa',
            //     'description'=> 'Tentang hal terkini yang dialami mahasiswa',
            //     'teknologi'=> 'Liputan & Kompas',
            //     'image'=> 'project10.jpg',
            //     'status'=> 'Selesai',
            // ],
        ];
        foreach ($projects as $project) {
            \App\Models\Project::updateOrCreate(['image' => $project['image']], $project);
        }
    }
}
