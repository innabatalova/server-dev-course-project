@if ($errors->any())
    <div class="bank-alert bank-alert-error" role="alert">
        Ошибка: статья не сохранена. Проверьте поля, отмеченные ниже.
    </div>
@endif

<div class="bank-field">
    <label for="title">Заголовок</label>
    <input id="title" type="text" name="title" value="{{ old('title', $article->title ?? '') }}" maxlength="200" required>
    @error('title') <p class="bank-error">{{ $message }}</p> @enderror
</div>

<div class="bank-field">
    <label for="fin_category_id">Категория</label>
    <select id="fin_category_id" name="fin_category_id" required>
        <option value="">Выберите категорию</option>
        @foreach ($categories as $cat)
            <option value="{{ $cat->id }}" @selected((string) old('fin_category_id', $article->fin_category_id ?? '') === (string) $cat->id)>{{ $cat->name }}</option>
        @endforeach
    </select>
    @error('fin_category_id') <p class="bank-error">{{ $message }}</p> @enderror
</div>

<div class="bank-field">
    <label for="announce">Анонс (до 300 символов)</label>
    <textarea id="announce" name="announce" rows="3" maxlength="300" required>{{ old('announce', $article->announce ?? '') }}</textarea>
    @error('announce') <p class="bank-error">{{ $message }}</p> @enderror
</div>

<div class="bank-field">
    <label for="body">Текст статьи (абзацы разделяйте пустой строкой)</label>
    <textarea id="body" name="body" rows="12" required>{{ old('body', $article->body ?? '') }}</textarea>
    @error('body') <p class="bank-error">{{ $message }}</p> @enderror
</div>

<div class="bank-field">
    <label for="published_at">Дата публикации</label>
    <input id="published_at" type="date" name="published_at" value="{{ old('published_at', isset($article) ? $article->published_at->format('Y-m-d') : date('Y-m-d')) }}" required>
    @error('published_at') <p class="bank-error">{{ $message }}</p> @enderror
</div>
