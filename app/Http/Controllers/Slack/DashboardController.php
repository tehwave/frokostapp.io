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
        /**
         * Get top 10 users with most lunch makings.
         *
         * @var \Illuminate\Support\Collection
         */
        $statistics = $slack->statistics()
            ->select('value')
            ->where('key', 'lunch')
            ->groupBy('value')
            ->selectRaw('count(*) as total')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        return view('dashboard')
            ->withSlack($slack)
            ->withStatistics($statistics);
    }
}
