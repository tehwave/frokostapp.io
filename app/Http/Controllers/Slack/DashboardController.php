<?php

namespace App\Http\Controllers\Slack;

use App\Slack;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Slack $slack
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Slack $slack)
    {
        return view('dashboard')
            ->withSlack($slack);
    }
}
