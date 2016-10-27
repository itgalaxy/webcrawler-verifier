<?php
namespace WebcrawlerVerifier\Webcrawler;

use WebcrawlerVerifier\DNS\HostVerifier;

class BegunWebcrawlerVerifier implements WebcrawlerVerifierInterface
{
    protected $allowedHostNames = ['begun.ru'];

    /**
     * Checks whether the given IP address really belongs to a valid host or not
     *
     * @param $ip string the IP address to check
     * @return bool true if the given IP belongs to any of the valid hosts, otherwise false
     */
    public function verify($ip)
    {
        return HostVerifier::verify(gethostbyaddr($ip), $this->allowedHostNames);
    }
}
