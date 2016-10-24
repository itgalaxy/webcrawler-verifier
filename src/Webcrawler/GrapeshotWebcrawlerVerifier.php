<?php
namespace WebcrawlerVerifier\Webcrawler;

use IPTools\IP;
use IPTools\Range;

class GrapeshotWebcrawlerVerifier implements WebcrawlerVerifierInterface
{
    protected $allowedRanges = ['89.145.95.0/24'];

    /**
     * Checks whether the given IP address really belongs to a valid host or not
     *
     * @param $ip string the IP address to check
     * @return bool true if the given IP belongs to any of the valid hosts, otherwise false
     */
    public function verify($ip)
    {
        if (is_string($this->allowedRanges)) {
            return Range::parse($this->allowedRanges)->contains(new IP($ip));
        }

        $verified = false;

        foreach($this->allowedRanges as $range) {
            $verified = Range::parse($range)->contains(new IP($ip));

            if ($verified) {
                break;
            }
        }

        return $verified;
    }
}
