<?php

namespace App\Models;

use App\Constants\TokenStatuses;
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

    public function dumpTokens(int $quantity): Collection
    {
        // Get tokens that have not been exported yet
        $tokens = $this->tokens()
            ->whereNull('dump_history_id')
            ->orderBy('created_at')
            ->limit($quantity)
            ->get();

        // Create a new export history
        $dumpHistory = TokenDumpHistory::create([
            'created_by' => auth()->id(),
            'sku_id' => $this->id,
            'quantity' => $quantity,
            'team_id' => Filament::getTenant()->id,
        ]);

        // Update the tokens to mark them as exported
        Token::whereIn('id', $tokens->pluck('id'))->update(['dump_history_id' => $dumpHistory->id, 'status' => TokenStatuses::DUMPED]);

        // Decrease the quota of the team
        Filament::getTenant()->decrement('coin', $quantity);

        return $tokens;
    }

    public function tokens(): HasMany
    {
        $relationship = $this->hasMany(Token::class)->whereTeamId(Filament::getTenant()->id);

        return auth()->user()->can('viewAny', TokenDumpHistory::class) ? $relationship : $relationship->whereOwnerId(auth()->id());
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function dumpableTokens(): HasMany
    {
        return $this->tokens()->whereNull('dump_history_id')->whereStatus(TokenStatuses::NEW);
    }
}
