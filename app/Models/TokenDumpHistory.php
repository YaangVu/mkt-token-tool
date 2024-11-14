<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @property-read \App\Models\Sku|null $sku
 * @property-read \App\Models\Team|null $team
 * @property-read Collection<int, \App\Models\Token> $tokens
 * @property-read int|null $tokens_count
 * @property-read \App\Models\User|null $user
 * @method static Builder<static>|TokenDumpHistory newModelQuery()
 * @method static Builder<static>|TokenDumpHistory newQuery()
 * @method static Builder<static>|TokenDumpHistory query()
 * @mixin Eloquent
 */
class TokenDumpHistory extends Model
{
    protected $fillable = ['created_by', 'sku_id', 'quantity', 'team_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function sku(): BelongsTo
    {
        return $this->belongsTo(Sku::class);
    }

    public function tokens(): HasMany
    {
        return $this->hasMany(Token::class, 'dump_history_id', 'id');
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
