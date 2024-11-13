<?php

namespace App\Models;

use Database\Factories\TokenFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use MongoDB\Laravel\Eloquent\Model;

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
 * @property int|null $team_id
 * @property int|null $export_history_id
 * @property-read User $owner
 * @property-read Package $package
 * @property-read Team|null $team
 * @property-read User $user
 * @method static TokenFactory factory($count = null, $state = [])
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
 * @method static Builder<static>|Token whereTeamId($value)
 * @method static Builder<static>|Token whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Token extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';

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

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
