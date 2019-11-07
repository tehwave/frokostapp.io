<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    /**
     * Indicates if all mass assignment is enabled.
     *
     * @var bool
     */
    protected static $unguarded = true;

    /**
     * Get the owning statistical model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function statistical()
    {
        return $this->morphTo();
    }

    /**
     * Decode the value to an array.
     *
     * @return array
     */
    public function getValuesAttribute()
    {
        return json_decode($this->value, true);
    }
}
