<?php
namespace WebcrawlerVerifier;

class WebcrawlerVerifier
{
    const UNKNOWN = -1;

    const UNVERIFIED = 0;

    const VERIFIED = 1;

    protected $webcrawlerVerifiers = [
        'Applebot' => 'WebcrawlerVerifier\Webcrawler\ApplebotVerifier',
        'Baiduspider' => 'WebcrawlerVerifier\Webcrawler\BaiduspiderVerifier',
        'bingbot' => 'WebcrawlerVerifier\Webcrawler\BingbotVerifier',
        'msnbot' => 'WebcrawlerVerifier\Webcrawler\BingbotVerifier',
        'adidxbot' => 'WebcrawlerVerifier\Webcrawler\BingbotVerifier',
        'BingPreview' => 'WebcrawlerVerifier\Webcrawler\BingbotVerifier',
        'Exabot' => 'WebcrawlerVerifier\Webcrawler\ExabotVerifier',
        'Google' => 'WebcrawlerVerifier\Webcrawler\GooglebotVerifier',
        'istellabot' => 'WebcrawlerVerifier\Webcrawler\IstellaBotVerifier',
        'Mail.RU_Bot' => 'WebcrawlerVerifier\Webcrawler\MailRUBotVerifier',
        'Mail.RU' => 'WebcrawlerVerifier\Webcrawler\MailRUBotVerifier',
        'Seznam' => 'WebcrawlerVerifier\Webcrawler\SeznamBotVerifier',
        'Yahoo! Slurp' => 'WebcrawlerVerifier\Webcrawler\YahooslurpVerifier',
        'Yandex' => 'WebcrawlerVerifier\Webcrawler\YandexbotVerifier'
    ];

    public function __construct(array $additionalWebcrawlerVerifiers = [])
    {
        $this->webcrawlerVerifiers = array_merge($this->webcrawlerVerifiers, $additionalWebcrawlerVerifiers);
    }

    public function verify($userAgent, $ip)
    {
        if (!is_string($userAgent)) {
            throw new \InvalidArgumentException('The User-agent should be string');
        }

        if (filter_var($ip, FILTER_VALIDATE_IP) === false) {
            throw new \InvalidArgumentException('The IP address is not valid: ' . $ip);
        }

        $verify = self::UNKNOWN;

        if (empty($userAgent)){
            return $verify;
        }

        foreach ($this->webcrawlerVerifiers as $pattern => $verifierClass) {
            if (stripos($userAgent, $pattern) !== false) {
                $verifier = new $verifierClass();

                $verify = $verifier->verify($ip) ? self::VERIFIED : self::UNVERIFIED;
            }
        }

        return $verify;
    }
}
