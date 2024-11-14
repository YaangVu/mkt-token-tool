<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $team_id
 * @property int $user_id
 * @property int $role_id
 * @method static Builder<static>|TeamUserSchema newModelQuery()
 * @method static Builder<static>|TeamUserSchema newQuery()
 * @method static Builder<static>|TeamUserSchema query()
 * @method static Builder<static>|TeamUserSchema whereId($value)
 * @method static Builder<static>|TeamUserSchema whereRoleId($value)
 * @method static Builder<static>|TeamUserSchema whereTeamId($value)
 * @method static Builder<static>|TeamUserSchema whereUserId($value)
 * @mixin Eloquent
 */
class TeamUserSchema extends Model
{
    public $timestamps = false;

    // block create_at and updated_at when seeding
    protected $fillable = ['team_id', 'user_id', 'role_id'];
}
