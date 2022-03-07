<?php

namespace App\Services;

use App\Events\Developers\NewDeveloperAddedEvent;
use App\Models\Developer;
use Exception;
use Illuminate\Support\Facades\Http;

class DeveloperGithubProfileService
{
    private static function getDeveloperDetails($username): array
    {
            $response = Http::get(config('services.github.base_url') . '/users/' . $username);

            if (!$response->successful()) {
                throw new Exception($response->json('message'));
            }


            return $response->json();

    }
    public static function saveOrUpdateDeveloperDetails(string $username): Developer
    {
        $userDetails = static::getDeveloperDetails($username);

        $developer = Developer::updateOrcreate([
            'username' => $userDetails['login'],
        ],[
            'name' => $userDetails['name'],
            'company' => $userDetails['company'],
            'url' => $userDetails['html_url'],
        ]);

        event(new NewDeveloperAddedEvent($developer));

        return $developer;
    }
}
