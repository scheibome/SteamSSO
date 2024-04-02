<?php

namespace Scheibo\SteamSSO;

use Kirby\Exception\PermissionException;

/**
 * Class Helpers
 *
 * This class provides helper methods for user authentication and redirection.
 */
class Helpers {
    /**
     * Logs in a user without a password.
     *
     * @param mixed $user The user to log in.
     * @throws PermissionException If the user does not have permission to log in.
     * @return bool True if the user was logged in successfully, false otherwise.
     */
    public static function loginUser(mixed $user): bool
    {
        if ($user instanceof \Kirby\Cms\User) {
            $user->loginPasswordless();
            return true;
        }

        return false;
    }

    /**
     * Redirects the user to the home page.
     */
    public static function redirectHome(): void
    {
        go('/');
    }

    /**
     * Logs out the current user and redirects them to the home page.
     */
    public static function logoutUser(): void
    {
        kirby()->user()?->logout();
        self::redirectHome();
    }
}
