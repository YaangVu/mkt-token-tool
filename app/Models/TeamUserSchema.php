<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property int $team_id
 * @property int $user_id
 * @property int $role_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamUserSchema newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamUserSchema newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamUserSchema query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamUserSchema whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamUserSchema whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamUserSchema whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamUserSchema whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamUserSchema whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TeamUserSchema whereUserId($value)
 * @mixin \Eloquent
 */
class TeamUserSchema extends Model
{
    protected $fillable = ['team_id', 'user_id', 'role_id'];
}
