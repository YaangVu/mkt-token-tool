<?php

namespace App\Models;

use Eloquent;
use Filament\Models\Contracts\HasCurrentTenantLabel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $name
 * @property int $is_active
 * @property string|null $activated_at
 * @property string|null $expired_at
 * @property Carbon|null $deleted_at
 * @property int|null $created_by
 * @property float $coin
 * @property float $coin_requested
 * @property-read Collection<int, User> $members
 * @property-read int|null $members_count
 * @property-read Collection<int, Sku> $skus
 * @property-read int|null $skus_count
 * @property-read Collection<int, Token> $tokens
 * @property-read int|null $tokens_count
 * @property-read Collection<int, User> $users
 * @property-read int|null $users_count
 * @method static Builder<static>|Team newModelQuery()
 * @method static Builder<static>|Team newQuery()
 * @method static Builder<static>|Team onlyTrashed()
 * @method static Builder<static>|Team query()
 * @method static Builder<static>|Team whereActivatedAt($value)
 * @method static Builder<static>|Team whereCoin($value)
 * @method static Builder<static>|Team whereCoinRequested($value)
 * @method static Builder<static>|Team whereCreatedAt($value)
 * @method static Builder<static>|Team whereCreatedBy($value)
 * @method static Builder<static>|Team whereDeletedAt($value)
 * @method static Builder<static>|Team whereExpiredAt($value)
 * @method static Builder<static>|Team whereId($value)
 * @method static Builder<static>|Team whereIsActive($value)
 * @method static Builder<static>|Team whereName($value)
 * @method static Builder<static>|Team whereUpdatedAt($value)
 * @method static Builder<static>|Team withTrashed()
 * @method static Builder<static>|Team withoutTrashed()
 * @mixin Eloquent
 */
class Team extends Model implements HasCurrentTenantLabel
{
    use SoftDeletes;

    protected $fillable = ['name', 'activated_at', 'deleted_at', 'created_at', 'updated_at', 'created_by', 'is_active', 'coin', 'coin_requested'];

    public function members(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function skus(): HasMany
    {
        return $this->hasMany(Sku::class);
    }

    public function tokens(): HasMany
    {
        return $this->hasMany(Token::class);
    }

    public function getCurrentTenantLabel(): string
    {
        return $this->is_active ? 'Active team' : 'Inactive team';
    }

    public function addCoin(float $coin): static
    {
        $this->coin += $coin;
        $this->save();
        return $this;
    }
}
