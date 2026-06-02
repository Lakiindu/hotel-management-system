<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminAndRoomSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@hotel.com'],
            [
                'name' => 'Hotel Admin',
                'phone' => '0771234567',
                'address' => 'Maharagama, Sri Lanka',
                'password' => Hash::make('admin12345'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        $rooms = [
            [
                'room_number' => 'D101',
                'room_type' => 'Deluxe Room',
                'price_per_night' => 12000,
                'capacity' => 2,
                'description' => 'Modern deluxe room with comfortable bedding and city view.',
                'facilities' => ['WiFi', 'Air Conditioning', 'TV', 'Mini Bar'],
                'image' => null,
                'status' => 'available',
            ],
            [
                'room_number' => 'F201',
                'room_type' => 'Family Room',
                'price_per_night' => 18000,
                'capacity' => 4,
                'description' => 'Spacious family room with extra beds and relaxing interior.',
                'facilities' => ['WiFi', 'Air Conditioning', 'TV', 'Room Service'],
                'image' => null,
                'status' => 'available',
            ],
            [
                'room_number' => 'S301',
                'room_type' => 'Suite Room',
                'price_per_night' => 25000,
                'capacity' => 3,
                'description' => 'Luxury suite with premium facilities and elegant design.',
                'facilities' => ['WiFi', 'Air Conditioning', 'TV', 'Mini Bar', 'Room Service'],
                'image' => null,
                'status' => 'available',
            ],
        ];

        foreach ($rooms as $room) {
            Room::updateOrCreate(
                ['room_number' => $room['room_number']],
                $room
            );
        }
    }
}