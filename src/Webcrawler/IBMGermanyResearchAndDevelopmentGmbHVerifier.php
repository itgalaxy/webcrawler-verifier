<?php
namespace WebcrawlerVerifier\Webcrawler;

use WebcrawlerVerifier\Helper\Range;

class IBMGermanyResearchAndDevelopmentGmbHVerifier implements VerifierInterface
{
    protected $allowedRanges = [
        '206.253.224.*',
        '194.153.113.*',
        '206.253.225.*',
        '206.253.226.*',
        '2001:1be0:1000:160:0:0:0:0/64',
        '2001:1be0:1000:167:0:0:0:0/64',
        '2001:1be0:1000:168:0:0:0:0/64',
        '2001:1be0:1000:169:0:0:0:0/64'
    ];

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
