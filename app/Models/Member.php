<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $username
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $team_id
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \App\Models\Team|null $team
 * @property-read \App\Models\Team|null $teams
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member newQuery()
 * @method static Builder<static>|Member permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member query()
 * @method static Builder<static>|Member role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereUsername($value)
 * @method static Builder<static>|Member withoutPermission($permissions)
 * @method static Builder<static>|Member withoutRole($roles, $guard = null)
 * @mixin \Eloquent
 */
class Member extends User
{
    protected $table = 'users';
}
