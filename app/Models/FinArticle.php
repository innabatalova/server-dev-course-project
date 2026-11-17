<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FinArticle extends Model
{
    protected $fillable = [
        'fin_category_id', 'title', 'slug', 'announce', 'body', 'published_at', 'search',
    ];

    protected function casts(): array
    {
        return ['published_at' => 'date'];
    }

    // В адресе статьи используем slug (понятная ссылка), а не номер.
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(FinCategory::class, 'fin_category_id');
    }

    // Текст для поиска. SQLite не умеет сравнивать русские буквы без учёта регистра,
    // поэтому заранее храним всё в нижнем регистре и ищем по нему.
    public static function searchText(string $title, string $announce, string $body): string
    {
        return mb_strtolower($title . ' ' . $announce . ' ' . $body);
    }
}
