<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\PersonalAccessToken;
use Spatie\Permission\Models\Permission;

/**
 *
 *
 * @property int $id
 * @property string $name
 * @property string $username
 * @property string|null $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $team_id
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection<int, Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read Collection<int, Role> $roles
 * @property-read int|null $roles_count
 * @property-read Team|null $team
 * @property-read Collection<int, Team> $teams
 * @property-read int|null $teams_count
 * @property-read Collection<int, PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static Builder<static>|Member newModelQuery()
 * @method static Builder<static>|Member newQuery()
 * @method static Builder<static>|Member permission($permissions, $without = false)
 * @method static Builder<static>|Member query()
 * @method static Builder<static>|Member role($roles, $guard = null, $without = false)
 * @method static Builder<static>|Member whereCreatedAt($value)
 * @method static Builder<static>|Member whereEmail($value)
 * @method static Builder<static>|Member whereEmailVerifiedAt($value)
 * @method static Builder<static>|Member whereId($value)
 * @method static Builder<static>|Member whereName($value)
 * @method static Builder<static>|Member wherePassword($value)
 * @method static Builder<static>|Member whereRememberToken($value)
 * @method static Builder<static>|Member whereTeamId($value)
 * @method static Builder<static>|Member whereUpdatedAt($value)
 * @method static Builder<static>|Member whereUsername($value)
 * @method static Builder<static>|Member withoutPermission($permissions)
 * @method static Builder<static>|Member withoutRole($roles, $guard = null)
 * @mixin Eloquent
 */
class Member extends User
{
    protected $table = 'users';
}
