<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    public function definition(): array
    {
        $female = fake()->boolean();

        $surnames = $female
            ? ['Иванова', 'Петрова', 'Сидорова', 'Смирнова', 'Кузнецова', 'Попова', 'Васильева', 'Соколова', 'Михайлова', 'Новикова', 'Фёдорова', 'Морозова']
            : ['Иванов', 'Петров', 'Сидоров', 'Смирнов', 'Кузнецов', 'Попов', 'Васильев', 'Соколов', 'Михайлов', 'Новиков', 'Фёдоров', 'Морозов'];

        $names = $female
            ? ['Анна', 'Мария', 'Елена', 'Ольга', 'Наталья', 'Татьяна', 'Ирина', 'Екатерина']
            : ['Александр', 'Дмитрий', 'Максим', 'Сергей', 'Андрей', 'Алексей', 'Артём', 'Илья'];

        $patronymics = $female
            ? ['Александровна', 'Дмитриевна', 'Сергеевна', 'Андреевна', 'Алексеевна', 'Ивановна']
            : ['Александрович', 'Дмитриевич', 'Сергеевич', 'Андреевич', 'Алексеевич', 'Иванович'];

        $streets = ['Тверская', 'Ленина', 'Мира', 'Садовая', 'Новая', 'Школьная', 'Гагарина', 'Парковая'];

        return [
            'surname'    => fake()->randomElement($surnames),
            'name'       => fake()->randomElement($names),
            'patronymic' => fake()->optional(0.8)->randomElement($patronymics),
            'gender'     => $female ? 'женский' : 'мужской',
            'birth_date' => fake()->dateTimeBetween('-60 years', '-18 years')->format('Y-m-d'),
            'phone'      => fake()->numerify('+7 (9##) ###-##-##'),
            'address'    => 'г. Москва, ул. ' . fake()->randomElement($streets) . ', д. ' . fake()->numberBetween(1, 99),
            'email'      => fake()->unique()->safeEmail(),
            'comment'    => fake()->optional(0.5)->randomElement([
                'Коллега по работе', 'Одногруппник', 'Сосед', 'Друг семьи', 'Позвонить вечером', 'Деловой контакт',
            ]),
        ];
    }
}
