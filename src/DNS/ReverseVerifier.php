<?php
namespace WebcrawlerVerifier\DNS;

use WebcrawlerVerifier\Helper\StringHelper as StringHelper;

class ReverseVerifier
{
    public static function verify($ip, $allowedHostNames)
    {
        $host = gethostbyaddr($ip);
        $ipAfterLookup = gethostbyname($host);

        $hostIsValid = !!array_filter($allowedHostNames, function ($validHost) use ($host) {
            return StringHelper::endsWith($host, $validHost) !== false;
        });

        return $hostIsValid && $ipAfterLookup === $ip;
    }
}
