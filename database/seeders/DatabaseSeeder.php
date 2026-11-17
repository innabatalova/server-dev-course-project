<?php
namespace Database\Seeders;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Article;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Contact::factory()->count(25)->create();

        User::factory()->create([
            'name'     => 'Test User',
            'nickname' => 'test_user',
            'email'    => 'test@example.com',
        ]);

        $authors = [
            User::factory()->create(['name' => 'Анна Иванова', 'nickname' => 'anna_i', 'email' => 'anna@example.com']),
            User::factory()->create(['name' => 'Дмитрий Петров', 'nickname' => 'dima_p', 'email' => 'dmitry@example.com']),
            User::factory()->create(['name' => 'Мария Сидорова', 'nickname' => 'masha_s', 'email' => 'maria@example.com']),
        ];

        foreach ($authors as $author) {
            Article::factory()->count(2)->create(['user_id' => $author->id]);
        }
    }
}
