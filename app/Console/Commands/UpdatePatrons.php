<?php

namespace App\Console\Commands;

use App\Patron;
use App\PatronTier;
use Illuminate\Console\Command;
use Patreon\API;
use Patreon\AuthUrl;
use Patreon\OAuth;

class UpdatePatrons extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:patrons';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pulls info from Patreon to check patrons';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // reset every patron's tier
        Patron::query()->update([
            'tier_id' => null,
        ]);

        // fetch patron data
        $apiClient = new API(config('patreon.access_token'));

        foreach ($apiClient->fetch_campaigns()["data"] as $campaign) {

            $memberList = $apiClient->get_data('campaigns/' . $campaign['id'] . '/members', []);
            $this->processPatrons($apiClient, $memberList['data']);

            while (isset($memberList['links']) && isset($memberList['links']['next'])) {
                parse_str(parse_url($memberList['links']['next'], PHP_URL_QUERY), $params);
                $memberList = $apiClient->get_data('campaigns/' . $campaign['id'] . '/members', $params);
                $this->processPatrons($apiClient, $memberList['data']);
            }
        }
    }

    public function processPatrons($apiClient, $patrons)
    {
        foreach ($patrons as $patron) {
            $data = $apiClient->get_data('members/' . $patron['id'], [
                'include' => implode(',', [
                    'user',
                    'currently_entitled_tiers',
                    'member' => implode(',', [
                        'currently_entitled_tiers',
                    ]),
                ]),
                'fields' => [
                    'member' => implode(',', [
                        'full_name',
                        'patron_status',
                        'email',
                    ]),
                    'tier' => implode(',', [
                        'description',
                        'title',
                    ])
                ],
            ]);

            if ($data['data']['attributes']['email']) {
                $patronModel = Patron::whereEmail($data['data']['attributes']['email'])->first();

                if ($patronModel) {
                    $patronModel->update([
                        'name' => trim($data['data']['attributes']['full_name']),
                    ]);
                } else {
                    $patronModel = Patron::create([
                        'name' => trim($data['data']['attributes']['full_name']),
                        'email' => $data['data']['attributes']['email'],
                    ]);
                }

                foreach ($data['included'] as $object) {
                    if ($object['type'] === 'tier') {
                        $tierModel = PatronTier::whereName($object['attributes']['title'])->first();

                        if (!$tierModel) {
                            $tierModel = PatronTier::create([
                                'name' => $object['attributes']['title'],
                            ]);
                        }

                        $patronModel->tier_id = $tierModel->id;
                        $patronModel->save();
                    }
                }

                $this->info('Updated ' . $patronModel->name . ' patron');
            }
        }
    }
}
