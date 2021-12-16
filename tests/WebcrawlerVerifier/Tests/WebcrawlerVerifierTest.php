<?php

/** @noinspection HttpUrlsUsage */

namespace WebcrawlerVerifier\Tests;

use PHPUnit\Framework\TestCase;
use WebcrawlerVerifier\WebcrawlerVerifier;

class WebcrawlerVerifierTest extends TestCase
{
    public function testVerifyInvalidUserAgent()
    {
        $this->expectException(\InvalidArgumentException::class);
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = [];

        $this->assertEquals($webcrawlerVerifier::UNKNOWN, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
    }

    public function testVerifyInvalidIP()
    {
        $this->expectException(\InvalidArgumentException::class);
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)';

        $this->assertEquals($webcrawlerVerifier::UNKNOWN, $webcrawlerVerifier->verify(
            $userAgent,
            123
        ));
    }

    public function testVerifyEmptyUserAgent()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = '';

        $this->assertEquals($webcrawlerVerifier::UNKNOWN, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
    }

    public function testVerifyNormalWebcrawler()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgents = [
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_8) AppleWebKit/537.12.13 (KHTML, like Gecko)'
                . ' Chrome/56.0.2715.80 Safari/537.12.13' => '192.168.0.1',
            'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:40.0) Gecko/20100101 Firefox/40.1' => '192.168.0.1',
            'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71'
                . ' Safari/537.36' => '192.168.0.1',
            'Mozilla/4.0 (compatible; MSIE 6.0; Update a; AOL 6.0; Windows 98)' => '192.168.0.1',
            'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.59'
                . ' Safari/537.36 OPR/41.0.2353.46' => '192.168.0.1',
            'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116'
                . ' YaBrowser/16.9.1.1192 Yowser/2.5 Safari/537.36' => '192.168.0.1',
            'Mozilla/5.0 (Linux; U; Android 4.1.2; ru-ru; GT-N7000 Build/JZO54K) AppleWebKit/534.30 (KHTML,'
                . ' like Gecko) Version/4.0 Mobile Safari/534.30' => '192.168.0.1',
            'Mozilla/5.0 (Windows NT 6.1; Trident/7.0; rv:11.0) like Gecko' => '192.168.0.1',
            'Mozilla/5.0 (Linux; U; Android 4.2.2; ru-ru; Q45/A45 Build/JDQ39) AppleWebKit/534.30 (KHTML, like Gecko)'
                . ' Version/4.0 Mobile Safari/534.30' => '192.168.0.1'
        ];

        foreach ($userAgents as $userAgent => $ip) {
            $this->assertEquals($webcrawlerVerifier::UNKNOWN, $webcrawlerVerifier->verify(
                $userAgent,
                $ip
            ));
        }
    }

    public function testVerifyAdidxbotWebcrawler()
    {
        $userAgents = [
            'Mozilla/5.0 (compatible; adidxbot/2.0; +http://www.bing.com/bingbot.htm)' => '157.55.39.51',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 7_0 like Mac OS X) AppleWebKit/537.51.1 (KHTML, like Gecko)'
                . ' Version/7.0 Mobile/11A465 Safari/9537.53'
                . ' (compatible; adidxbot/2.0; +http://www.bing.com/bingbot.htm)' => '40.77.167.38',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 7_0 like Mac OS X) AppleWebKit/537.51.1 (KHTML, like Gecko)'
                . ' Version/7.0 Mobile/11A465 Safari/9537.53'
                . ' (compatible; adidxbot/2.0; http://www.bing.com/bingbot.htm)' => '207.46.13.17',
            'Mozilla/5.0 (compatible; adidxbot/2.0; http://www.bing.com/bingbot.htm)' => '40.77.167.75',
            'Mozilla/5.0 (Windows Phone 8.1; ARM; Trident/7.0; Touch; rv:11.0; IEMobile/11.0; NOKIA; Lumia 530)'
                . ' like Gecko (compatible; adidxbot/2.0; +http://www.bing.com/bingbot.htm)' => '40.77.167.63',
            'adidxbot/2.0 (+http://search.msn.com/msnbot.htm)' => '40.77.167.63',
            'adidxbot/1.1 (+http://search.msn.com/msnbot.htm)' => '157.55.39.51'
        ];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyAdsBotGoogleWebcrawler()
    {
        $userAgents = [
            'AdsBot-Google (+http://www.google.com/adsbot.html)' => '66.249.89.15',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) '
                . 'Version/9.0 Mobile/13B143 Safari/601.1 (compatible; '
                . 'AdsBot-Google-Mobile; +http://www.google.com/mobile/adsbot.html)' => '66.249.89.17',
            'AdsBot-Google-Mobile (+http://www.google.com/mobile/adsbot.html) Mozilla (iPhone; U; CPU iPhone OS 3 0'
                . ' like Mac OS X) AppleWebKit (KHTML, like Gecko) Mobile Safari' => '66.249.91.5',
            'AdsBot-Google-Mobile-Apps' => '66.249.89.15',
        ];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyAdxPsfFetcherGoogleWebcrawlerVerifier()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'AdxPsfFetcher-Google';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '66.249.90.86'
        ));
    }

    public function testVerifyApplebotWebcrawler()
    {
        $userAgents = [
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.2.5 (KHTML, like Gecko)'
                . ' Version/8.0.2 Safari/600.2.5 (Applebot/0.1; +http://www.apple.com/go/applebot)' => '17.58.101.179',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 8_1 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) Version/8.0'
                . ' Mobile/12B410 Safari/600.1.4 (Applebot/0.1; +http://www.apple.com/go/applebot)' => '17.58.101.179',

        ];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyAppleNewsBotWebcrawler()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'AppleNewsBot';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '17.133.2.237'
        ));
    }

    public function testVerifyBaiduspiderWebcrawler()
    {
        $userAgents = [
            'Mozilla/5.0 (compatible; Baiduspider/2.0; +http://www.baidu.com/search/spider.html)' => '123.125.71.48',
            'Baiduspider-image+(+http://www.baidu.com/search/spider.htm)' => '220.181.108.181',
            'Mozilla/5.0 (compatible; Baiduspider-cpro; +http://www.baidu.com/search/spider.html)' => '123.125.71.33',
            'Baiduspider+(+http://www.baidu.com/search/spider.htm)' => '220.181.108.160',
            'Baiduspider-image+(+http://www.baidu.com/search/spider.htm)\nReferer:'
                . ' http://image.baidu.com/i?ct=503316480&z=0&tn=baiduimagedetail' => '220.181.108.181',
            'Baiduspider+(+http://www.baidu.jp/spider/)' => '119.63.198.104',
            'Baiduspider+(+http://help.baidu.jp/system/05.html)' => '119.63.198.104',
            'Baiduspider+(+http://www.baidu.com/search/spider_jp.html)' => '119.63.198.104'
        ];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyBegunAdvertisingWebcrawler()
    {
        $this->markTestSkipped('Unknown current IP');

        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'Mozilla/5.0 (compatible; BegunAdvertising/3.0; +http://begun.ru/begun/technology/indexer/)';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '91.192.149.231'
        ));
    }

    public function testVerifyBingbotWebcrawler()
    {
        $userAgents = [
            'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)' => '207.46.13.239',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 7_0 like Mac OS X) AppleWebKit/537.51.1 (KHTML, like Gecko) Version/7.0'
                . ' Mobile/11A465 Safari/9537.53 (compatible; bingbot/2.0;'
                . ' +http://www.bing.com/bingbot.htm)' => '207.46.13.160',
            'Mozilla/5.0 (seoanalyzer; compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)' => '207.46.13.174',
            'Mozilla/5.0 (compatible; bingbot/2.0; http://www.bing.com/bingbot.htm)' => '157.55.39.89',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 7_0 like Mac OS X) AppleWebKit/537.51.1 (KHTML, like Gecko) Version/7.0'
                . ' Mobile/11A465 Safari/9537.53 (compatible; bingbot/2.0; '
                . 'http://www.bing.com/bingbot.htm)' => '207.46.13.209',
            'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm' => '157.55.39.27',
            'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm) SitemapProbe' => '40.77.167.30'
        ];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyBingPreviewWebcrawler()
    {
        $userAgents = [
            'Mozilla/5.0 (iPhone; CPU iPhone OS 7_0 like Mac OS X) AppleWebKit/537.51.1 (KHTML, like Gecko) Version/7.0'
                . ' Mobile/11A465 Safari/9537.53 BingPreview/1.0b' => '207.46.13.218',
            'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/534+ (KHTML, like Gecko) BingPreview/1.0b'
                => '199.30.25.171',
            'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0; BingPreview/1.0b) like Gecko' => '65.55.210.79',
            'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0; WOW64; Trident/5.0; BingPreview/1.0b)'
                => '199.30.25.107',
            'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0; WOW64; Trident/6.0; BingPreview/1.0b)'
                => '199.30.26.160'
        ];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyDeuSuWebcrawler()
    {
        $this->markTestSkipped('seems dead');

        $userAgents = [
            'Mozilla/5.0 (compatible; DeuSu/5.0.2; +https://deusu.de/robot.html)' => '85.93.91.84',
            'Mozilla/5.0 (compatible; DeuSu/0.1.0; +https://deusu.org)' => '85.93.91.84'
        ];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyExabotWebcrawler()
    {
        $this->markTestSkipped('couldn\'t find active IP');

        $userAgents = [
            'Mozilla/5.0 (compatible; Exabot/3.0; +http://www.exabot.com/go/robot)' => '178.255.215.91',
            'Mozilla/5.0 (compatible; Konqueror/3.5; Linux) KHTML/3.5.5 (like Gecko) (Exabot-Thumbnails)'
                => '178.255.215.97',
            'Mozilla/5.0 (compatible; Exabot/3.0 (BiggerBetter); +http://www.exabot.com/go/robot)' => '178.255.215.80',
            'Mozilla/5.0 (compatible; ExaleadCloudView/5;)' => '178.255.215.130',
            'Mozilla/5.0 (compatible; ExaleadCloudview/6;)' => '178.255.215.130',
            'Mozilla/5.0 (compatible; Exabot-Images/3.0; +http://www.exabot.com/go/robot)' => '178.255.215.91'
        ];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyFeedValidatorWebcrawler()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'FeedValidator/1.3';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '128.30.52.13'
        ));
    }

    public function testVerifyGooglefaviconWebcrawler()
    {
        $userAgents = [
            'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36'
                . ' Google Favicon' => '66.102.6.118',
            'Mozilla/5.0 (Windows NT 6.1; rv:6.0) Gecko/20110814 Firefox/6.0 Google favicon' => '66.249.84.249',
            'Google favicon' => '66.249.93.166'
        ];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyGoogleKeywordSuggestionWebcrawler()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'Mozilla/5.0 (X11; U; Linux x86_64; en-US) AppleWebKit/534.16 (KHTML, like Gecko, Google Keyword'
            . ' Suggestion) Chrome/10.0.648.127 Safari/534.16';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '66.249.84.220'
        ));
    }

    public function testVerifyGoogleKeywordToolWebcrawler()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'Mozilla/5.0 (compatible; Google Keyword Tool; +http://adwords.google.com/select/'
            . 'KeywordToolExternal)';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '66.249.72.68'
        ));
    }

    public function testVerifyGooglePageSpeedInsightsWebcrawler()
    {
        $userAgents = [
            'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko; Google'
                . ' Page Speed Insights) Chrome/27.0.1453 Mobile Safari/537.36' => '66.102.8.156',
            'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko; Google Page Speed Insights)'
                . ' Chrome/27.0.1453 Safari/537.36' => '66.249.93.158',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 8_3 like Mac OS X) AppleWebKit/537.36 (KHTML, like Gecko; Google Page'
                . ' Speed Insights) Version/8.0 Mobile/12F70 Safari/600.1.4' => '66.249.93.179',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 6_0_1 like Mac OS X) AppleWebKit/537.36 (KHTML, like Gecko; Google Page'
                . ' Speed Insights) Version/6.0 Mobile/10A525 Safari/8536.25' => '66.249.93.251',
            'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.4 (KHTML, like Gecko; Google Page Speed Insights)'
                . ' Chrome/22.0.1229 Safari/537.4' => '66.249.93.193'
        ];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyGooglePPWebcrawler()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'Mozilla/5.0 (en-us) AppleWebKit/537.36 (KHTML, like Gecko; Google PP Default) Chrome/27.0.1453'
            . ' Safari/537.36';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '66.249.83.167'
        ));
    }

    public function testVeirfyGoogleSearchConsoleWebcrawler()
    {
        $userAgents = [
            'Mozilla/5.0 (iPhone; CPU iPhone OS 8_3 like Mac OS X) AppleWebKit/537.36 (KHTML, like Gecko) Version/8.0'
                . ' Mobile/12F70 Safari/600.1.4 (compatible; Google Search Console)' => '66.249.83.167',
            'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko; Google Search Console)'
                . ' Chrome/27.0.1453 Safari/537.36' => '66.249.83.170'
        ];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyGoogleWebPreviewWebcrawler()
    {
        $userAgents = [
            'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko; Google Web Preview)'
                . ' Chrome/27.0.1453 Safari/537.36' => '66.102.9.22',
            'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; Google Web Preview Analytics) Chrome/27.0.1453'
                . ' Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)' => '66.249.79.34',
            'Mozilla/5.0 (Linux; U; Android 2.3.4; generic) AppleWebKit/537.36 (KHTML, like Gecko; Google Web Preview)'
                . ' Version/4.0 Mobile Safari/537.36' => '66.102.6.244',
            'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.4 (KHTML, like Gecko; Google Web Preview)'
                . ' Chrome/22.0.1229 Safari/537.4' => '66.102.6.244',
            'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/534.51 (KHTML, like Gecko; Google Web Preview)'
                . ' Chrome/12.0.742 Safari/534.51' => '66.102.6.244',
            'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/534.24 (KHTML, like Gecko; Google Web Preview)'
                . ' Chrome/11.0.696 Safari/534.24' => '66.102.6.244',
            'Mozilla/5.0 (en-us) AppleWebKit/525.13 (KHTML, like Gecko; Google Web Preview) Version/3.1'
                . ' Safari/525.13' => '66.102.6.244'
        ];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyGoogleAnalyticsSnippetValidatorWebcrawler()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'Google_Analytics_Snippet_Validator';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '66.249.82.125'
        ));
    }

    public function testVerifyGoogleAdwordsWebcrawler()
    {
        $userAgents = [
            'Google-Adwords-Instant (+http://www.google.com/adsbot.html)' => '66.102.6.253',
            'Mozilla/5.0 (en-us) AppleWebKit/537.36(KHTML, like Gecko; Google-Adwords-DisplayAds-WebRender;)'
                . ' Chrome/27.0.1453Safari/537.36' => '66.249.83.185',
            'Mozilla/5.0, Google-AdWords-Express' => '66.249.88.14',
            'Google-AdWords-Express' => '66.249.83.148'
        ];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyGrapeshotCrawlerWebcrawler()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'Mozilla/5.0 (compatible; GrapeshotCrawler/2.0; +http://www.grapeshot.co.uk/crawler.php)';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '89.145.95.76'
        ));
    }

    public function testVerifyGooglebotWebcrawler()
    {
        $userAgents = [
            'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)' => '66.249.66.96',
            'Googlebot/2.1 (+http://www.google.com/bot.html)' => '66.249.66.96',
            'Googlebot-News' => '66.249.66.96',
            'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko)'
                . ' Chrome/41.0.2272.96 Mobile Safari/537.36 (compatible; Googlebot/2.1;'
                . ' +http://www.google.com/bot.html)' => '66.249.64.37',
            'DoCoMo/2.0 N905i(c100;TB;W24H16) (compatible; Googlebot-Mobile/2.1; +http://www.google.com/bot.html)'
                => '66.249.64.185',
            'Googlebot-Image/1.0' => '66.249.64.26',
            'SAMSUNG-SGH-E250/1.0 Profile/MIDP-2.0 Configuration/CLDC-1.1 UP.Browser/6.2.3.3.c.1.101 (GUI) MMP/2.0'
                . ' (compatible; Googlebot-Mobile/2.1; +http://www.google.com/bot.html)' => '66.249.64.91',
            'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.75 Safari/537.36'
                . ' Google (+https://developers.google.com/+/web/snippet/)' => '66.249.90.95',
            'Googlebot-Video/1.0' => '66.249.66.174',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 6_0 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0'
                . ' Mobile/10A5376e Safari/8536.25 (compatible; Googlebot/2.1;'
                . ' +http://www.google.com/bot.html)' => '66.249.66.174',
            'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko)'
                . ' Chrome/27.0.1453 Mobile Safari/537.36 (compatible; Googlebot/2.1;'
                . ' +http://www.google.com/bot.html)' => '66.249.76.31',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 8_3 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) Version/8.0'
                . ' Mobile/12F70 Safari/600.1.4 (compatible; Googlebot/2.1;'
                . ' +http://www.google.com/bot.html)' => '66.249.69.124',
            'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; Googlebot/2.1;'
                . ' +http://www.google.com/bot.html) Safari/537.36' => '66.249.69.11',
            'Mozilla/5.0 (Windows NT 6.1; rv:6.0) Gecko/20110814 Firefox/6.0 Google'
                . ' (+https://developers.google.com/+/web/snippet/)' => '66.249.81.138',
            'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_1 like Mac OS X; en-us) AppleWebKit/532.9 (KHTML, like Gecko)'
                . ' Version/4.0.5 Mobile/8B117 Safari/6531.22.7 (compatible; Googlebot-Mobile/2.1;'
                . ' +http://www.google.com/bot.html)' => '66.249.75.98',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 8_3 like Mac OS X) AppleWebKit/537.36 (KHTML, like Gecko) Version/8.0'
                . ' Mobile/12F70 Safari/600.1.4 (compatible; Googlebot/2.1;'
                . ' +http://www.google.com/bot.html)' => '66.249.66.174',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 6_0 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0'
                . ' Mobile/10A5376e Safari/8536.25 (compatible; Googlebot-Mobile/2.1;'
                . ' +http://www.google.com/bot.html)' => '66.249.75.98',
            'Nokia6820/2.0 (4.83) Profile/MIDP-1.0 Configuration/CLDC-1.0 (compatible; Googlebot-Mobile/2.1;'
                . ' +http://www.google.com/bot.html)' => '66.249.72.68',
            'SAMSUNG-SGH-E250/1.0 Profile/MIDP-2.0 Configuration/CLDC-1.1 UP.Browser/6.2.3.3.c.1.101 (GUI)'
                . ' MMP/2.0 (compatible; Googlebot-Mobile/2.1;'
                . ' +http://www.google.com/bot.html)' => '66.249.64.37',
            'DoCoMo/2.0 N905i(c100;TB;W24H16) (compatible; Googlebot-Mobile/2.1;'
                . ' +http://www.google.com/bot.html)' => '66.249.64.37'
        ];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyGoogleCalendarImporterWebcrawler()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'Google-Calendar-Importer';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '66.249.91.220'
        ));
    }

    public function testVerifyGooglePublisherPluginWebcrawler()
    {
        $userAgents = [
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_3) AppleWebKit/537.36 (KHTML, like Gecko,'
                . ' Google-Publisher-Plugin) Chrome/27.0.1453 Safari/537.36' => '66.249.64.44',
            'Mozilla/5.0 (Linux; Android 4.0.4; Galaxy Nexus Build/IMM76B) AppleWebKit/537.36 (KHTML, like Gecko;'
                . ' Google-Publisher-Plugin) Chrome/27.0.1453 Mobile Safari/537.36' => '66.249.64.116'
        ];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyGoogleSearchByImageWebcrawler()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; de; rv:1.9.0.7; Google-SearchByImage)'
            . ' Gecko/2009021910 Firefox/3.0.7';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '66.102.9.148'
        ));
    }

    public function testVerifyGoogleSiteVerificationCrawlerWebcrawler()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'Mozilla/5.0 (compatible; Google-Site-Verification/1.0)';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '66.249.91.23'
        ));
    }

    public function testVerifyGoogleStructuredDataTestingToolWebcrawler()
    {
        $userAgents = [
            'Mozilla/5.0 (compatible; Google-Structured-Data-Testing-Tool'
                . ' +https://search.google.com/structured-data/testing-tool)' => '66.102.9.148',
            'Mozilla/5.0 (compatible; Google-Structured-Data-Testing-Tool'
                . ' +http://developers.google.com/structured-data/testing-tool/)' => '66.102.9.60'
        ];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyGoogleWebLightWebcrawler()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'Mozilla/5.0 (Linux; Android 4.2.1; en-us; Nexus 5 Build/JOP40D) AppleWebKit/535.19 (KHTML,'
            . ' like Gecko; googleweblight) Chrome/38.0.1025.166 Mobile Safari/535.19';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '66.102.7.159'
        ));
    }

    public function testVerifyGrapeFXWebcrawler()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'Mozilla/5.0 (compatible; grapeFX/0.9; crawler@grapeshot.co.uk';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '89.145.95.6'
        ));
    }

    public function testVerifyIstellabotWebcrawler()
    {
        $userAgents = [
            'istellabot/t.1' => '217.73.208.152',
            'istellabot/Nutch-1.11' => '217.73.208.145',
            'istellabot/Nutch-1.10' => '217.73.208.144',
            'Mozilla/5.0 (compatible; IstellaBot/1.23.15 +http://www.tiscali.it/)' => '217.73.208.152',
            'istellabot-nutch/Nutch-1.10' => '217.73.208.147',
            'Mozilla/5.0 (compatible; IstellaBot/1.18.81 +http://www.tiscali.it/)' => '217.73.208.152',
            'Mozilla/5.0 (compatible; IstellaBot/1.10.2 +http://www.tiscali.it/)' => '217.73.208.145',
            'Mozilla/5.0 (compatible; IstellaBot/1.01.18 +http://www.tiscali.it/)' => '217.73.208.144'
        ];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyJigsawWebcrawler()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'Jigsaw/2.3.0 W3C_CSS_Validator_JFouffa/2.0';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '128.30.52.41'
        ));
    }

    public function testVerifyLinkedInIncWebcrawler()
    {
        $userAgents = [
            'LinkedInBot/1.0 (compatible; Mozilla/5.0; Jakarta Commons-HttpClient/3.1 +http://www.linkedin.com)'
                => '108.174.2.215',
            'LinkedInBot/1.0 (compatible; Mozilla/5.0; Apache-HttpClient +http://www.linkedin.com), libot/Nutch-1.9'
                . ' (http://www.linkedin.com; libot@linkedin.com)' => '108.174.2.215',
            'LinkedInBot/1.0 (compatible; Mozilla/5.0; Jakarta Commons-HttpClient/4.3 +http://www.linkedin.com)'
                => '108.174.2.215'
        ];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyLibrabotWebcrawler()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgents = [
            'librabot/2.0 (+http://academic.research.microsoft.com/)' => '219.142.53.6',
            'librabot/2.0 (+http://search.msn.com/msnbot.htm)' => '219.142.53.13',
            'librabot/1.0 (+http://search.msn.com/msnbot.htm)' => '219.142.53.5'
        ];

        foreach ($userAgents as $userAgent => $ip) {
            $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
                $userAgent,
                '192.168.0.1'
            ));
            $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
                $userAgent,
                $ip
            ));
        }
    }

    public function testVerifyMailRUWebcrawler()
    {
        $userAgents = [
            'Mozilla/5.0 (compatible; Mail.RU/2.0c)' => '217.69.133.188',
            'Mozilla/5.0 (compatible; Mail.RU/2.0)' => '217.69.133.29',
            'Mail.RU/2.0' => '217.69.133.29',
            'Mail.Ru/1.0' => '217.69.134.167'
        ];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyMailRUBotWebcrawler()
    {
        $userAgents = [
            'Mozilla/5.0 (compatible; Linux x86_64; Mail.RU_Bot/2.0; +http://go.mail.ru/help/robots)'
                => '217.69.136.209',
            'Mozilla/5.0 (compatible; Linux x86_64; Mail.RU_Bot/Fast/2.0; +http://go.mail.ru/help/robots)'
                => '217.69.133.249',
            'Mozilla/5.0 (compatible; Linux x86_64; Mail.RU_Bot/Robots/2.0; +http://go.mail.ru/help/robots)'
                => '95.163.255.130',
            'Mozilla/5.0 (compatible; Linux x86_64; Mail.RU_Bot/Robots; +http://go.mail.ru/help/robots)'
                => '95.163.255.130',
            'Mozilla/5.0 (compatible; Linux x86_64; Mail.RU_Bot/Img/2.0; +http://go.mail.ru/help/robots)'
                => '95.163.255.90',
            'Mozilla/5.0 (compatible; Mail.RU_Bot/2.0; +http://go.mail.ru/help/robots)' => '95.163.255.130',
            'Mozilla/5.0 (compatible; Mail.RU_Bot/2.0)' => '95.163.255.130'
        ];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyMediapartnersGoogleWebcrawler()
    {
        $userAgents = [
            'Mozilla/5.0 (iPhone; U; CPU iPhone OS 10_0 like Mac OS X; en-us) AppleWebKit/602.1.38 (KHTML, like Gecko)'
                . ' Version/10.0 Mobile/14A5297c Safari/602.1 (compatible; Mediapartners-Google/2.1;'
                . ' +http://www.google.com/bot.html)' => '66.249.69.115',
            'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_1 like Mac OS X; en-us) AppleWebKit/532.9 (KHTML, like Gecko)'
                . ' Version/4.0.5 Mobile/8B117 Safari/6531.22.7 (compatible; Mediapartners-Google/2.1;'
                . ' +http://www.google.com/bot.html)' => '66.249.75.96',
            'Mediapartners-Google' => '66.249.76.70',
            'Mediapartners(Googlebot)' => '66.249.76.70'
        ];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyMojeekLtdWebcrawlerVerifier()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'Mozilla/5.0 (compatible; MojeekBot/0.6; +https://www.mojeek.com/bot.html)';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '5.102.173.71'
        ));
    }

    public function testVerifyMsnbotWebcrawler()
    {
        $userAgents = [
            'msnbot-media/1.1 (+http://search.msn.com/msnbot.htm)' => '157.55.39.76',
            'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/534+ (KHTML, like Gecko) MsnBot-Media /1.0b'
                => '207.46.13.228',
            'msnbot-media/2.0b (+http://search.msn.com/msnbot.htm)' => '207.46.13.190',
            'msnbot-media/1.0 (+http://search.msn.com/msnbot.htm)' => '157.55.39.179'
        ];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyMSRBOTWebcrawler()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'MSRBOT';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '131.107.151.126'
        ));
    }

    public function testVerifySputnikImageBotWebcrawler()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'Mozilla/5.0 (compatible; SputnikImageBot/2.3; +http://corp.sputnik.ru/webmaster)';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '5.143.231.137'
        ));
    }

    public function testVerifyNINGWebcrawler()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'NING/1.0';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '128.30.52.55'
        ));
    }

    public function testVerifyoBotWebcrawler()
    {
        $userAgents = [
            'Mozilla/5.0 (compatible; oBot/2.3.1; http://filterdb.iss.net/crawler/)' => '206.253.224.14',
            'Mozilla/5.0 (compatible; oBot/2.3.1; +http://filterdb.iss.net/crawler/)' => '194.153.113.35',
            'Mozilla/5.0 (compatible; oBot/2.3.1; +http://www-935.ibm.com/services/us/index.wss/detail/iss/a1029077'
                . '?cntxt=a1027244)' => '2001:1be0:1000:167:250:56ff:fe92:58c9'
        ];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyOdklBotWebcrawler()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'OdklBot/1.0 (klass@odnoklassniki.ru)';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '217.20.145.18'
        ));
    }

    public function testVerifySeznamWebcrawler()
    {
        $userAgents = [
            'Mozilla/5.0 (compatible; SeznamBot/3.2-test1-1; +http://napoveda.seznam.cz/en/seznambot-intro/)'
                => '77.75.74.87',
            'Mozilla/5.0 (compatible; SeznamBot/3.2-test1; +http://napoveda.seznam.cz/en/seznambot-intro/)'
                => '2a02:598:111::9',
            'Seznam-Zbozi-robot/3.0'
                => '77.75.74.87',
            'Mozilla/5.0 (compatible; SeznamBot/3.2-test4; +http://napoveda.seznam.cz/en/seznambot-intro/)'
                => '77.75.74.87',
            'Mozilla/5.0 PhantomJS (compatible; Seznam screenshot-generator 2.1; +http://fulltext.sblog.cz/screenshot/)'
                => '77.75.77.174',
            'Mozilla/5.0 (compatible; SeznamBot/3.2-test2; +http://napoveda.seznam.cz/en/seznambot-intro/)'
                => '77.75.74.87',
            'Mozilla/5.0 (compatible; SeznamBot/3.2; +http://napoveda.seznam.cz/en/seznambot-intro/)'
                => '77.75.76.163',
            'Mozilla/5.0 (compatible; Seznam screenshot-generator 2.1; +http://fulltext.sblog.cz/screenshot/)'
                => '77.75.74.248',
            'Mozilla/5.0 (compatible; SeznamBot/3.2-test1; +http://fulltext.sblog.cz/)' => '2a02:598:111::9',
            'Mozilla/5.0 (compatible; SeznamBot/3.2-test4; +http://fulltext.sblog.cz/)' => '77.75.74.41',
            'Mozilla/5.0 (compatible; SeznamBot/3.2; +http://fulltext.sblog.cz/)' => '77.75.74.87',
            'Seznam-Zbozi-robot/3.2.1' => '77.75.74.248',
            'SeznamBot/2.0 (+http://fulltext.sblog.cz/robot/)' => '77.75.74.87',
            'Seznam-Zbozi-robot/3.2.2' => '77.75.77.24',
            'Mozilla/5.0 (compatible; SeznamBot/3.2-test2; +http://fulltext.sblog.cz/)'
                => '2a02:598:111::9',
            'Mozilla/5.0 (compatible; SeznamBot/3.2-test3; +http://fulltext.sblog.cz/)' => '77.75.74.248',
            'Seznam-Zbozi-robot/3.3' => '77.75.77.24',
            'SklikBot/2.0 (sklik@firma.seznam.cz;+http://napoveda.sklik.cz/)' => '77.75.77.24',
            'SeznamBot/3.0 (+http://fulltext.sblog.cz/)' => '77.75.77.24',
            'Mozilla/5.0 (compatible; SeznamBot/3.1-test1; +http://fulltext.sblog.cz/)' => '77.75.74.41',
            'Mozilla/5.0 (Linux; U; Android 4.1.2; cs-cz; Seznam screenshot-generator Build/Q3) AppleWebKit/534.30'
                . ' (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30' => '77.75.77.123',
            'SeznamBot/3.0-test (+http://fulltext.sblog.cz/), I' => '77.75.74.248',
            'SeznamBot/3.0 (HaF+http://fulltext.sblog.cz/)' => '77.75.74.41',
            'SeznamBot/3.0-test (+http://fulltext.sblog.cz/)' => '77.75.74.41',
            'SeznamBot/3.0-beta (+http://fulltext.sblog.cz/), I' => '77.75.74.248',
            'SeznamBot/3.0-beta (+http://fulltext.sblog.cz/)' => '77.75.77.123',
            'SeznamBot/3.0-alpha (+http://fulltext.sblog.cz/)' => '77.75.77.39',
            'SeznamBot/2.0 (+http://fulltext.seznam.cz/)' => '77.75.77.39',
            'SeznamBot/2.0-Test (+http://fulltext.sblog.cz/robot/)' => '77.75.77.39',
            'Mozilla/5.0 (compatible; Seznam screenshot-generator 2.0; +http://fulltext.sblog.cz/screenshot/)'
                => '77.75.77.39'
        ];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifySputnikBotWebcrawler()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'Mozilla/5.0 (compatible; SputnikBot/2.3; +http://corp.sputnik.ru/webmaster)';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '5.143.231.45'
        ));
    }

    public function testVerifySputnikFaviconBotWebcrawler()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'Mozilla/5.0 (compatible; SputnikFaviconBot/1.2; +http://corp.sputnik.ru/webmaster)';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '95.167.189.16'
        ));
    }

    public function testVerifySteelerWebcrawler()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'Mozilla/5.0 (compatible; Steeler/3.5; http://www.tkl.iis.u-tokyo.ac.jp/~crawler/)';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '157.82.156.152'
        ));
    }

    public function testVerifyTwitterbotWebcrawler()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'Twitterbot/1.0';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '199.16.156.126'
        ));
    }

    public function testVerifyTurnitinLLCWebcrawler()
    {
        $userAgents = [
            'TurnitinBot (https://turnitin.com/robot/crawlerinfo.html)' => '38.111.147.83',
            'TurnitinBot/3.0 (http://www.turnitin.com/robot/crawlerinfo.html)' => '38.111.147.84',
            'TurnitinBot/2.1 (http://www.turnitin.com/robot/crawlerinfo.html)' => '38.111.147.83'
        ];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyValidatorNuWebcrawler()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'Validator.nu/LV';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '128.30.52.5'
        ));
    }

    public function testVerifyW3CI18nCheckerWebcrawler()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'W3C_I18n-Checker/1.0';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '128.30.52.38'
        ));
    }

    public function testVerifyW3CUnicornWebcraler()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'W3C_Unicorn/1.0';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '128.30.52.58'
        ));
    }

    public function testVerifyW3CValidatorWebcraler()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'W3C_Validator/1.3';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '128.30.52.58'
        ));
    }

    public function testVerifyW3CChecklinkWebcraler()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'W3C-checklink';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '128.30.52.114'
        ));
    }

    public function testVerifyW3CMobileOKWebcrawler()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'W3C-mobileOK/DDC-1.0';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '128.30.52.213'
        ));
    }

    public function testVerifyWotboxWebcrawler()
    {
        $userAgents = [
            'Wotbox/2.01 (+http://www.wotbox.com/bot/)' => '94.199.151.22',
            'Wotbox/2.0 (bot@wotbox.com; http://www.wotbox.com)' => '94.199.151.22'
        ];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyYJASRWebcralwer()
    {
        $userAgents = ['Y!J-ASR/0.1 crawler (http://www.yahoo-help.jp/app/answers/detail/p/595/a_id/42716/)' => '72.30.14.97'];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyYJBRIWebcralwer()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'Y!J-ASR/0.1 crawler (http://www.yahoo-help.jp/app/answers/detail/p/595/a_id/42716/)';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '72.30.14.97'
        ));
    }

    public function testVerifyYJBRJYATSWebcralwer()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'Y!J-BRJ/YATS crawler (http://help.yahoo.co.jp/help/jp/search/indexing/indexing-15.html)';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '72.30.14.97'
        ));
    }

    public function testVerifyYJBROYFSJWebcralwer()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'Y!J-BRO/YFSJ crawler (compatible; Mozilla 4.0; MSIE 5.5;'
            . ' http://help.yahoo.co.jp/help/jp/search/indexing/indexing-15.html; YahooFeedSeekerJp/2.0)';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '72.30.14.97'
        ));
    }

    public function testVerifyYJBRWWebcrawler()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'Y!J-BRW/1.0 crawler (http://help.yahoo.co.jp/help/jp/search/indexing/indexing-15.html)';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '72.30.14.97'
        ));
    }

    public function testVerifyYJBSCWebcrawler()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'Y!J-BSC/1.0 crawler (http://help.yahoo.co.jp/help/jp/blog-search/)';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '72.30.14.97'
        ));
    }

    public function testVerifyYaDirectFetcherWebcrawler()
    {
        $userAgents = [
            'Mozilla/5.0 (compatible; YaDirectFetcher/1.0; +http://yandex.com/bots)' => '213.180.203.92',
            'Mozilla/5.0 (compatible; YaDirectFetcher/1.0; Dyatel; +http://yandex.com/bots)' => '213.180.203.92'
        ];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyYahooSiteExplorerFeedValidatorWebcrawler()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'Yahoo! Site Explorer Feed Validator http://help.yahoo.com/l/us/yahoo/search/siteexplorer/manage/';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '72.30.14.97'
        ));
    }

    public function testVerifyYahooSlurpWebcralwer()
    {
        $userAgents = [
            'Mozilla/5.0 (compatible; Yahoo! Slurp; http://help.yahoo.com/help/us/ysearch/slurp)' => '72.30.14.97',
            'Mozilla/5.0 (compatible; Yahoo! Slurp/3.0; http://help.yahoo.com/help/us/ysearch/slurp)'
                => '72.30.14.97',
            'Mozilla/5.0 (compatible; Yahoo! Slurp China; http://misc.yahoo.com.cn/help.html)' => '72.30.14.97'
        ];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyYahooCacheSystemWebcralwer()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'YahooCacheSystem';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '72.30.14.97'
        ));
    }

    public function testVerifyYahooMMCrawlerWebcralwer()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'YahooSeeker-Testing/v3.9 (compatible; Mozilla 4.0; MSIE 5.5; http://search.yahoo.com/)';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '72.30.14.97'
        ));
    }

    public function testVerifyYahooSeekerTestingWebcralwer()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'YahooSeeker-Testing/v3.9 (compatible; Mozilla 4.0; MSIE 5.5; http://search.yahoo.com/)';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '72.30.14.97'
        ));
    }

    public function testVerifyYahooYSMcmWebcralwer()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'Mozilla/5.0 (YahooYSMcm/3.0.0; http://help.yahoo.com)';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '72.30.14.97'
        ));
    }

    public function testVerifyYandexTranslateWebcrawler()
    {
        $userAgents = [
            'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.103'
                . ' Safari/537.36 Yandex.Translate' => '87.250.224.46',
            'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.97'
                . ' Safari/537.36 Yandex.Translate' => '87.250.224.46',
            'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.111'
                . ' Safari/537.36 Yandex.Translate' => '87.250.224.46',
            'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.86'
                . ' YaBrowser/15.12.0.6151 Safari/537.36 Yandex.Translate' => '87.250.224.46'
        ];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyYandexWebcrawler()
    {
        $userAgents = [
            'Yandex/1.01.001 (compatible; Win16; I)' => '87.250.224.46',
            'Yandex/1.01.001 (compatible; Win16; H)' => '141.8.132.28',
            'Yandex/1.01.001 (compatible; Win16; P)' => '87.250.224.46',
            'Yandex/1.01.001 (compatible; Win16; m)' => '5.255.253.26'
        ];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyYandexAccessibilityBotWebcrawler()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'Mozilla/5.0 (compatible; YandexAccessibilityBot/3.0; +http://yandex.com/bots)';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '87.250.224.96'
        ));
    }

    public function testVerifyYandexAdNetWebcrawler()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'Mozilla/5.0 (compatible; YandexAdNet/1.0; +http://yandex.com/bots)';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '87.250.224.46'
        ));
    }

    public function testVerifyYandexAddURLWebcrawler()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'Mozilla/5.0 (compatible; YandexAddurl/2.0)';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '87.250.224.46'
        ));
    }

    public function testVerifyYandexAntivirusWebcrawler()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'Mozilla/5.0 (compatible; YandexAntivirus/2.0; +http://yandex.com/bots)';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '87.250.224.46'
        ));
    }

    public function testVerifyYandexBlogsWebcrawler()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'Mozilla/5.0 (compatible; YandexBlogs/0.99; robot; +http://yandex.com/bots)';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '87.250.224.46'
        ));
    }

    public function testVerifyYandexBotWebcrawler()
    {
        $userAgents = [
            'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)' => '87.250.224.46',
            'Mozilla/5.0 (compatible; YandexBot/3.0; MirrorDetector; +http://yandex.com/bots)' => '5.255.253.26'
        ];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyYandexCalendarWebcrawler()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'Mozilla/5.0 (compatible; YandexCalendar/1.0; +http://yandex.com/bots)';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '87.250.224.46'
        ));
    }

    public function testVerifyYandexCatalogWebcrawler()
    {
        $userAgents = ['Mozilla/5.0 (compatible; YandexCatalog/3.0; +http://yandex.com/bots)' => '87.250.224.46'];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyYandexDirectWebcrawler()
    {
        $userAgents = [
            'Mozilla/5.0 (compatible; YandexDirect/3.0; +http://yandex.com/bots)' => '213.180.206.205',
            'Mozilla/5.0 (compatible; YandexDirectDyn/1.0; +http://yandex.com/bots)' => '213.180.206.205'
        ];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyYandexFaviconsWebcrawler()
    {
        $userAgents = ['Mozilla/5.0 (compatible; YandexFavicons/1.0; +http://yandex.com/bots)' => '87.250.224.46'];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyYandexForDomainWebcrawler()
    {
        $userAgents = ['Mozilla/5.0 (compatible; YandexForDomain/1.0; +http://yandex.com/bots)' => '87.250.224.46'];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyYandexVertisWebcrawler()
    {
        $userAgents = ['Mozilla/5.0 (compatible; YandexVertis/3.0; +http://yandex.com/bots)' => '87.250.224.46'];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyYandexImageResizerWebcrawler()
    {
        $userAgents = ['Mozilla/5.0 (compatible; YandexImageResizer/2.0; +http://yandex.com/bots)' => '87.250.224.46'];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyYandexImagesWebcrawler()
    {
        $userAgents = ['Mozilla/5.0 (compatible; YandexImages/3.0; +http://yandex.com/bots)' => '87.250.224.96'];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyYandexMarketWebcrawler()
    {
        $userAgents = ['Mozilla/5.0 (compatible; YandexMarket/1.0; +http://yandex.com/bots)' => '87.250.224.96'];

        $this->assertUserAgents($userAgents);
    }


    public function testVerifyYandexMediaWebcrawler()
    {
        $userAgents = [
            'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36'
                . ' (compatible; YandexMedianaBot/1.0;'
                . ' +http://yandex.com/bots)' => '5.255.231.84',
            'Mozilla/5.0 (compatible; YandexMedia/3.0; +http://yandex.com/bots)' => '5.255.231.84'
        ];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyYandexMetrikaWebcrawler()
    {
        $userAgents = [
            'Mozilla/5.0 (compatible; YandexMetrika/2.0; +http://yandex.com/bots mtmon01e.yandex.ru)'
                => '95.108.129.196',
            'Mozilla/5.0 (compatible; YandexMetrika/2.0; +http://yandex.com/bots mtmon01g.yandex.ru)'
                => '213.180.206.196',
            'Mozilla/5.0 (compatible; YandexMetrika/2.0; +http://yandex.com/bots mtmon01i.yandex.ru)'
                => '87.250.224.46',
            'Mozilla/5.0 (compatible; YandexMetrika/2.0; +http://yandex.com/bots)' => '87.250.224.46',
            'Mozilla/5.0 (compatible; YandexMetrika/2.0; +http://yandex.com/bots mtweb01t.yandex.ru)'
                => '87.250.224.46',
            'Mozilla/5.0 (compatible; YandexMetrika/2.0; +http://yandex.com/bots DEV)' => '87.250.224.46'
        ];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyYandexMobileBotWebcrawler()
    {
        $userAgents = ['Mozilla/5.0 (iPhone; CPU iPhone OS 8_1 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko)'
            . ' Version/8.0 Mobile/12B411 Safari/600.1.4 (compatible; YandexMobileBot/3.0; +http://yandex.com/bots)' =>
            '87.250.224.46'];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyYandexNewsWebcrawler()
    {
        $userAgents = [
            'Mozilla/5.0 (compatible; YandexNews/3.0; +http://yandex.com/bots)' => '87.250.224.46',
            'Mozilla/5.0 (compatible; YandexNewslinks; +http://yandex.com/bots)' => '87.250.224.46'
        ];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyYandexPagecheckerWebcrawler()
    {
        $webcrawlerVerifier = new WebcrawlerVerifier();
        $userAgent = 'Mozilla/5.0 (compatible; YandexPagechecker/1.0; +http://yandex.com/bots)';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '5.255.231.84'
        ));
    }

    public function testVerifyYandexScreenshotBotWebcrawler()
    {
        $userAgents = ['Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko)'
            . ' Chrome/41.0.2228.0 Safari/537.36 (compatible; YandexScreenshotBot/3.0; +http://yandex.com/bots)' => '87.250.224.46'];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyYandexSomethingWebcrawler()
    {
        $userAgents = ['YandexSomething/1.0' => '87.250.224.46'];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyYandexSearchShopWebcrawler()
    {
        $userAgents = ['Mozilla/5.0 (compatible; YandexSearchShop/1.0; +http://yandex.com/bots)' => '87.250.224.46'];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyYandexSpravBotWebcrawler()
    {
        $userAgents = ['Mozilla/5.0 (compatible; YandexSpravBot/1.0; +http://yandex.com/bots)' => '87.250.224.46'];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyYandexSitelinksWebcrawler()
    {
        $userAgents = ['Mozilla/5.0 (compatible; YandexSitelinks; Dyatel; +http://yandex.com/bots)' => '87.250.224.46'];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyYandexVideoWebcrawler()
    {
        $userAgents = [
            'Mozilla/5.0 (compatible; YandexVideo/3.0; +http://yandex.com/bots)' => '141.8.142.60',
            'Mozilla/5.0 (compatible; YandexVideoParser/1.0; +http://yandex.com/bots)' => '141.8.142.60'
        ];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyYandexWebmasterWebcrawler()
    {
        $userAgents = ['Mozilla/5.0 (compatible; YandexWebmaster/2.0; +http://yandex.com/bots)' => '87.250.224.46'];

        $this->assertUserAgents($userAgents);
    }

    public function testVerifyYandexZakladkiWebcrawler()
    {
        $userAgents = ['Mozilla/5.0 (compatible; YandexZakladki/3.0; +http://yandex.com/bots)' => '87.250.224.46'];

        $this->assertUserAgents($userAgents);
    }

    private function assertUserAgents(array $userAgents): void
    {
        $verifier = new WebcrawlerVerifier();

        foreach ($userAgents as $userAgent => $ip) {
            $this->assertEquals($verifier::UNVERIFIED, $verifier->verify(
                $userAgent,
                '192.168.0.1'
            ));
            $this->assertEquals($verifier::VERIFIED, $verifier->verify(
                $userAgent,
                $ip
            ), "Failed to verify for IP: $ip");
        }
    }
}
