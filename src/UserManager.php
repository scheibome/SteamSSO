<?php

namespace Scheibo\SteamSSO;

/**
 * Class UserManager
 *
 * This class is used to manage users in the application.
 */
class UserManager
{
    /**
     * Creates a user from a Steam profile.
     *
     * This method fetches the user profile from the Steam API using the provided Steam ID.
     * If a user with the same email already exists, it updates the user's name and profile URL.
     * If no such user exists, it creates a new user with the Steam profile information.
     *
     * @param SteamApi $steamApi The Steam API instance.
     * @param string $steamId The Steam ID of the user.
     * @return \Kirby\Cms\User|false The created or updated user, or false if the user profile could not be fetched.
     */
    public static function createUserFromSteamProfile(SteamApi $steamApi, string $steamId): \Kirby\Cms\User|bool
    {
        $userProfile = $steamApi->getUserProfile($steamId);
        if (!$userProfile) return false;

        $emailDomain = option('steam.emailDomain');
        $email = "{$steamId}-" . $emailDomain;
        $user = kirby()->users()->findBy('email', $email);

        $role = option('steam.role');
        if (!$role) {
            $role = 'default';
        }

        kirby()->impersonate('kirby');

        if ($user) {
            if ($user->name() !== $userProfile['personaname']) {
                $user->changeName($userProfile['personaname']);
            }

            if ($role !== $user->role()) {
                $user->changeRole($role);
            }

            $user->update([
                'profileUrl' => $userProfile['profileurl'],
                'avatar' => $userProfile['avatarfull'] ?? null,
            ]);

            return $user;
        }

        try {
            $user = kirby()->users()->create([
                'email' => $email,
                'name' => $userProfile['personaname'],
                'password' => \Str::random(30),
                'language' => 'de',
                'role' => $role,
                'content' => [
                    'steamid' => $steamId,
                    'profileUrl' => $userProfile['profileurl'],
                    'avatar' => $userProfile['avatarfull'] ?? null
                ],
            ]);

            return $user;
        } catch (\Exception $e) {
            error_log('Error creating user: ' . $e->getMessage());
            return false;
        }
    }
}
