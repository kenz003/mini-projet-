<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eleve extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'grade',
        'phone',
        'user_id', // Foreign key linking to User
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
