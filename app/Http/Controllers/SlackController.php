<?php

namespace App\Http\Controllers;

use Socialite;
use App\Slack;
use Illuminate\Http\Request;

class SlackController extends Controller
{
    /**
     * Redirect to authorize.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirect()
    {
        return Socialite::with('slack')
            ->scopes(['users:read', 'chat:write:bot'])
            ->redirect();
    }

    /**
     * Create Slack, and redirect to the settings.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function callback()
    {
        $result = Socialite::driver('slack')
            ->user()
            ->accessTokenResponseBody;

        $slack = Slack::updateOrCreate([
            'team_id'       => $result['team_id'],
        ], [
            'access_token'  => $result['access_token'],
            'team_name'     => $result['team_name'],
            'data'          => $result,
        ]);

        return redirect()->route('slack.settings.edit', [
            'slack' => $slack->uuid,
        ]);
    }
}
