<?php

namespace App\Http\Controllers;

use App\Models\FinArticle;
use App\Models\FinCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FinArticleController extends Controller
{
    // Лента статей: поиск (q) и фильтр по категории (category).
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $category = $request->query('category');

        $articles = FinArticle::with('category')
            ->when($category, fn ($query) => $query->whereHas(
                'category', fn ($c) => $c->where('slug', $category)
            ))
            ->when($q !== '', fn ($query) => $query->where('search', 'like', '%' . mb_strtolower($q) . '%'))
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->paginate(6)
            ->withQueryString();

        $categories = FinCategory::orderBy('id')->get();

        return view('bank.articles.index', compact('articles', 'categories', 'q', 'category'));
    }

    public function show(FinArticle $finArticle)
    {
        $finArticle->load('category');

        return view('bank.articles.show', compact('finArticle'));
    }

    public function create()
    {
        $categories = FinCategory::orderBy('id')->get();

        return view('bank.articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['search'] = FinArticle::searchText($data['title'], $data['announce'], $data['body']);

        $article = FinArticle::create($data);

        return redirect('/bank/articles/' . $article->slug)->with('success', 'Статья добавлена');
    }

    public function edit(FinArticle $finArticle)
    {
        $categories = FinCategory::orderBy('id')->get();

        return view('bank.articles.edit', compact('finArticle', 'categories'));
    }

    public function update(Request $request, FinArticle $finArticle)
    {
        $data = $this->validated($request);
        // Адрес (slug) при редактировании не меняем, чтобы не ломать ссылки.
        $data['search'] = FinArticle::searchText($data['title'], $data['announce'], $data['body']);

        $finArticle->update($data);

        return redirect('/bank/articles/' . $finArticle->slug)->with('success', 'Статья обновлена');
    }

    public function destroy(FinArticle $finArticle)
    {
        $finArticle->delete();

        return redirect('/bank/articles')->with('success', 'Статья удалена');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:200',
            'fin_category_id' => 'required|exists:fin_categories,id',
            'announce' => 'required|string|max:300',
            'body' => 'required|string|min:50',
            'published_at' => 'required|date|before_or_equal:today',
        ], [
            'title.required' => 'Введите заголовок статьи.',
            'title.max' => 'Заголовок не должен быть длиннее 200 символов.',
            'fin_category_id.required' => 'Выберите категорию.',
            'fin_category_id.exists' => 'Выбрана несуществующая категория.',
            'announce.required' => 'Напишите короткий анонс.',
            'announce.max' => 'Анонс не должен быть длиннее 300 символов.',
            'body.required' => 'Введите текст статьи.',
            'body.min' => 'Текст статьи должен быть не короче 50 символов.',
            'published_at.required' => 'Укажите дату публикации.',
            'published_at.date' => 'Дата указана неверно.',
            'published_at.before_or_equal' => 'Дата публикации не может быть в будущем.',
        ]);
    }

    private function uniqueSlug(string $title): string
    {
        $base = Str::slug($title) ?: 'article';
        $slug = $base;
        $i = 2;

        while (FinArticle::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}
