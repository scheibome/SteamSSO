# SteamSSO Plugin for Kirby 4

This plugin allows you to authenticate users via Steam OpenID.

## Installation

### Download

Download and copy this repository to `/site/plugins/steamsso`.

### Composer

```composer require scheibo/steamsso```

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

### Add Steam Login Button

Add the following code to your template:

```php
<?php snippet('steamsso/loginbutton') ?>
```

### Add Steam Logout Button

Add the following code to your template:

```php
<?php snippet('steamsso/logoutbutton') ?>
```

### Add Steam User Info

Add the following code to your template:

```php
<?php snippet('steamsso/userinfo') ?>
```

### Add stylesheet

Add the following code to your template:

```php
<?= css('site/plugins/steamsso/steamsso.css') ?>
```

