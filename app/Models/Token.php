<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
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
 * @property string $token
 * @property string|null $original_json
 * @property string|null $signature
 * @property string|null $order_id
 * @property int $user_id
 * @property int $game_id
 * @property int $package_id
 * @property-read Game $game
 * @property-read Package $package
 * @property-read User $user
 * @method static Builder|Token newModelQuery()
 * @method static Builder|Token newQuery()
 * @method static Builder|Token query()
 * @method static Builder|Token whereCreatedAt($value)
 * @method static Builder|Token whereGameId($value)
 * @method static Builder|Token whereId($value)
 * @method static Builder|Token whereOrderId($value)
 * @method static Builder|Token whereOriginalJson($value)
 * @method static Builder|Token wherePackageId($value)
 * @method static Builder|Token whereSignature($value)
 * @method static Builder|Token whereToken($value)
 * @method static Builder|Token whereUpdatedAt($value)
 * @method static Builder|Token whereUserId($value)
 * @mixin Eloquent
 */
class Token extends Model
{
    protected $fillable = ['token', 'user_id', 'game_id', 'package_id', 'original_json', 'signature', 'order_id'];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
}
