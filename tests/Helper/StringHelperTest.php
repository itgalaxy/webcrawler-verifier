<?php
namespace WebcrawlerVerifier\Tests\Helper;

use PHPUnit\Framework\TestCase;
use WebcrawlerVerifier\Helper\StringHelper;

class StringHelperTest extends TestCase
{
    public function testSuccess()
    {
        $this->assertEquals(true, StringHelper::endsWith('foo', 'foobar.bar.foo'));
        $this->assertEquals(true, StringHelper::endsWith('bar.foo', 'foobar.bar.foo'));
        $this->assertEquals(true, StringHelper::endsWith('foobar.bar.foo', 'foobar.bar.foo'));
        $this->assertEquals(true, StringHelper::endsWith('', 'foobar.bar.foo'));
    }

    public function testFailure()
    {
        $this->assertEquals(false, StringHelper::endsWith('bar', 'foobar.bar.foo'));
        $this->assertEquals(false, StringHelper::endsWith('foo.bar', 'foobar.bar.foo'));
        $this->assertEquals(false, StringHelper::endsWith('foobar.bar.foo', 'barfoo.foo.bar'));
    }
}
