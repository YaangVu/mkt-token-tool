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
 * @property string|null $title
 * @property string|null $name
 * @property string $price
 * @property string|null $price_currency_code
 * @property string $product_id
 * @property string|null $game_name
 * @property string|null $type
 * @property int $user_id
 * @property-read Collection<int, \App\Models\Team> $team
 * @property-read int|null $team_count
 * @property-read Collection<int, \App\Models\Team> $teams
 * @property-read int|null $teams_count
 * @property-read Collection<int, \App\Models\Token> $tokens
 * @property-read int|null $tokens_count
 * @property-read \App\Models\User $user
 * @method static Builder<static>|TokenImport newModelQuery()
 * @method static Builder<static>|TokenImport newQuery()
 * @method static Builder<static>|TokenImport query()
 * @method static Builder<static>|TokenImport whereCreatedAt($value)
 * @method static Builder<static>|TokenImport whereGameName($value)
 * @method static Builder<static>|TokenImport whereId($value)
 * @method static Builder<static>|TokenImport whereName($value)
 * @method static Builder<static>|TokenImport wherePrice($value)
 * @method static Builder<static>|TokenImport wherePriceCurrencyCode($value)
 * @method static Builder<static>|TokenImport whereProductId($value)
 * @method static Builder<static>|TokenImport whereTitle($value)
 * @method static Builder<static>|TokenImport whereType($value)
 * @method static Builder<static>|TokenImport whereUpdatedAt($value)
 * @method static Builder<static>|TokenImport whereUserId($value)
 * @mixin Eloquent
 */
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

    public function getMorphClass(): string
    {
        return Package::class;
    }
}
