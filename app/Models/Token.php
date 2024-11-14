<?php

namespace App\Models;

use Database\Factories\TokenFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
 * @property int $sku_id
 * @property int|null $team_id
 * @property int|null $export_history_id
 * @property-read User $owner
 * @property-read Sku $sku
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
 * @method static Builder<static>|Token wherePurchaseToken($value)
 * @method static Builder<static>|Token whereSignature($value)
 * @method static Builder<static>|Token whereSkuId($value)
 * @method static Builder<static>|Token whereTeamId($value)
 * @method static Builder<static>|Token whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Token extends Model
{
    use HasFactory;

    protected $fillable = ['purchase_token', 'original_json', 'signature', 'owner_id', 'sku_id', 'export_history_id', 'created_by'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function sku(): BelongsTo
    {
        return $this->belongsTo(Sku::class);
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

    protected function originalJson(): Attribute
    {
        return Attribute::make(
            get: fn() => json_decode($this->original_json, true),
            set: fn($value) => $this->original_json = json_encode($value),
        );
    }
}
