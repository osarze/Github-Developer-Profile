<?php

namespace App\Listeners\Developers;

use App\Events\Developers\NewDeveloperAddedEvent;
use App\Models\Developer;
use App\Models\Repository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GetDevelopersRepositories
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\Developers\NewDeveloperAddedEvent  $event
     * @return void
     */
    public function handle(NewDeveloperAddedEvent $event)
    {
        $response = Http::get(config('services.github.base_url') . '/users/' . $event->developer->username . '/repos');


        if (!$response->successful()) {
            Log::error($response->body());

            return;
        }

        $responseData = $response->json();

        foreach ($responseData as $repository) {
            Repository::upDateOrCreate([
                'developer_id' => $event->developer->id,
                'github_repo_id' => $repository['id']
            ],[
                'name' => $repository['name'],
                'language' => $repository['language'],
            ]);
        }
    }
}
