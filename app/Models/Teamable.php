<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 *
 *
 * @property-read Model|\Eloquent $teamable
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teamable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teamable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teamable query()
 * @mixin \Eloquent
 */
class Teamable extends Model
{
    protected $table = 'teamable';

    protected $fillable = ['team_id', 'teamable_type', 'teamable_id'];

    public function teamable(): MorphTo
    {
        return $this->morphTo();
    }
}
