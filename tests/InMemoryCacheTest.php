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
     * @test
     * @covers ::get
     *
     * @return void
     */
    public function get()
    {
        $container = new ArrayObject();
        $cache = new InMemoryCache($container);
        $dateTime = new DateTime();
        $container['foo'] = ['data' => $dateTime, 'expires' => PHP_INT_MAX];
        $this->assertEquals($dateTime, $cache->get('foo'));
    }

    /**
     * @test
     * @covers ::get
     *
     * @return void
     */
    public function getKeyNotFound()
    {
        $cache = new InMemoryCache(new ArrayObject());
        $default = new \StdClass();
        $this->assertSame($default, $cache->get('foo', $default));
    }

    /**
     * @test
     * @covers ::get
     *
     * @return void
     */
    public function getExpired()
    {
        $container = new ArrayObject();
        $container['foo'] = ['data' => new DateTime(), 'expires' => -10];
        $cache = new InMemoryCache($container);
        $this->assertNull($cache->get('foo'));
    }

    /**
     * @test
     * @covers ::getMultiple
     *
     * @return void
     */
    public function getMultple()
    {
        $cache = new InMemoryCache(new ArrayObject());
        $default = new \StdClass();
        $dateTime = new \DateTime();
        $exception = new \RuntimeException();
        $cache->set('foo', $dateTime);
        $cache->set('bar', $exception);
        $actual = $cache->getMultiple(['foo', 'baz', 'bar'], $default);
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
        $container = new ArrayObject();
        $cache = new InMemoryCache($container);
        $dateTime = new \DateTime();
        $this->assertTrue($cache->set('foo', $dateTime, 3600));
        $this->assertSame(
            [
                'foo' => [
                    'data' => $dateTime,
                    'expires' => time() + 3600,
                ],
            ],
            $container->getArrayCopy()
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
        $cache = new InMemoryCache(new ArrayObject());
        $this->assertTrue($cache->set('foo', $dateTime));
        $this->assertEquals($dateTime, $cache->get('foo'));
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
        $cache = new InMemoryCache(new ArrayObject());
        $this->assertTrue($cache->setMultiple(['foo' => $dateTime, 'bar' => $exception], $ttl));
        $this->assertEquals($dateTime, $cache->get('foo'));
        $this->assertEquals($exception, $cache->get('bar'));
    }

    /**
     * @test
     * @covers ::delete
     *
     * @return void
     */
    public function delete()
    {
        $cache = new InMemoryCache(new ArrayObject());
        $dateTime = new DateTime();
        $cache->set('foo', $dateTime);
        $cache->delete('foo');
        $this->assertNull($cache->get('foo'));
    }

    /**
     * @test
     * @covers ::deleteMultiple
     *
     * @return void
     */
    public function deleteMultiple()
    {
        $cache = new InMemoryCache(new ArrayObject());
        $cache->set('foo', 'foo');
        $cache->set('bar', 'bar');
        $cache->set('baz', 'baz');

        $cache->deleteMultiple(['foo', 'bar']);
        $this->assertNull($cache->get('foo'));
        $this->assertNull($cache->get('bar'));
        $this->assertSame('baz', $cache->get('baz'));
    }

    /**
     * @test
     * @covers ::clear
     *
     * @return void
     */
    public function clear()
    {
        $container = new ArrayObject();
        $cache = new InMemoryCache($container);
        $cache->set('foo', 'foo');
        $cache->set('bar', 'bar');
        $cache->set('baz', 'baz');

        $cache->clear();

        $this->assertSame([], $container->getArrayCopy());
    }

    /**
     * @test
     * @covers ::has
     *
     * @return void
     */
    public function has()
    {
        $cache = new InMemoryCache(new ArrayObject());
        $cache->set('foo', 'foo');
        $this->assertTrue($cache->has('foo'));
        $this->assertFalse($cache->has('bar'));
    }
}
