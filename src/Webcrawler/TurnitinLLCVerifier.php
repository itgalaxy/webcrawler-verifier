<?php
namespace WebcrawlerVerifier\Webcrawler;

use WebcrawlerVerifier\Helper\Range;

class TurnitinLLCVerifier implements VerifierInterface
{
    // https://www.turnitin.com/robot/crawlerinfo.html
    protected $allowedRanges = [
        '38.111.147.69-38.111.147.94',
        '199.47.82.133-199.47.82.254'
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
