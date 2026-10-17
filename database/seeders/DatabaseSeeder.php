<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        // Akun Admin 
        User::create([
            'name'     => 'LaboranDummy',
            'npm'      => '198501012010121001',
            'email'    => 'adminlab@unila.ac.id',
            'password' => Hash::make('password123'),
            'role'     => 'admin',
        ]);

        // Akun Mahasiswa
        User::create([
            'name'     => 'MahasiswaDummy',
            'npm'      => '2417051011',
            'email'    => 'mahasiswa@unila.ac.id',
            'password' => Hash::make('password123'),
            'role'     => 'mahasiswa',
        ]);

        // Data 5 Ruangan Lab 
        $rooms = [
            [
                'name'       => 'Lab Komputasi Dasar - R1',
                'capacity'   => 35,
                'location'   => 'Gedung MIPA T Lantai 3',
                'facilities' => '35 PC Client, 2 AC, 1 Proyektor, 1 Whiteboard, LAN Gigabit',
                'condition'  => 'Baik',
            ],
            [
                'name'       => 'Lab Komputasi Dasar - R2',
                'capacity'   => 35,
                'location'   => 'Gedung MIPA T Lantai 3',
                'facilities' => '35 PC Client, 2 AC, 1 Proyektor, 1 Whiteboard, LAN Gigabit',
                'condition'  => 'Baik',
            ],
            [
                'name'       => 'Lab Komputasi Dasar - R3',
                'capacity'   => 35,
                'location'   => 'Gedung MIPA T Lantai 3',
                'facilities' => '35 PC Client, 2 AC, 1 Proyektor, 1 Whiteboard, LAN Gigabit',
                'condition'  => 'Baik',
            ],
            [
                'name'       => 'Lab Komputasi Dasar - R4',
                'capacity'   => 35,
                'location'   => 'Gedung MIPA T Lantai 3',
                'facilities' => '35 PC Client, 2 AC, 1 Proyektor, 1 Whiteboard, LAN Gigabit',
                'condition'  => 'Baik',
            ],
            [
                'name'       => 'Lab Rekayasa Perangkat Lunak',
                'capacity'   => 30,
                'location'   => 'Gedung MIPA T Lantai 2',
                'facilities' => '30 PC Client, 2 AC, 1 Smart TV, 1 Whiteboard, LAN Gigabit',
                'condition'  => 'Baik',
            ],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}