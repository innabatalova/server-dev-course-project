<x-layout title="Feedback form" heading="Feedback form">
    <p><a href="/labs">← К списку лабораторных</a></p>

    <form class="feedback-form" action="https://httpbin.org/post" method="post">
        <label>Имя пользователя
            <input type="text" name="username" required>
        </label>

        <label>E-mail пользователя
            <input type="email" name="email" required>
        </label>

        <fieldset>
            <legend>Тип обращения</legend>
            <label><input type="radio" name="type" value="complaint" required> Жалоба</label>
            <label><input type="radio" name="type" value="suggestion"> Предложение</label>
            <label><input type="radio" name="type" value="gratitude"> Благодарность</label>
        </fieldset>

        <label>Текст обращения
            <textarea name="message" rows="6" required></textarea>
        </label>

        <fieldset>
            <legend>Вариант ответа</legend>
            <label><input type="checkbox" name="reply[]" value="sms"> СМС</label>
            <label><input type="checkbox" name="reply[]" value="email"> E-mail</label>
        </fieldset>

        <button type="submit">Отправить</button>
    </form>

    <p><a href="/labs/1/headers">Перейти ко второй странице</a></p>
</x-layout>
