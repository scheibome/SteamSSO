<?php

namespace Scheibo\SteamSSO;

use JetBrains\PhpStorm\NoReturn;

/**
 * Class SteamAuth
 *
 * This class is used to handle the Steam OpenID authentication process.
 */
class SteamAuth {
    /**
     * Redirects the user to the Steam OpenID login page.
     *
     * This method constructs the OpenID parameters and redirects the user to the Steam OpenID login page.
     * After the user logs in, they will be redirected back to the return URL specified in the parameters.
     */
    #[NoReturn] public static function redirectToSteam(): void
    {
        $parameters = [
            'openid.ns' => 'http://specs.openid.net/auth/2.0',
            'openid.mode' => 'checkid_setup',
            'openid.return_to' => option('steam.loginUrl') . '/steam-auth',
            'openid.realm' => option('steam.loginUrl'),
            'openid.identity' => 'http://specs.openid.net/auth/2.0/identifier_select',
            'openid.claimed_id' => 'http://specs.openid.net/auth/2.0/identifier_select',
        ];

        header('Location: https://steamcommunity.com/openid/login?' . http_build_query($parameters));
        exit();
    }

    /**
     * Handles the return from the Steam OpenID login page.
     *
     * This method is called after the user is redirected back from the Steam OpenID login page.
     * It checks if the OpenID claimed ID matches the expected format for a Steam ID.
     * If it does, it returns the Steam ID. Otherwise, it returns false.
     *
     * @return string|false The Steam ID if the OpenID claimed ID matches the expected format, or false otherwise.
     */
    public static function handleReturn(): bool|string
    {
        if (preg_match("/^https?:\\/\\/steamcommunity\\.com\\/openid\\/id\\/(7[0-9]{15,25}+)$/", $_GET['openid_claimed_id'] ?? '', $matches)) {
            return $matches[1] ?? false;
        }
        return false;
    }
}
