<?php
namespace WebcrawlerVerifier;

class WebcrawlerVerifier
{
    const UNKNOWN = -1;

    const UNVERIFIED = 0;

    const VERIFIED = 1;

    protected $webcrawlerVerifiers = [
        'Applebot' => 'WebcrawlerVerifier\Webcrawler\AppleWebcrawlerVerifier',
        'Baiduspider' => 'WebcrawlerVerifier\Webcrawler\BaiduWebcrawlerVerifier',
        'bingbot' => 'WebcrawlerVerifier\Webcrawler\BingWebcrawlerVerifier',
        'msnbot' => 'WebcrawlerVerifier\Webcrawler\BingWebcrawlerVerifier',
        'adidxbot' => 'WebcrawlerVerifier\Webcrawler\BingWebcrawlerVerifier',
        'BingPreview' => 'WebcrawlerVerifier\Webcrawler\BingWebcrawlerVerifier',
        'DeuSu' => 'WebcrawlerVerifier\Webcrawler\DeusuWebcrawlerVerifier',
        'Exabot' => 'WebcrawlerVerifier\Webcrawler\ExaleadWebcrawlerVerifier',
        'Google' => 'WebcrawlerVerifier\Webcrawler\GoogleWebcrawlerVerifier',
        'GrapeshotCrawler' => 'WebcrawlerVerifier\Webcrawler\GrapeshotWebcrawlerVerifier',
        'istellabot' => 'WebcrawlerVerifier\Webcrawler\IstellaWebcrawlerVerifier',
        'Mail.RU_Bot' => 'WebcrawlerVerifier\Webcrawler\MailRUWebcrawlerVerifier',
        'Mail.RU' => 'WebcrawlerVerifier\Webcrawler\MailRUWebcrawlerVerifier',
        'Seznam' => 'WebcrawlerVerifier\Webcrawler\SeznamWebcrawlerVerifier',
        'SputnikBot' => 'WebcrawlerVerifier\Webcrawler\SputnikWebcrawlerVerifier',
        'Steeler' => 'WebcrawlerVerifier\Webcrawler\SteelerWebcrawlerVerifier',
        'Yahoo! Slurp' => 'WebcrawlerVerifier\Webcrawler\YahooWebcrawlerVerifier',
        'Yandex' => 'WebcrawlerVerifier\Webcrawler\YandexWebcrawlerVerifier',
        'YaDirectFetcher' => 'WebcrawlerVerifier\Webcrawler\YandexWebcrawlerVerifier'
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
