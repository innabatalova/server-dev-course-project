<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'surname',
        'name',
        'patronymic',
        'gender',
        'birth_date',
        'phone',
        'address',
        'email',
        'comment',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
        ];
    }
}
