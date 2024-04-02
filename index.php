<?php

require_once __DIR__ . '/src/SteamAuth.php';
require_once __DIR__ . '/src/SteamApi.php';
require_once __DIR__ . '/src/UserManager.php';
require_once __DIR__ . '/src/Helpers.php'; // Neue Zeile

use Scheibo\SteamSSO\SteamAuth;
use Scheibo\SteamSSO\SteamApi;
use Scheibo\SteamSSO\UserManager;
use Scheibo\SteamSSO\Helpers; // Neue Zeile

Kirby::plugin('scheibo/steam-sso', [
    'blueprints' => [
        'users/steamuser' => __DIR__ . '/blueprints/users/steamuser.yml'
    ],
    'routes' => [
        [
            'pattern' => 'steam-login',
            'method' => 'GET',
            'action'  => function () {
                return SteamAuth::redirectToSteam();
            }
        ],
        [
            'pattern' => 'steam-logout',
            'method' => 'GET',
            'action'  => function () {
                return Helpers::logoutUser();
            }
        ],
        [
            'pattern' => 'steam-auth',
            'method' => 'GET',
            'action'  => function () {
                $result = SteamAuth::handleReturn();
                if ($result) {
                    $apiKey = kirby()->option('steam.apiKey');
                    $steamApi = new SteamApi($apiKey);
                    $user = UserManager::createUserFromSteamProfile($steamApi, $result);

                    if ($user) {
                        // Erfolgreiche Benutzererstellung oder -findung
                        if (Helpers::loginUser($user)) {
                            // Benutzer erfolgreich eingeloggt
                            Helpers::redirectHome(); // Umleitung auf die Startseite
                        } else {
                            // Fehler beim Einloggen des Benutzers
                            return [
                                'status' => 500,
                                'body' => 'Fehler beim Einloggen des Benutzers.'
                            ];
                        }
                    } else {
                        // Fehler beim Erstellen des Benutzers
                        return [
                            'status' => 500,
                            'body' => 'Fehler beim Erstellen des Benutzers.'
                        ];
                    }
                } else {
                    return [
                        'status' => 400,
                        'body' => 'Steam Authentifizierung fehlgeschlagen.'
                    ];
                }
            }
        ]
    ]
]);
