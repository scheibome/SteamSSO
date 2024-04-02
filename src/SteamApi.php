<?php

namespace Scheibo\SteamSSO;

/**
 * Class SteamApi
 *
 * This class is used to interact with the Steam API.
 */
class SteamApi {
    /**
     * @var string $apiKey The API key used to authenticate with the Steam API.
     */
    private $apiKey;

    /**
     * SteamApi constructor.
     *
     * @param string $apiKey The API key used to authenticate with the Steam API.
     */
    public function __construct($apiKey) {
        $this->apiKey = $apiKey;
    }

    /**
     * Fetches the user profile from the Steam API.
     *
     * @param string $steamID The Steam ID of the user.
     * @return array|false The user profile data, or false if the user profile could not be fetched.
     */
    public function getUserProfile(string $steamID): bool|array
    {
        $url = "https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key={$this->apiKey}&steamids={$steamID}";

        $response = file_get_contents($url);
        $data = json_decode($response, true);

        return $data['response']['players'][0] ?? false;
    }
}
