<?php

namespace App;

use Str;
use Exception;
use Slack as SlackApi;
use Illuminate\Database\Eloquent\Model;

class Slack extends Model
{
    /**
     * Indicates if all mass assignment is enabled.
     *
     * @var bool
     */
    protected static $unguarded = true;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'data'      => 'array',
        'settings'  => 'array',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::orderedUuid();
        });
    }

    /**
     * Retrieve the statistics.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function statistics()
    {
        return $this->morphMany('App\Statistic', 'statistical');
    }

    /**
     * Retrieve or set settings.
     *
     * @return array
     */
    public function setting()
    {
        $arguments = func_get_args();

        if (is_string($arguments[0])) {
            $setting = $this->settings[$arguments[0]] ?? null;

            if (isset($setting)) {
                return $setting;
            }

            return $arguments[1] ?? null;
        }

        if (! is_array($arguments[0])) {
            throw new Exception(
                'When setting a value in the setttngs, you must pass an array of key / value pairs.'
            );
        }

        $this->update([
            'settings' => array_merge($this->settings, $arguments[0]),
        ]);

        return $this->settings;
    }

    /**
     * Retrieve an instance of Slack API wrapper,
     * and set up the access token for it.
     *
     * @return \App\Services\Slack\Slack
     */
    public function api()
    {
        return SlackApi::setAccessToken($this->access_token);
    }
}
