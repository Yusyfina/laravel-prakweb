<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            UpdateProductSeeder::class,
            OrderSeeder::class,
        ]);

        if (DB::table('users')->count() === 0) {
            $this->command->warn('Tidak ada user! Review tidak bisa dibuat tanpa user.');
        } elseif (DB::table('products')->count() === 0) {
            $this->command->warn('Tidak ada produk! Jalankan ProductSeeder terlebih dahulu.');
        } else {
            $this->command->info('Membuat 300 review dengan distribusi rating realistis...');

            Review::factory()->count(300)->create();

            $this->command->info('✅ 300 review berhasil dibuat.');
        }

        if (DB::table('coupons')->count() === 0) {
            DB::table('coupons')->insert([
                [
                    'code' => 'DISKON10',
                    'discount_type' => 'percent',
                    'discount_value' => 10,
                    'min_order' => 50000,
                    'expires_at' => now()->addMonths(2),
                    'usage_limit' => 100,
                    'used_count' => 23,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'code' => 'HEMAT25K',
                    'discount_type' => 'fixed',
                    'discount_value' => 25000,
                    'min_order' => 100000,
                    'expires_at' => now()->addMonth(),
                    'usage_limit' => 50,
                    'used_count' => 12,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'code' => 'GAJIAN20',
                    'discount_type' => 'percent',
                    'discount_value' => 20,
                    'min_order' => 75000,
                    'expires_at' => now()->subDays(5),
                    'usage_limit' => 200,
                    'used_count' => 198,
                    'created_at' => now()->subMonths(2),
                    'updated_at' => now(),
                ],
                [
                    'code' => 'NEWYEAR2025',
                    'discount_type' => 'fixed',
                    'discount_value' => 15000,
                    'min_order' => 0,
                    'expires_at' => now()->subMonths(3),
                    'usage_limit' => 500,
                    'used_count' => 411,
                    'created_at' => now()->subMonths(5),
                    'updated_at' => now(),
                ],
                [
                    'code' => 'WEEKEND15',
                    'discount_type' => 'percent',
                    'discount_value' => 15,
                    'min_order' => 30000,
                    'expires_at' => now()->addDays(10),
                    'usage_limit' => null,
                    'used_count' => 67,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);

            $this->command->info('✅ 5 data dummy coupon berhasil dibuat.');
        }
    }
}
