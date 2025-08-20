<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublicServant extends Model
{
    protected $fillable = [
        'name',
        'registration',
        'cpf',

        'email',
        'phone',
        'department',
        'position',
        'job_function',
        'active',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

