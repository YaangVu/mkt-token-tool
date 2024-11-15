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
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $created_by
 * @property int $sku_id
 * @property int $quantity
 * @property int|null $team_id
 * @property-read \App\Models\Sku $sku
 * @property-read \App\Models\Team|null $team
 * @property-read Collection<int, \App\Models\Token> $tokens
 * @property-read int|null $tokens_count
 * @property-read \App\Models\User $user
 * @method static Builder<static>|TokenDumpHistory newModelQuery()
 * @method static Builder<static>|TokenDumpHistory newQuery()
 * @method static Builder<static>|TokenDumpHistory query()
 * @method static Builder<static>|TokenDumpHistory whereCreatedAt($value)
 * @method static Builder<static>|TokenDumpHistory whereCreatedBy($value)
 * @method static Builder<static>|TokenDumpHistory whereId($value)
 * @method static Builder<static>|TokenDumpHistory whereQuantity($value)
 * @method static Builder<static>|TokenDumpHistory whereSkuId($value)
 * @method static Builder<static>|TokenDumpHistory whereTeamId($value)
 * @method static Builder<static>|TokenDumpHistory whereUpdatedAt($value)
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
