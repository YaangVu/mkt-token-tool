<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $user_id
 * @property int $package_id
 * @property int $quantity
 * @property-read \App\Models\Package $package
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Token> $tokens
 * @property-read int|null $tokens_count
 * @property-read \App\Models\User $user
 * @method static Builder<static>|TokenExportHistory newModelQuery()
 * @method static Builder<static>|TokenExportHistory newQuery()
 * @method static Builder<static>|TokenExportHistory query()
 * @method static Builder<static>|TokenExportHistory whereCreatedAt($value)
 * @method static Builder<static>|TokenExportHistory whereId($value)
 * @method static Builder<static>|TokenExportHistory wherePackageId($value)
 * @method static Builder<static>|TokenExportHistory whereQuantity($value)
 * @method static Builder<static>|TokenExportHistory whereUpdatedAt($value)
 * @method static Builder<static>|TokenExportHistory whereUserId($value)
 * @mixin Eloquent
 */
class TokenExportHistory extends Model
{
    protected $fillable = ['user_id', 'package_id', 'quantity'];

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

      public function team(): MorphToMany
    {
        return $this->morphToMany(Team::class, 'teamable');
    }
}
