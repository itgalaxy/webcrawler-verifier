<?php
namespace WebcrawlerVerifier\Helper;

class StringHelper
{
    public static function endsWith($needle, $haystack)
    {
        $length = strlen($needle);

        if ($length == 0) {
            return true;
        }

        return substr($haystack, -$length) === $needle;
    }
}
