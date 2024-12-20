<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'position',
        'phone_number',
        'address',
    ];

    /**
     * Concatenate the full name from first, middle, and last name.
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        $middleName = $this->middle_name ? ' ' . $this->middle_name : '';
        return $this->first_name . $middleName . ' ' . $this->last_name;
    }
}