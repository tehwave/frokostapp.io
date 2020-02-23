<?php

namespace App\Http\Controllers\Slack;

use App\Slack;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    /**
     * Update the settings
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Slack $slack
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function update(Request $request, Slack $slack)
    {
        $slack->update([
            'settings' => [
                'active'    => $request->filled('active'),
                'presence'  => $request->presence,
                'channel'   => $request->channel,
                'count'     => $request->count,
                'timeslot'  => $request->timeslot,
                'dayslot'   => $request->dayslot ?? Carbon::getDays(),
                'language'  => $request->language,
            ],
        ]);

        $request->session()->flash('toast', 'Settings freshly saved!');

        return redirect()->back();
    }
}
