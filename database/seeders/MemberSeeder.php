<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Member;
use App\Models\MemberPoint;
use Illuminate\Support\Facades\Hash;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample member users
        $members = [
            [
                'name' => 'Barpio Aikonara',
                'email' => 'barpio@member.com',
                'phone' => '08293221838',
                'password' => Hash::make('08293221838'),
                'role' => 'pelanggan',
                'address' => 'Jl. Merdeka No. 123, Jakarta',
                'is_active' => true,
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti@member.com',
                'phone' => '08123456789',
                'password' => Hash::make('08123456789'),
                'role' => 'pelanggan',
                'address' => 'Jl. Sudirman No. 45, Bandung',
                'is_active' => true,
            ],
            [
                'name' => 'Ahmad Rizki',
                'email' => 'ahmad@member.com',
                'phone' => '08567891234',
                'password' => Hash::make('08567891234'),
                'role' => 'pelanggan',
                'address' => 'Jl. Gatot Subroto No. 78, Surabaya',
                'is_active' => true,
            ],
        ];

        foreach ($members as $memberData) {
            // Create user
            $user = User::create($memberData);

            // Create member
            $member = Member::create([
                'user_id' => $user->id,
            ]);

            // Add some sample points history
            $pointsData = [
                [
                    'type' => 'earned',
                    'points' => 15,
                    'description' => 'Belanja Rp 150.000',
                    'expired_at' => now()->addYear(),
                ],
                [
                    'type' => 'earned',
                    'points' => 10,
                    'description' => 'Belanja Rp 100.000',
                    'expired_at' => now()->addYear(),
                ],
                [
                    'type' => 'redeemed',
                    'points' => -5,
                    'description' => 'Tukar voucher: Diskon 5%',
                    'expired_at' => null,
                ],
            ];

            foreach ($pointsData as $pointData) {
                $member->points()->create($pointData);
            }

            // Update total points
            $totalPoints = $member->points()->sum('points');
            $member->update([
                'total_points' => $totalPoints,
                'lifetime_points' => abs($member->points()->where('type', 'earned')->sum('points')),
            ]);

            $this->command->info("Member created: {$user->name} - {$member->member_code} ({$member->total_points} points)");
        }
    }
}

