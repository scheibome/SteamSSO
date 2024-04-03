<?php

require __DIR__ . '/vendor/autoload.php';

// Import the necessary classes for Steam SSO
use Scheibo\SteamSSO\SteamAuth;
use Scheibo\SteamSSO\SteamApi;
use Scheibo\SteamSSO\UserManager;
use Scheibo\SteamSSO\Helpers;

// Register the Steam SSO plugin with Kirby
Kirby::plugin('scheibo/steamsso', [
    // Define the blueprints for the plugin
    'blueprints' => [
        'users/steamuser' => __DIR__ . '/blueprints/users/steamuser.yml'
    ],
    // Define the snippets for the plugin
    'snippets' => [
        'steamsso/loginbutton' => __DIR__ . '/snippets/loginbutton.php',
        'steamsso/logoutbutton' => __DIR__ . '/snippets/logoutbutton.php',
        'steamsso/userinfo' => __DIR__ . '/snippets/userinfo.php',
    ],
    // Define the translations for the plugin
    'translations' => [
        'de' => require __DIR__ . '/languages/de.php',
        'en' => require __DIR__ . '/languages/en.php'
    ],
    // Define the routes for the plugin
    'routes' => [
        // Route for logging in with Steam
        [
            'pattern' => 'steam-login',
            'method' => 'GET',
            'action'  => function () {
                return SteamAuth::redirectToSteam();
            }
        ],
        // Route for logging out
        [
            'pattern' => 'steam-logout',
            'method' => 'GET',
            'action'  => function () {
                return Helpers::logoutUser();
            }
        ],
        // Route for handling the return from Steam
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
                        if (Helpers::loginUser($user)) {
                            Helpers::redirectHome();
                        } else {
                            return [
                                'status' => 500,
                                'body' => t('steamsso.user.login.error')
                            ];
                        }
                    } else {
                        return [
                            'status' => 500,
                            'body' => t('steamsso.user.create.error')
                        ];
                    }
                } else {
                    return [
                        'status' => 400,
                        'body' => t('steamsso.auth.failed')
                    ];
                }
            }
        ]
    ]
]);
