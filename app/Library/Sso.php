<?php

namespace App\Library;

use App\Character;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use jbs1\OAuth2\Client\Provider\EveOnline;
use Mockery\Exception;

class Sso
{
    private static $provider = null;

    public static function provider()
    {
        if (static::$provider) {
            return static::$provider;
        }

        return static::$provider = new EveOnline([
            'clientId'                => config('app.eve_app_id'),
            'clientSecret'            => config('app.eve_app_secret'),
            'redirectUri'             => route("sso"),
        ]);
    }

    public static function characterSkillpoints(Character $character)
    {
        $key = 'skillpoints' . $character->id;
        $seconds = 120;

        return Cache::remember($key, $seconds, function () use ($character) {
            $config = \Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken($character->getToken());

            $apiInstance = new \Swagger\Client\Api\SkillsApi(
                new \GuzzleHttp\Client(),
                $config
            );

            try {
                $result = $apiInstance->getCharactersCharacterIdSkills($character->id, "tranquility", null, $character->getToken());
            } catch (\Swagger\Client\ApiException $e) {
                echo 'Exception when calling SkillsApi->getCharactersCharacterIdSkills: ', $e->getMessage(), PHP_EOL;
            }

            return $result->getTotalSp() + $result->getUnallocatedSp();
        });
    }
}