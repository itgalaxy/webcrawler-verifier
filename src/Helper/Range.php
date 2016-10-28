<?php
namespace WebcrawlerVerifier\Helper;

use IPTools\IP as IPToolsIp;
use IPTools\Range as IPToolsRange;

class Range
{
    public static function inRange($ip, array $ranges = [])
    {
        $verified = false;

        foreach($ranges as $range) {
            $verified = IPToolsRange::parse($range)->contains(new IPToolsIp($ip));

            if ($verified) {
                break;
            }
        }

        return $verified;
    }
}
