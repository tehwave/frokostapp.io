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
        {--force : Force the operation to skip any prompts}';

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

        Slack::when($this->argument('slack'), function ($query) {
                [$id, $limit] = array_pad(explode('-', $this->argument('slack')), 2, null);

                if (isset($limit)) {
                    if ($id > $limit) {
                        throw new InvalidArgumentException('The lower range must not be higher than the upper range.');
                    }

                    return $query->whereBetween('id', [$id, $limit]);
                }

                return $query->whereId($id);
            })
            ->where('settings->active', true)
            ->where('settings->timeslot', Carbon::now()->format('H:i'))
            ->each(function ($slack) use (&$teamsCount) {
                $api = (new SlackApi($slack->access_token));

                $onlineUsers = $api->onlineUsers();

                $howManyToChoose = $slack->setting('count', 1);

                if ($onlineUsers->count() < $howManyToChoose) {
                    return false;
                }

                $teamsCount++;

                $users = $onlineUsers
                    ->random($howManyToChoose)
                    ->transform(function ($user) {
                        return "@{$user['name']}";
                    })
                    ->toArray();

                App::setLocale($slack->setting('language', 'en'));

                $message = __('lunch.message.generic', ['user' => $this->naturalImplode($users)]);

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

    /**
     * Join a string with a natural language conjunction at the end.
     * https://gist.github.com/angry-dan/e01b8712d6538510dd9c.
     *
     * @param  array  $list
     * @param  string  $conjunction 'and'
     * @return string
     */
    public function naturalImplode(array $list, $conjunction = null)
    {
        $last = array_pop($list);

        if (empty($conjunction)) {
            $conjunction = __('lunch.conjunction');
        }

        if ($list) {
            return implode(', ', $list).' '.$conjunction.' '.$last;
        }

        return $last;
    }
}
