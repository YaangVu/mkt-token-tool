<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @property int $id
 * @property int $team_id
 * @property int $user_id
 * @property int $role_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder<static>|TeamUserSchema newModelQuery()
 * @method static Builder<static>|TeamUserSchema newQuery()
 * @method static Builder<static>|TeamUserSchema query()
 * @method static Builder<static>|TeamUserSchema whereCreatedAt($value)
 * @method static Builder<static>|TeamUserSchema whereId($value)
 * @method static Builder<static>|TeamUserSchema whereRoleId($value)
 * @method static Builder<static>|TeamUserSchema whereTeamId($value)
 * @method static Builder<static>|TeamUserSchema whereUpdatedAt($value)
 * @method static Builder<static>|TeamUserSchema whereUserId($value)
 * @mixin Eloquent
 */
class TeamUserSchema extends Model
{
    protected $fillable = ['team_id', 'user_id', 'role_id'];

    // block create_at and updated_at when seeding
    public $timestamps = false;
}
