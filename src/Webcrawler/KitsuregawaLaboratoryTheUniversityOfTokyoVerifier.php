<?php
namespace WebcrawlerVerifier\Webcrawler;

use WebcrawlerVerifier\Helper\Range;

class KitsuregawaLaboratoryTheUniversityOfTokyoVerifier implements VerifierInterface
{
    protected $allowedRanges = ['157.82.156.129-157.82.156.254'];

    /**
     * Checks whether the given IP address really belongs to a valid host or not
     *
     * @param $ip string the IP address to check
     * @return bool true if the given IP belongs to any of the valid hosts, otherwise false
     */
    public function verify($ip)
    {
        return Range::inRange($ip, $this->allowedRanges);
    }
}
