<?php

namespace SubjectivePHPTest\Psr\SimpleCache;

use ArrayObject;
use DateTime;
use SubjectivePHP\Psr\SimpleCache\InMemoryCache;

/**
 * @coversDefaultClass \SubjectivePHP\Psr\SimpleCache\InMemoryCache
 * @covers ::__construct
 * @covers ::<private>
 */
final class InMemoryCacheTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var InMemoryCache
     */
    private $cache;

    /**
     * @var ArrayObject
     */
    private $container;

    /**
     * @return void
     */
    public function setUp() : void
    {
        $this->container = new ArrayObject();
        $this->cache = new InMemoryCache($this->container);
    }

    /**
     * @test
     * @covers ::get
     *
     * @return void
     */
    public function get()
    {
        $dateTime = new DateTime();
        $this->container['foo'] = ['data' => $dateTime, 'expires' => PHP_INT_MAX];
        $this->assertEquals($dateTime, $this->cache->get('foo'));
    }

    /**
     * @test
     * @covers ::get
     *
     * @return void
     */
    public function getKeyNotFound()
    {
        $default = new \StdClass();
        $this->assertSame($default, $this->cache->get('foo', $default));
    }

    /**
     * @test
     * @covers ::get
     *
     * @return void
     */
    public function getExpired()
    {
        $this->container['foo'] = ['data' => new DateTime(), 'expires' => -10];
        $this->assertNull($this->cache->get('foo'));
    }

    /**
     * @test
     * @covers ::getMultiple
     *
     * @return void
     */
    public function getMultple()
    {
        $default = new \StdClass();
        $dateTime = new \DateTime();
        $exception = new \RuntimeException();
        $this->cache->set('foo', $dateTime);
        $this->cache->set('bar', $exception);
        $actual = $this->cache->getMultiple(['foo', 'baz', 'bar'], $default);
        $this->assertEquals($dateTime, $actual['foo']);
        $this->assertSame($default, $actual['baz']);
        $this->assertEquals($exception, $actual['bar']);
    }

    /**
     * @test
     * @covers ::set
     *
     * @return void
     */
    public function setWithIntegerTTL()
    {
        $dateTime = new \DateTime();
        $this->assertTrue($this->cache->set('foo', $dateTime, 3600));
        $this->assertSame(
            [
                'foo' => [
                    'data' => $dateTime,
                    'expires' => time() + 3600,
                ],
            ],
            $this->container->getArrayCopy()
        );
    }

    /**
     * @test
     * @covers ::set
     *
     * @return void
     */
    public function setWithNullTTL()
    {
        $dateTime = new \DateTime();
        $this->assertTrue($this->cache->set('foo', $dateTime));
        $this->assertEquals($dateTime, $this->cache->get('foo'));
    }

    /**
     * @test
     * @covers ::setMultiple
     *
     * @return void
     */
    public function setMultple()
    {
        $ttl = \DateInterval::createFromDateString('1 day');
        $dateTime = new \DateTime();
        $exception = new \RuntimeException();
        $this->assertTrue($this->cache->setMultiple(['foo' => $dateTime, 'bar' => $exception], $ttl));
        $this->assertEquals($dateTime, $this->cache->get('foo'));
        $this->assertEquals($exception, $this->cache->get('bar'));
    }

    /**
     * @test
     * @covers ::delete
     *
     * @return void
     */
    public function delete()
    {
        $dateTime = new DateTime();
        $this->cache->set('foo', $dateTime);
        $this->cache->delete('foo');
        $this->assertNull($this->cache->get('foo'));
    }

    /**
     * @test
     * @covers ::deleteMultiple
     *
     * @return void
     */
    public function deleteMultiple()
    {
        $this->cache->set('foo', 'foo');
        $this->cache->set('bar', 'bar');
        $this->cache->set('baz', 'baz');

        $this->cache->deleteMultiple(['foo', 'bar']);
        $this->assertNull($this->cache->get('foo'));
        $this->assertNull($this->cache->get('bar'));
        $this->assertSame('baz', $this->cache->get('baz'));
    }

    /**
     * @test
     * @covers ::clear
     *
     * @return void
     */
    public function clear()
    {
        $this->cache->set('foo', 'foo');
        $this->cache->set('bar', 'bar');
        $this->cache->set('baz', 'baz');

        $this->cache->clear();

        $this->assertSame([], $this->container->getArrayCopy());
    }

    /**
     * @test
     * @covers ::has
     *
     * @return void
     */
    public function has()
    {
        $this->cache->set('foo', 'foo');
        $this->assertTrue($this->cache->has('foo'));
        $this->assertFalse($this->cache->has('bar'));
    }
}
