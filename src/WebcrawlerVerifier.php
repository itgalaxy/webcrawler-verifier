<?php
namespace WebcrawlerVerifier;

class WebcrawlerVerifier
{
    const UNKNOWN = -1;

    const UNVERIFIED = 0;

    const VERIFIED = 1;

    protected $webcrawlerVerifiers = [
        'adidxbot' => 'WebcrawlerVerifier\Webcrawler\MicrosoftCorporationVerifier',
        // Also `AdsBot-Google-Mobile-Apps`
        'AdsBot-Google' => 'WebcrawlerVerifier\Webcrawler\GoogleIncVerifier',
        'Applebot' => 'WebcrawlerVerifier\Webcrawler\AppleIncVerifier',
        'AppleNewsBot' => 'WebcrawlerVerifier\Webcrawler\InactiveVerifier',
        'Baiduspider' => 'WebcrawlerVerifier\Webcrawler\BaiduVerifier',
        'BegunAdvertising' => 'WebcrawlerVerifier\Webcrawler\BegunVerifier',
        'bingbot' => 'WebcrawlerVerifier\Webcrawler\MicrosoftCorporationVerifier',
        'BingPreview' => 'WebcrawlerVerifier\Webcrawler\MicrosoftCorporationVerifier',
        'DeuSu' => 'WebcrawlerVerifier\Webcrawler\DeusuVerifier',
        'Exabot' => 'WebcrawlerVerifier\Webcrawler\DassaultSystemesVerifier',
        'ExaleadCloudview' => 'WebcrawlerVerifier\Webcrawler\DassaultSystemesVerifier',
        'FeedValidator/' => 'WebcrawlerVerifier\Webcrawler\ValidatorW3OrgVerifier',
        'Google favicon' => 'WebcrawlerVerifier\Webcrawler\GoogleIncVerifier',
        'Google Keyword Suggestion' => 'WebcrawlerVerifier\Webcrawler\GoogleIncVerifier',
        'Google Keyword Tool' => 'WebcrawlerVerifier\Webcrawler\GoogleIncVerifier',
        'Google Page Speed Insights' => 'WebcrawlerVerifier\Webcrawler\GoogleIncVerifier',
        'Google PP' => 'WebcrawlerVerifier\Webcrawler\GoogleIncVerifier',
        'Google Search Console' => 'WebcrawlerVerifier\Webcrawler\GoogleIncVerifier',
        'Google Web Preview' => 'WebcrawlerVerifier\Webcrawler\GoogleIncVerifier',
        'Google_Analytics_Snippet_Validator' => 'WebcrawlerVerifier\Webcrawler\GoogleIncVerifier',
        'Google-Adwords' => 'WebcrawlerVerifier\Webcrawler\GoogleIncVerifier',
        // Also `Googlebot-News`, `Googlebot-Image`, `Googlebot-Video`, `Googlebot-Mobile`
        'Googlebot' => 'WebcrawlerVerifier\Webcrawler\GoogleIncVerifier',
        'Google-Calendar-Importer' => 'WebcrawlerVerifier\Webcrawler\GoogleIncVerifier',
        'Google-Publisher-Plugin' => 'WebcrawlerVerifier\Webcrawler\GoogleIncVerifier',
        'Google-SearchByImage' => 'WebcrawlerVerifier\Webcrawler\GoogleIncVerifier',
        'Google-Site-Verification' => 'WebcrawlerVerifier\Webcrawler\GoogleIncVerifier',
        'Google-Structured-Data-Testing-Tool' => 'WebcrawlerVerifier\Webcrawler\GoogleIncVerifier',
        'GoogleWebLight' => 'WebcrawlerVerifier\Webcrawler\GoogleIncVerifier',
        'google.com/+/web/snippet/' => 'WebcrawlerVerifier\Webcrawler\GoogleIncVerifier',
        'grapeFX' => 'WebcrawlerVerifier\Webcrawler\GrapeshotLimitedVerifier',
        'GrapeshotCrawler' => 'WebcrawlerVerifier\Webcrawler\GrapeshotLimitedVerifier',
        'istellabot' => 'WebcrawlerVerifier\Webcrawler\TiscaliItaliaSpaVerifier',
        'Jigsaw/' => 'WebcrawlerVerifier\Webcrawler\ValidatorW3OrgVerifier',
        'librabot/' => 'WebcrawlerVerifier\Webcrawler\InactiveVerifier',
        'LinkedInBot' => 'WebcrawlerVerifier\Webcrawler\LinkedInIncVerifier',
        'Mail.RU/' => 'WebcrawlerVerifier\Webcrawler\MailRuGroupVerifier',
        'Mail.RU_Bot' => 'WebcrawlerVerifier\Webcrawler\MailRuGroupVerifier',
        'Mediapartners-Google' => 'WebcrawlerVerifier\Webcrawler\GoogleIncVerifier',
        'Mediapartners(Googlebot)' => 'WebcrawlerVerifier\Webcrawler\GoogleIncVerifier',
        'msnbot' => 'WebcrawlerVerifier\Webcrawler\MicrosoftCorporationVerifier',
        'MSRBOT' => 'WebcrawlerVerifier\Webcrawler\InactiveVerifier',
        'NING/' => 'WebcrawlerVerifier\Webcrawler\ValidatorW3OrgVerifier',
        'oBot/' => 'WebcrawlerVerifier\Webcrawler\IBMGermanyResearchAndDevelopmentGmbHVerifier',
        'OdklBot' => 'WebcrawlerVerifier\Webcrawler\OdnoklassnikiLLCVerifier',
        'Seznam' => 'WebcrawlerVerifier\Webcrawler\SeznamCzASVerifier',
        'SputnikBot' => 'WebcrawlerVerifier\Webcrawler\OJSCRostelecomVerifier',
        'SputnikFaviconBot' => 'WebcrawlerVerifier\Webcrawler\OJSCRostelecomVerifier',
        'SputnikImageBot' => 'WebcrawlerVerifier\Webcrawler\OJSCRostelecomVerifier',
        'Steeler' => 'WebcrawlerVerifier\Webcrawler\KitsuregawaLaboratoryTheUniversityOfTokyoVerifier',
        'Twitterbot' => 'WebcrawlerVerifier\Webcrawler\TwitterIncVerifier',
        'TurnitinBot' => 'WebcrawlerVerifier\Webcrawler\TurnitinLLCVerifier',
        'Validator.nu/' => 'WebcrawlerVerifier\Webcrawler\ValidatorW3OrgVerifier',
        'W3C_I18n-Checker/' => 'WebcrawlerVerifier\Webcrawler\ValidatorW3OrgVerifier',
        'W3C_Unicorn/' => 'WebcrawlerVerifier\Webcrawler\ValidatorW3OrgVerifier',
        'W3C_Validator/' => 'WebcrawlerVerifier\Webcrawler\ValidatorW3OrgVerifier',
        'W3C-checklink' => 'WebcrawlerVerifier\Webcrawler\ValidatorW3OrgVerifier',
        'W3C-mobileOK/' => 'WebcrawlerVerifier\Webcrawler\ValidatorW3OrgVerifier',
        'Wotbox' => 'WebcrawlerVerifier\Webcrawler\WotboxTeamVerifier',
        'Y!J-ASR' => 'WebcrawlerVerifier\Webcrawler\YahooIncVerifier',
        'Y!J-BRI' => 'WebcrawlerVerifier\Webcrawler\YahooIncVerifier',
        'Y!J-BRJ/YATS' => 'WebcrawlerVerifier\Webcrawler\YahooIncVerifier',
        'Y!J-BRO/YFSJ' => 'WebcrawlerVerifier\Webcrawler\YahooIncVerifier',
        'Y!J-BRW' => 'WebcrawlerVerifier\Webcrawler\YahooIncVerifier',
        'Y!J-BSC' => 'WebcrawlerVerifier\Webcrawler\YahooIncVerifier',
        'YaDirectFetcher' => 'WebcrawlerVerifier\Webcrawler\YandexLLCVerifier',
        'Yahoo! Site Explorer Feed Validator' => 'WebcrawlerVerifier\Webcrawler\YahooIncVerifier',
        'Yahoo! Slurp' => 'WebcrawlerVerifier\Webcrawler\YahooIncVerifier',
        'YahooCacheSystem' => 'WebcrawlerVerifier\Webcrawler\YahooIncVerifier',
        'Yahoo-MMCrawler' => 'WebcrawlerVerifier\Webcrawler\YahooIncVerifier',
        'YahooSeeker-Testing' => 'WebcrawlerVerifier\Webcrawler\YahooIncVerifier',
        'YahooYSMcm' => 'WebcrawlerVerifier\Webcrawler\YahooIncVerifier',
        'Yandex.Translate' => 'WebcrawlerVerifier\Webcrawler\YandexLLCVerifier',
        'Yandex/' => 'WebcrawlerVerifier\Webcrawler\YandexLLCVerifier',
        'YandexAccessibilityBot' => 'WebcrawlerVerifier\Webcrawler\YandexLLCVerifier',
        'YandexAdNet' => 'WebcrawlerVerifier\Webcrawler\YandexLLCVerifier',
        'YandexAntivirus' => 'WebcrawlerVerifier\Webcrawler\YandexLLCVerifier',
        'YandexBlogs' => 'WebcrawlerVerifier\Webcrawler\YandexLLCVerifier',
        'YandexBot' => 'WebcrawlerVerifier\Webcrawler\YandexLLCVerifier',
        'YandexCalendar' => 'WebcrawlerVerifier\Webcrawler\YandexLLCVerifier',
        'YandexCatalog' => 'WebcrawlerVerifier\Webcrawler\YandexLLCVerifier',
        // Also `YandexDirectDyn`
        'YandexDirect' => 'WebcrawlerVerifier\Webcrawler\YandexLLCVerifier',
        'YandexFavicons' => 'WebcrawlerVerifier\Webcrawler\YandexLLCVerifier',
        'YandexForDomain' => 'WebcrawlerVerifier\Webcrawler\YandexLLCVerifier',
        'YandexVertis' => 'WebcrawlerVerifier\Webcrawler\YandexLLCVerifier',
        'YandexImageResizer' => 'WebcrawlerVerifier\Webcrawler\YandexLLCVerifier',
        'YandexImages' => 'WebcrawlerVerifier\Webcrawler\YandexLLCVerifier',
        'YandexMarket' => 'WebcrawlerVerifier\Webcrawler\YandexLLCVerifier',
        // Also `YandexMedianaBot`,
        'YandexMedia' => 'WebcrawlerVerifier\Webcrawler\YandexLLCVerifier',
        'YandexMetrika' => 'WebcrawlerVerifier\Webcrawler\YandexLLCVerifier',
        'YandexMobileBot' => 'WebcrawlerVerifier\Webcrawler\YandexLLCVerifier',
        // Also `YandexNewslinks`
        'YandexNews' => 'WebcrawlerVerifier\Webcrawler\YandexLLCVerifier',
        'YandexPagechecker' => 'WebcrawlerVerifier\Webcrawler\YandexLLCVerifier',
        'YandexScreenshotBot' => 'WebcrawlerVerifier\Webcrawler\YandexLLCVerifier',
        'YandexSomething' => 'WebcrawlerVerifier\Webcrawler\YandexLLCVerifier',
        'YandexSearchShop' => 'WebcrawlerVerifier\Webcrawler\YandexLLCVerifier',
        'YandexSpravBot' => 'WebcrawlerVerifier\Webcrawler\YandexLLCVerifier',
        'YandexSitelinks' => 'WebcrawlerVerifier\Webcrawler\YandexLLCVerifier',
        // Also `YandexVideoParser`
        'YandexVideo' => 'WebcrawlerVerifier\Webcrawler\YandexLLCVerifier',
        'YandexWebmaster' => 'WebcrawlerVerifier\Webcrawler\YandexLLCVerifier',
        'YandexZakladki' => 'WebcrawlerVerifier\Webcrawler\YandexLLCVerifier'
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
