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
 * @property string $code
 * @property string $title
 * @property string $price
 * @property string|null $currency
 * @property string|null $type
 * @property int $user_id
 * @property int $game_id
 * @property-read Game $game
 * @property-read Collection<int, Token> $tokens
 * @property-read int|null $tokens_count
 * @property-read User $user
 * @method static Builder|Package newModelQuery()
 * @method static Builder|Package newQuery()
 * @method static Builder|Package query()
 * @method static Builder|Package whereCode($value)
 * @method static Builder|Package whereCreatedAt($value)
 * @method static Builder|Package whereCurrency($value)
 * @method static Builder|Package whereGameId($value)
 * @method static Builder|Package whereId($value)
 * @method static Builder|Package wherePrice($value)
 * @method static Builder|Package whereTitle($value)
 * @method static Builder|Package whereType($value)
 * @method static Builder|Package whereUpdatedAt($value)
 * @method static Builder|Package whereUserId($value)
 * @mixin Eloquent
 */
class Package extends Model
{
    protected $fillable = ['price', 'code', 'user_id', 'game_id', 'title', 'currency', 'type'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function tokens(): HasMany
    {
        return $this->hasMany(Token::class);
    }
}
