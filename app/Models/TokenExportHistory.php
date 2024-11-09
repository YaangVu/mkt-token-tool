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
 * @property int $package_id
 * @property int $quantity
 * @property int|null $team_id
 * @property-read Package $package
 * @property-read Team|null $team
 * @property-read Collection<int, Token> $tokens
 * @property-read int|null $tokens_count
 * @property-read User|null $user
 * @method static Builder<static>|TokenExportHistory newModelQuery()
 * @method static Builder<static>|TokenExportHistory newQuery()
 * @method static Builder<static>|TokenExportHistory query()
 * @method static Builder<static>|TokenExportHistory whereCreatedAt($value)
 * @method static Builder<static>|TokenExportHistory whereCreatedBy($value)
 * @method static Builder<static>|TokenExportHistory whereId($value)
 * @method static Builder<static>|TokenExportHistory wherePackageId($value)
 * @method static Builder<static>|TokenExportHistory whereQuantity($value)
 * @method static Builder<static>|TokenExportHistory whereTeamId($value)
 * @method static Builder<static>|TokenExportHistory whereUpdatedAt($value)
 * @mixin Eloquent
 */
class TokenExportHistory extends Model
{
    protected $fillable = ['created_by', 'package_id', 'quantity'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function tokens(): HasMany
    {
        return $this->hasMany(Token::class, 'export_history_id', 'id');
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
