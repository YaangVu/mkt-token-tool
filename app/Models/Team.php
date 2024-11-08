<?php

namespace App\Models;

use Filament\Models\Contracts\HasCurrentTenantLabel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property int $is_active
 * @property string|null $activated_at
 * @property string|null $expired_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $created_by
 * @property float $coin
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $members
 * @property-read int|null $members_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Package> $packages
 * @property-read int|null $packages_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Token> $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereActivatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereCoin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereExpiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team withoutTrashed()
 * @mixin \Eloquent
 */
class Team extends Model implements HasCurrentTenantLabel
{
    use SoftDeletes;

    protected $fillable = ['name', 'activated_at', 'deleted_at', 'created_at', 'updated_at', 'created_by', 'is_active', 'coin'];

    public function members(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function packages(): HasMany
    {
        return $this->hasMany(Package::class);
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
