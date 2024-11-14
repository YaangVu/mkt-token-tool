<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $game_name
 * @property string|null $package_name
 * @property string $price
 * @property string|null $price_currency_code
 * @property string $product_id
 * @property string|null $type
 * @property int $created_by
 * @property int|null $team_id
 * @property-read \App\Models\Team|null $team
 * @property-read Collection<int, \App\Models\Token> $tokens
 * @property-read int|null $tokens_count
 * @property-read \App\Models\User|null $user
 * @method static Builder<static>|TokenPump newModelQuery()
 * @method static Builder<static>|TokenPump newQuery()
 * @method static Builder<static>|TokenPump query()
 * @method static Builder<static>|TokenPump whereCreatedAt($value)
 * @method static Builder<static>|TokenPump whereCreatedBy($value)
 * @method static Builder<static>|TokenPump whereGameName($value)
 * @method static Builder<static>|TokenPump whereId($value)
 * @method static Builder<static>|TokenPump wherePackageName($value)
 * @method static Builder<static>|TokenPump wherePrice($value)
 * @method static Builder<static>|TokenPump wherePriceCurrencyCode($value)
 * @method static Builder<static>|TokenPump whereProductId($value)
 * @method static Builder<static>|TokenPump whereTeamId($value)
 * @method static Builder<static>|TokenPump whereType($value)
 * @method static Builder<static>|TokenPump whereUpdatedAt($value)
 * @mixin Eloquent
 */
class TokenPump extends Sku
{
    protected $table = 'skus';

    public function hasTokens(Builder $query): Builder
    {
        return $query->whereHas('tokens');
    }

    public function dumpableTokens(): HasMany
    {
        return $this->tokens()->whereNull('dump_history_id');
    }

    public function tokens(): HasMany
    {
        return $this->hasMany(Token::class, 'sku_id', 'id');
    }
}
