<?php
use PHPUnit\Framework\TestCase;

class WebcrawlerVerifierTest extends TestCase
{
    public function testVerifyInvalidUserAgent()
    {
        $this->expectException(InvalidArgumentException::class);
        $webcrawlerVerifier = new \WebcrawlerVerifier\WebcrawlerVerifier();
        $userAgent = [];

        $this->assertEquals($webcrawlerVerifier::UNKNOWN, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
    }

    public function testVerifyInvalidIP()
    {
        $this->expectException(InvalidArgumentException::class);
        $webcrawlerVerifier = new \WebcrawlerVerifier\WebcrawlerVerifier();
        $userAgent = 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)';

        $this->assertEquals($webcrawlerVerifier::UNKNOWN, $webcrawlerVerifier->verify(
            $userAgent,
            123
        ));
    }

    public function testVerifyEmptyUserAgent()
    {
        $webcrawlerVerifier = new \WebcrawlerVerifier\WebcrawlerVerifier();
        $userAgent = '';

        $this->assertEquals($webcrawlerVerifier::UNKNOWN, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
    }

    public function testVerifyAppleWebcrawler()
    {
        $webcrawlerVerifier = new \WebcrawlerVerifier\WebcrawlerVerifier();
        $userAgent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.2.5 (KHTML, like Gecko) '
            . 'Version/8.0.2 Safari/600.2.5 (Applebot/0.1; +http://www.apple.com/go/applebot)';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '17.142.150.187'
        ));
    }

    public function testVerifyBaiduWebcrawler()
    {
        $webcrawlerVerifier = new \WebcrawlerVerifier\WebcrawlerVerifier();
        $userAgent = 'Mozilla/5.0 (compatible; Baiduspider/2.0; +http://www.baidu.com/search/spider.html)';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '123.125.66.120'
        ));
    }

    public function testVerifyBingWebcrawler()
    {
        $webcrawlerVerifier = new \WebcrawlerVerifier\WebcrawlerVerifier();
        $bindbotUserAgent = 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $bindbotUserAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $bindbotUserAgent,
            '40.77.167.10'
        ));

        $msnbotUserAgent = 'msnbot/2.0b (+http://search.msn.com/msnbot.htm)';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $msnbotUserAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $msnbotUserAgent,
            '40.77.167.10'
        ));

        $msnbotMediaUserAgent = 'msnbot-media/1.1 (+http://search.msn.com/msnbot.htm)';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $msnbotMediaUserAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $msnbotMediaUserAgent,
            '40.77.167.10'
        ));

        $adldxbotUserAgent = 'Mozilla/5.0 (compatible; adidxbot/2.0; +http://www.bing.com/bingbot.htm)';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $adldxbotUserAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $adldxbotUserAgent,
            '40.77.167.10'
        ));

        $bingPreviewUserAgent
            = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/534+ (KHTML, like Gecko) BingPreview/1.0b';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $bingPreviewUserAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $bingPreviewUserAgent,
            '40.77.167.10'
        ));
    }

    public function testVerifyDeusuWebcrawler()
    {
        $webcrawlerVerifier = new \WebcrawlerVerifier\WebcrawlerVerifier();
        $userAgent = 'Mozilla/5.0 (compatible; DeuSu/5.0.2; +https://deusu.de/robot.html)';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '85.93.91.84'
        ));
    }

    public function testVerifyExaleadWebcrawler()
    {
        $webcrawlerVerifier = new \WebcrawlerVerifier\WebcrawlerVerifier();
        $userAgent = 'Mozilla/5.0 (compatible; Exabot/3.0; +http://www.exabot.com/go/robot)';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '178.255.215.89'
        ));
    }

    public function testVerifyGoogleWebcrawler()
    {
        $webcrawlerVerifier = new \WebcrawlerVerifier\WebcrawlerVerifier();
        $userAgent = 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '66.249.66.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '66.249.90.77'
        ));
    }

    public function testVerifyGrapeshotWebcrawler()
    {
        $webcrawlerVerifier = new \WebcrawlerVerifier\WebcrawlerVerifier();
        $userAgent = 'Mozilla/5.0 (compatible; GrapeshotCrawler/2.0; +https://www.grapeshot.com/crawler/)';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '89.145.95.68'
        ));
    }

    public function testVerifyIstellaWebcrawler()
    {
        $webcrawlerVerifier = new \WebcrawlerVerifier\WebcrawlerVerifier();
        $userAgent = 'istellabot/t.1';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '217.73.208.150'
        ));
    }

    public function testVerifyMailRUWebcrawler()
    {
        $webcrawlerVerifier = new \WebcrawlerVerifier\WebcrawlerVerifier();
        $userAgent = 'Mozilla/5.0 (compatible; Linux x86_64; Mail.RU_Bot/2.0; +http://go.mail.ru/help/robots)';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '217.69.133.191'
        ));
    }

    public function testVerifySeznamWebcrawler()
    {
        $webcrawlerVerifier = new \WebcrawlerVerifier\WebcrawlerVerifier();
        $userAgent = 'Mozilla/5.0 (compatible; SeznamBot/3.2; +http://napoveda.seznam.cz/en/seznambot-intro/)';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '77.75.77.54'
        ));
    }

    public function testVerifySputnikWebcrawler()
    {
        $webcrawlerVerifier = new \WebcrawlerVerifier\WebcrawlerVerifier();
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

    public function testVerifyYahooWebcrawler()
    {
        $webcrawlerVerifier = new \WebcrawlerVerifier\WebcrawlerVerifier();
        $userAgent = 'Mozilla/5.0 (compatible; Yahoo! Slurp; http://help.yahoo.com/help/us/ysearch/slurp)';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $userAgent,
            '68.180.230.162'
        ));
    }

    public function testVerifyYandexWebcrawler()
    {
        $webcrawlerVerifier = new \WebcrawlerVerifier\WebcrawlerVerifier();
        $standardUserAgent = 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $standardUserAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $standardUserAgent,
            '95.108.129.196'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $standardUserAgent,
            '37.9.118.28'
        ));

        $directFetcherUserAgent = 'Mozilla/5.0 (compatible; YaDirectFetcher/1.0; Dyatel; +http://yandex.com/bots)';

        $this->assertEquals($webcrawlerVerifier::UNVERIFIED, $webcrawlerVerifier->verify(
            $directFetcherUserAgent,
            '192.168.0.1'
        ));
        $this->assertEquals($webcrawlerVerifier::VERIFIED, $webcrawlerVerifier->verify(
            $directFetcherUserAgent,
            '95.108.129.196'
        ));
    }
}
