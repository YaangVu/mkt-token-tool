<?php

namespace App\Models;

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
 * @property string|null $title
 * @property string|null $name
 * @property string $price
 * @property string|null $price_currency_code
 * @property string $product_id
 * @property string|null $game_name
 * @property string|null $type
 * @property int $created_by
 * @property int|null $team_id
 * @property-read \App\Models\Team|null $team
 * @property-read Collection<int, \App\Models\Team> $teams
 * @property-read int|null $teams_count
 * @property-read Collection<int, \App\Models\Token> $tokens
 * @property-read int|null $tokens_count
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\PackageFactory factory($count = null, $state = [])
 * @method static Builder<static>|Package newModelQuery()
 * @method static Builder<static>|Package newQuery()
 * @method static Builder<static>|Package query()
 * @method static Builder<static>|Package whereCreatedAt($value)
 * @method static Builder<static>|Package whereCreatedBy($value)
 * @method static Builder<static>|Package whereGameName($value)
 * @method static Builder<static>|Package whereId($value)
 * @method static Builder<static>|Package whereName($value)
 * @method static Builder<static>|Package wherePrice($value)
 * @method static Builder<static>|Package wherePriceCurrencyCode($value)
 * @method static Builder<static>|Package whereProductId($value)
 * @method static Builder<static>|Package whereTeamId($value)
 * @method static Builder<static>|Package whereTitle($value)
 * @method static Builder<static>|Package whereType($value)
 * @method static Builder<static>|Package whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Package extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'name', 'price', 'price_currency_code', 'product_id', 'game_name', 'type', 'created_by'];

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
            'created_by' => auth()->id(),
            'package_id' => $package->id,
            'quantity' => $quantity,
        ]);

        $exportHistory->teams()->attach(Filament::getTenant(), ['created_at' => now(), 'updated_at' => now()]);

        // Update the tokens to mark them as exported
        Token::whereIn('id', $tokens->pluck('id'))->update(['export_history_id' => $exportHistory->id]);

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
