<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TokenImport extends Package
{
    protected $table = 'packages';


    public function tokens(): HasMany
    {
        return $this->hasMany(Token::class, 'package_id', 'id');
    }

    public function hasTokens(Builder $query): Builder
    {
        return $query->whereHas('tokens');
    }
//    {
//        $packageIds = Token::whereNotNull('export_history_id')->pluck('package_id');
//
//   }
}
