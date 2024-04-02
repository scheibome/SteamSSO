# SteamSSO Plugin

This plugin allows you to authenticate users via Steam OpenID.

## Installation

### Download

Download and copy this repository to `/site/plugins/steam-sso`.

### Composer

```composer require scheibo/steam-sso```

## Configuration

### Steam API Key

You need to get a Steam API Key from [Steam](https://steamcommunity.com/dev/apikey).

### Kirby Configuration

Add the following configuration to your `site/config/config.php`:

```php
return [
    'steam' => [
        'apiKey' => '',
        'loginUrl' => 'https://www.example.com',
        'emailDomain' => 'steamuser@example.com',
        'role' => 'steamuser',
    ],
];
```
