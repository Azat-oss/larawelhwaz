<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(100)->create();

        User::query()->each(function ($user) {
            // Добавляем префикс, только если его еще нет (чтобы не задвоить при повторном запуске)
            if (!str_starts_with($user->name, 'ПВ425')) {
                $user->update([
                    'name' => 'ПВ425 ' . $user->name
                ]);
            }
        });

        $this->call([
            CategorySeeder::class,
        ]);

        if (!User::query()->where('email','test@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }

    }
}
