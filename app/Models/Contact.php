<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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

    protected function shortName(): Attribute
    {
        return Attribute::get(function () {
            $initials = mb_substr($this->name, 0, 1) . '.';

            if ($this->patronymic) {
                $initials .= mb_substr($this->patronymic, 0, 1) . '.';
            }

            return $this->surname . ' ' . $initials;
        });
    }
}
