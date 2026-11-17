<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => fake()->randomElement([
                'Знакомство с Laravel', 'Как работает роутинг', 'Blade вместо JSX',
                'Миграции и база данных', 'Первая лабораторная работа', 'Заметки о фреймворках',
            ]),
            'text' => fake()->randomElement([
                'Фреймворк берёт на себя рутину, а нам остаётся писать логику приложения.',
                'Маршрут связывает адрес страницы с методом контроллера.',
                'Шаблон собирается на сервере и приходит в браузер готовым HTML.',
                'Миграция описывает структуру таблицы и хранится вместе с кодом.',
            ]),
        ];
    }
}
