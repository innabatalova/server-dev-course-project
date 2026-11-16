<form class="feedback-form" method="post" action="{{ $action }}">
    @csrf

    <label>Фамилия
        <input type="text" name="surname" value="{{ old('surname', $contact?->surname) }}" required>
    </label>

    <label>Имя
        <input type="text" name="name" value="{{ old('name', $contact?->name) }}" required>
    </label>

    <label>Отчество
        <input type="text" name="patronymic" value="{{ old('patronymic', $contact?->patronymic) }}">
    </label>

    <label>Пол
        <select name="gender" required>
            <option value="мужской" @selected(old('gender', $contact?->gender) === 'мужской')>мужской</option>
            <option value="женский" @selected(old('gender', $contact?->gender) === 'женский')>женский</option>
        </select>
    </label>

    <label>Дата рождения
        <input type="date" name="birth_date" value="{{ old('birth_date', $contact?->birth_date?->format('Y-m-d')) }}" required>
    </label>

    <label>Телефон
        <input type="tel" name="phone" value="{{ old('phone', $contact?->phone) }}" required>
    </label>

    <label>Адрес
        <input type="text" name="address" value="{{ old('address', $contact?->address) }}" required>
    </label>

    <label>E-mail
        <input type="email" name="email" value="{{ old('email', $contact?->email) }}" required>
    </label>

    <label>Комментарий
        <textarea name="comment" rows="4">{{ old('comment', $contact?->comment) }}</textarea>
    </label>

    <button type="submit">{{ $button }}</button>
</form>
