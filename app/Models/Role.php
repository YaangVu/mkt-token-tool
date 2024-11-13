<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Permission;

/**
 *
 *
 * @property int $id
 * @property int|null $team_id
 * @property string $name
 * @property string $guard_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read Team|null $team
 * @property-read Collection<int, User> $users
 * @property-read int|null $users_count
 * @method static Builder<static>|Role newModelQuery()
 * @method static Builder<static>|Role newQuery()
 * @method static Builder<static>|Role permission($permissions, $without = false)
 * @method static Builder<static>|Role query()
 * @method static Builder<static>|Role whereCreatedAt($value)
 * @method static Builder<static>|Role whereGuardName($value)
 * @method static Builder<static>|Role whereId($value)
 * @method static Builder<static>|Role whereName($value)
 * @method static Builder<static>|Role whereTeamId($value)
 * @method static Builder<static>|Role whereUpdatedAt($value)
 * @method static Builder<static>|Role withoutPermission($permissions)
 * @mixin Eloquent
 */
class Role extends \Spatie\Permission\Models\Role
{
    protected $connection = 'mysql';

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
