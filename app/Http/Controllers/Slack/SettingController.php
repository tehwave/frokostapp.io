<?php

namespace App\Http\Controllers\Slack;

use App\Slack;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    /**
     * Show the editing page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(Slack $slack)
    {
        return view('settings')
            ->withSlack($slack);
    }

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
                'active'    => $request->active ?? false,
                'channel'   => $request->channel,
                'count'     => $request->count,
                'timeslot'  => $request->timeslot,
            ],
        ]);

        $request->session()->flash('toast', 'Settings freshly saved!');

        return redirect()->back();
    }
}
