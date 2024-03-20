<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CientCredential extends Model
{
    use HasFactory;
    protected $table = 'client_credential';
    protected $fillable = [
        'name',
        'tokenable_type',
        'tokenable_id',
        'token',
        'abilities',
        'last_used_at',
        'expires_at',
        'created_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function token()
    {
        return $this->hasMany(Token::class);
    }

    public function expires_at()
    {
        return $this->expires_at;
    }
}
