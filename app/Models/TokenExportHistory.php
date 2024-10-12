<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
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
 * @property int $user_id
 * @property int $game_id
 * @property int $package_id
 * @property int $quantity
 * @property-read \App\Models\Game $game
 * @property-read \App\Models\Package $package
 * @property-read \App\Models\User $user
 * @method static Builder|TokenExportHistory newModelQuery()
 * @method static Builder|TokenExportHistory newQuery()
 * @method static Builder|TokenExportHistory query()
 * @method static Builder|TokenExportHistory whereCreatedAt($value)
 * @method static Builder|TokenExportHistory whereGameId($value)
 * @method static Builder|TokenExportHistory whereId($value)
 * @method static Builder|TokenExportHistory wherePackageId($value)
 * @method static Builder|TokenExportHistory whereQuantity($value)
 * @method static Builder|TokenExportHistory whereUpdatedAt($value)
 * @method static Builder|TokenExportHistory whereUserId($value)
 * @mixin Eloquent
 */
class TokenExportHistory extends Model
{
    protected $fillable = ['user_id', 'game_id', 'package_id', 'quantity'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function tokens(): HasMany
    {
        return $this->hasMany(Token::class, 'export_history_id', 'id');
    }
}
