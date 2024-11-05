<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Carbon;

/**
 * 
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $purchase_token
 * @property string|null $original_json
 * @property string|null $signature
 * @property string|null $order_id
 * @property int $owner_id
 * @property int $created_by
 * @property int $package_id
 * @property int|null $export_history_id
 * @property-read \App\Models\User $owner
 * @property-read \App\Models\Package $package
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Team> $team
 * @property-read int|null $team_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Team> $teams
 * @property-read int|null $teams_count
 * @property-read \App\Models\User $user
 * @method static Builder<static>|Token newModelQuery()
 * @method static Builder<static>|Token newQuery()
 * @method static Builder<static>|Token query()
 * @method static Builder<static>|Token whereCreatedAt($value)
 * @method static Builder<static>|Token whereCreatedBy($value)
 * @method static Builder<static>|Token whereExportHistoryId($value)
 * @method static Builder<static>|Token whereId($value)
 * @method static Builder<static>|Token whereOrderId($value)
 * @method static Builder<static>|Token whereOriginalJson($value)
 * @method static Builder<static>|Token whereOwnerId($value)
 * @method static Builder<static>|Token wherePackageId($value)
 * @method static Builder<static>|Token wherePurchaseToken($value)
 * @method static Builder<static>|Token whereSignature($value)
 * @method static Builder<static>|Token whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Token extends Model
{
    protected $fillable = ['purchase_token', 'original_json', 'signature', 'order_id', 'owner_id', 'package_id', 'export_history_id', 'created_by'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function isExported(): bool
    {
        return $this->export_history_id !== null;
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function team(): MorphToMany
    {
        return $this->teams();
    }

    public function teams(): MorphToMany
    {
        return $this->morphToMany(Team::class, 'teamable');
    }
}
