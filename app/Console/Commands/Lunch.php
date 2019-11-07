<?php

namespace App\Console\Commands;

use App;
use Str;
use App\Slack;
use Carbon\Carbon;
use App\Library\SlackApi;
use InvalidArgumentException;
use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait as Confirmable;

class Lunch extends Command
{
    use Confirmable;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'frokost:lunch
        {slack? : The ID of the Slack or range of IDs}
        {--force : Force the operation to skip any prompts}
        {--now : Skip checking the timeslot}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pick some unlucky people to go make lunch!';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Confirm command if trying to sync everything.
        if (! $this->confirmToProceed('You are making lunch for all Slacks!', function () {
            return empty($this->argument('slack'));
        })) {
            return;
        }

        // Start.
        $this->comment(' Please wait...');

        // Pick lunch!
        $teamsCount = 0;

        Slack::where('settings->active', true)
            ->when($this->argument('slack'), function ($query, $input) {
                [$id, $limit] = array_pad(explode('-', $input), 2, null);

                if (isset($limit)) {
                    if ($id > $limit) {
                        throw new InvalidArgumentException('The lower range must not be higher than the upper range.');
                    }

                    return $query->whereBetween('id', [$id, $limit]);
                }

                return $query->whereId($id);
            })
            ->when($this->option('now'), function ($query) {
                return $query;
            }, function ($query) {
                return $query->where('settings->timeslot', Carbon::now()->format('H:i'));
            })
            ->each(function ($slack) use (&$teamsCount) {
                $api = (new SlackApi($slack->access_token));

                if ($slack->setting('presence') === 'active') {
                    $users = $api->activeUsers();
                } else {
                    $users = $api->users();
                }

                $howManyToChoose = $slack->setting('count', 1);

                if ($users->count() < $howManyToChoose) {
                    return false;
                }

                $teamsCount++;

                $losers = $users
                    ->random($howManyToChoose)
                    ->each(function ($user) use ($slack) {
                        $slack->statistics()->create([
                            'key' => 'lunch',
                            'value' => $user['name'],
                        ]);
                    })
                    ->transform(function ($user) {
                        return "@{$user['name']}";
                    })
                    ->join(', ', ' '.__('lunch.conjunction').' ');

                App::setLocale($slack->setting('language', 'en'));

                $message = __('lunch.message.generic', ['user' => $losers]);

                $api->post('chat.postMessage', [
                    'channel' => $slack->setting('channel', '#general'),
                    'text' => $message,
                    'link_names' => true,
                ]);
            });

        // End.
        $this->comment(sprintf(
            ' Lunch is on its way for %s %s!',
            $teamsCount,
            Str::plural('team', $teamsCount)
        ));
    }
}

