<?php

namespace App\Models;

use Database\Factories\SkuFactory;
use Eloquent;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
 * @method static \Database\Factories\SkuFactory factory($count = null, $state = [])
 * @method static Builder<static>|Sku newModelQuery()
 * @method static Builder<static>|Sku newQuery()
 * @method static Builder<static>|Sku query()
 * @method static Builder<static>|Sku whereCreatedAt($value)
 * @method static Builder<static>|Sku whereCreatedBy($value)
 * @method static Builder<static>|Sku whereGameName($value)
 * @method static Builder<static>|Sku whereId($value)
 * @method static Builder<static>|Sku wherePackageName($value)
 * @method static Builder<static>|Sku wherePrice($value)
 * @method static Builder<static>|Sku wherePriceCurrencyCode($value)
 * @method static Builder<static>|Sku whereProductId($value)
 * @method static Builder<static>|Sku whereTeamId($value)
 * @method static Builder<static>|Sku whereType($value)
 * @method static Builder<static>|Sku whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Sku extends Model
{
    use HasFactory;

    protected $fillable = ['package_name', 'price', 'price_currency_code', 'product_id', 'game_name', 'type', 'created_by'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Export tokens
    public function exportTokens(int $quantity, Sku $sku): TokenDumpHistory
    {
        // Get tokens that have not been exported yet
        $tokens = $this->tokens()
            ->whereNull('dump_history_id')
            ->orderBy('created_at')
            ->limit($quantity)
            ->get();

        // Create a new export history
        $exportHistory = TokenDumpHistory::create([
            'created_by' => auth()->id(),
            'sku_id' => $sku->id,
            'quantity' => $quantity,
            'team_id' => Filament::getTenant()->id,
        ]);

        // Update the tokens to mark them as exported
        Token::whereIn('id', $tokens->pluck('id'))->update(['dump_history_id' => $exportHistory->id]);

        return $exportHistory;
    }

    public function tokens(): HasMany
    {
        return $this->hasMany(Token::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
