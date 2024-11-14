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
 * @property-read Team|null $team
 * @property-read Collection<int, Token> $tokens
 * @property-read int|null $tokens_count
 * @property-read User|null $user
 * @method static Builder<static>|TokenImport newModelQuery()
 * @method static Builder<static>|TokenImport newQuery()
 * @method static Builder<static>|TokenImport query()
 * @method static Builder<static>|TokenImport whereCreatedAt($value)
 * @method static Builder<static>|TokenImport whereCreatedBy($value)
 * @method static Builder<static>|TokenImport whereGameName($value)
 * @method static Builder<static>|TokenImport whereId($value)
 * @method static Builder<static>|TokenImport wherePackageName($value)
 * @method static Builder<static>|TokenImport wherePrice($value)
 * @method static Builder<static>|TokenImport wherePriceCurrencyCode($value)
 * @method static Builder<static>|TokenImport whereProductId($value)
 * @method static Builder<static>|TokenImport whereTeamId($value)
 * @method static Builder<static>|TokenImport whereType($value)
 * @method static Builder<static>|TokenImport whereUpdatedAt($value)
 * @mixin Eloquent
 */
class TokenImport extends Sku
{
    protected $table = 'skus';


    public function tokens(): HasMany
    {
        return $this->hasMany(Token::class, 'sku_id', 'id');
    }

    public function hasTokens(Builder $query): Builder
    {
        return $query->whereHas('tokens');
    }
}
