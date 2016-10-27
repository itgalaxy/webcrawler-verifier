# webcrawler-verifier

[![Latest Stable Version](https://poser.pugx.org/itgalaxy/webcrawler-verifier/v/stable)](
https://packagist.org/packages/itgalaxy/webcrawler-verifier)
[![Travis Build Status](https://img.shields.io/travis/itgalaxy/webcrawler-verifier/master.svg?label=build)
](https://travis-ci.org/itgalaxy/webcrawler-verifier)
[![Coverage Status](https://coveralls.io/repos/github/itgalaxy/webcrawler-verifier/badge.svg?branch=master)](
https://coveralls.io/github/itgalaxy/webcrawler-verifier?branch=master)
[![Dependency Status](https://www.versioneye.com/user/projects/5810b9c19cfcf7003790163f/badge.svg?style=flat-square)](
https://www.versioneye.com/user/projects/5810b9c19cfcf7003790163f)

Webcralwer-Verifier is a PHP library to ensure that robots are from the operator they claim to be, 
eg that Googlebot is actually coming from Google and not from some spoofer.

## Installation

### Install with Composer

If you're using [Composer](https://github.com/composer/composer) to manage dependencies, you can add Requests with it.

```sh
composer require itgalaxy/webcrawler-verifier
```

or
```json
{
    "require": {
        "itgalaxy/webcrawler-verifier": ">=1.0.0"
    }
}
```

## Usage

```php
<?php
require_once 'vendor/autoload.php';

$userAgent = 'Some user agent';
$ip = '192.168.0.1';

$webcrawlerVerifier = new \WebcrawlerVerifier\WebcrawlerVerifier();
$verifiedStatus = $webcrawlerVerifier->verify(
    $userAgent, 
    $ip
);

if ($verifiedStatus === $webcrawlerVerifier::VERIFIED) {
    echo 'Good webcrawler';
} elseif ($verifiedStatus === $webcrawlerVerifier::UNVERIFIED) {
    echo 'Bad webcrawler';
} else {
    // Alias `$verifiedStatus === $webcrawlerVerifier::UNKNOWN`
    echo 'Unknown good or bad wecrawler';
}

```

Or

```php
<?php
// This file is generated by Composer
require_once 'vendor/autoload.php';

if (!empty($_SERVER['HTTP_USER_AGENT']) && !empty($_SERVER['REMOTE_ADDR'])) {
    $webcrawlerVerifier = new \WebcrawlerVerifier\WebcrawlerVerifier();
    $verifiedStatus = $webcrawlerVerifier->verify(
        $_SERVER['HTTP_USER_AGENT'], 
        $_SERVER['REMOTE_ADDR']
    );

    if ($verifiedStatus === $webcrawlerVerifier::VERIFIED) {
        echo 'Good webcrawler';
    } elseif ($verifiedStatus === $webcrawlerVerifier::UNVERIFIED) {
        echo 'Bad webcrawler';
    } else {
        // Alias `$verifiedStatus === $webcrawlerVerifier::UNKNOWN`
        echo 'Unknown good or bad wecrawler';
    }
}
```

## Built in crawler detection

- **Apple**: `Applebot`.
- **Baidu**: `Baiduspider`.
- **Begun**: `BegunAdvertising`.
- **Bing**: `bingbot`, `msnbot`, `adidxbot`, `BingPreview`.
- **Deuse**: `DeuSu`.
- **Exalead**: `Exabot`.
- **Google**: `Googlebot`.
- **Grapeshot**: `GrapeshotCrawler`.
- **Tiscali.it**: `istellabot`.
- **Mail.ru**: `Mail.RU_Bot`, `Mail.RU`.
- **Searchme**: `Wotbox`.
- **Seznam.cz**: `SeznamBot`.
- **Sputni**: `SputnikBot`.
- **Steeler**: `Steeler`.
- **Twitter**: `Twitterbot`.
- **Yahoo**: `Yahoo! Slurp`.
- **Yandex**: `Yandexbot`, `YaDirectFetcher`.

Contributions are welcome.

## How it works

### Step one is identification.

If the user-agent identifies as one of the bots you are checking for, it goes into step 2 for verification.
If not, none is reported.

### Step two is verification.

The robot that was reported in the user-agent is verified by looking at the client's network address.
The big ones work with a combination of dns + reverse-dns lookup. That's not a hack, it's the officially
recommended way. The ip resolves to a hostname of the provider, and the hostname has a reverse dns entry
pointing back to that ip. This gives the crawler operators the freedom to to change and add networks
without risking of being locked out of websites.

The other method is to maintain lists of ip addresses. This is used for those operators that don't
officially endorse the first method. And it can optionally be used in combination with the first method
to avoid the one-time cost of the dns verification.

Except where it's required (for the 2nd method) this project does not maintain ip lists. The ones that
can currently be found on the internet all seem outdated. And that's exactly the problem... they will
always be lagging behind the ip ranges that the operators use.

## Contribution

Don't hesitate to create a pull request. Every contribution is appreciated.

## [Changelog](CHANGELOG.md)

## [License](LICENSE)
