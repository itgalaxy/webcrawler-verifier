<?php
namespace WebcrawlerVerifier\Helper;

class StringHelper
{
    public static function endsWith($haystack, $needle)
    {
        $length = strlen($needle);

        if ($length == 0) {
            return true;
        }

        return substr($haystack, -$length) === $needle;
    }
}
