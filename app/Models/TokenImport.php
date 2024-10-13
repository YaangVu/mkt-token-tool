<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TokenImport extends Package
{
    protected $table = 'packages';


    public function tokens(): HasMany
    {
        return $this->hasMany(Token::class, 'package_id', 'id');
    }
}
