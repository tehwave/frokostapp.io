<?php

namespace App\Http\Controllers\Slack;

use App\Slack;
use App\Http\Controllers\Controller;
use App\Http\Requests\Slack\MessageRequest;

class MessageController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\Slack\MessageRequest      $request
     * @param  \App\Slack                                   $slack
     * @return \Illuminate\Http\Response
     */
    public function __invoke(MessageRequest $request, Slack $slack)
    {
        $api = $slack->api();

        $channel = $slack->setting('channel', '#general');

        $api->post('conversations.join', [
            'channel' => $channel,
        ]);

        $api->post('chat.postMessage', [
            'channel' => $channel,
            'text' => $request->message,
            'link_names' => true,
        ]);

        return redirect()->back();
    }
}
