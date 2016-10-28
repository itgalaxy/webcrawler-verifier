<?php
namespace WebcrawlerVerifier\DNS;

use WebcrawlerVerifier\Helper\StringHelper as StringHelper;

class HostVerifier
{
    public static function verify($host, array $allowedHostNames)
    {
        return !!array_filter($allowedHostNames, function ($validHost) use ($host) {
            return StringHelper::endsWith($validHost, $host) !== false;
        });
    }
}
