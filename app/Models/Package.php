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
 * @property string|null $title
 * @property string|null $name
 * @property string $price
 * @property string|null $price_currency_code
 * @property string $product_id
 * @property string|null $game_name
 * @property string|null $type
 * @property int $user_id
 * @property-read Collection<int, \App\Models\Token> $tokens
 * @property-read int|null $tokens_count
 * @property-read \App\Models\User $user
 * @method static Builder<static>|Package newModelQuery()
 * @method static Builder<static>|Package newQuery()
 * @method static Builder<static>|Package query()
 * @method static Builder<static>|Package whereCreatedAt($value)
 * @method static Builder<static>|Package whereGameName($value)
 * @method static Builder<static>|Package whereId($value)
 * @method static Builder<static>|Package whereName($value)
 * @method static Builder<static>|Package wherePrice($value)
 * @method static Builder<static>|Package wherePriceCurrencyCode($value)
 * @method static Builder<static>|Package whereProductId($value)
 * @method static Builder<static>|Package whereTitle($value)
 * @method static Builder<static>|Package whereType($value)
 * @method static Builder<static>|Package whereUpdatedAt($value)
 * @method static Builder<static>|Package whereUserId($value)
 * @mixin Eloquent
 */
class Package extends Model
{
    protected $fillable = ['title', 'name', 'price', 'price_currency_code', 'product_id', 'game_name', 'type', 'user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Export tokens
    public function exportTokens(int $quantity, Package $package): TokenExportHistory
    {
        // Get tokens that have not been exported yet
        $tokens = $this->tokens()
            ->whereNull('export_history_id')
            ->orderBy('created_at')
            ->limit($quantity)
            ->get();

        // Create a new export history
        $exportHistory = TokenExportHistory::create([
            'user_id' => auth()->id(),
            'package_id' => $package->id,
            'quantity' => $quantity,
        ]);

        // Update the tokens to mark them as exported
        Token::whereIn('id', $tokens->pluck('id'))->update(['export_history_id' => $exportHistory->id]);

        return $exportHistory;
    }

    public function tokens(): HasMany
    {
        return $this->hasMany(Token::class);
    }

    public function team(): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this->morphToMany(Team::class, 'teamable');
    }
}
