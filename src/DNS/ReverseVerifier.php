<?php
namespace WebcrawlerVerifier\DNS;

class ReverseVerifier
{
    public static function verify($ip, $allowedHostNames)
    {
        $host = gethostbyaddr($ip);
        $ipAfterLookup = gethostbyname($host);

        return HostVerifier::verify($host, $allowedHostNames) && $ipAfterLookup === $ip;
    }
}
