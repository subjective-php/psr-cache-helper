<?php

namespace SubjectivePHPTest\Psr\SimpleCache;

use SubjectivePHP\Psr\SimpleCache\NullCache;

/**
 * @coversDefaultClass SubjectivePHP\Psr\SimpleCache\NullCache
 * @covers ::<private>
 * @covers ::<protected>
 */
final class NullCacheTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Verify basic behavior of get().
     *
     * @test
     * @covers ::get
     *
     * @return void
     */
    public function get()
    {
        $cache = new NullCache();
        $default = new \StdClass();
        $this->assertSame($default, $cache->get('a key', $default));
    }

    /**
     * Verify basic behavior of set().
     *
     * @test
     * @covers ::set
     *
     * @return void
     */
    public function set()
    {
        $cache = new NullCache();
        $this->assertTrue($cache->set('a key', 'some data'));
    }

    /**
     * Verify basic behavior of delete().
     *
     * @test
     * @covers ::delete
     *
     * @return void
     */
    public function delete()
    {
        $cache = new NullCache();
        $this->assertTrue($cache->delete('a key'));
    }

    /**
     * Verify basic behavior of clear().
     *
     * @test
     * @covers ::clear
     *
     * @return void
     */
    public function clear()
    {
        $cache = new NullCache();
        $this->assertTrue($cache->clear());
    }

    /**
     * Verify basic behavior of getMultple().
     *
     * @test
     * @covers ::getMultiple
     *
     * @return void
     */
    public function getMultiple()
    {
        $cache = new NullCache();
        $default = new \StdClass();
        $this->assertSame(
            ['key1' => $default, 'key2' => $default],
            $cache->getMultiple(['key1', 'key2'], $default)
        );
    }

    /**
     * Verify basic behavior of setMultiple().
     *
     * @test
     * @covers ::setMultiple
     *
     * @return void
     */
    public function setMultiple()
    {
        $cache = new NullCache();
        $this->assertTrue($cache->setMultiple(['key' => 'some data', 'key2' => 'some more data']));
    }

    /**
     * Verify basic behavior of deleteMultiple().
     *
     * @test
     * @covers ::deleteMultiple
     *
     * @return void
     */
    public function deleteMultiple()
    {
        $cache = new NullCache();
        $this->assertTrue($cache->deleteMultiple(['key1', 'key2']));
    }

    /**
     * Verify basic behavior of has().
     *
     * @test
     * @covers ::has
     *
     * @return void
     */
    public function has()
    {
        $cache = new NullCache();
        $this->assertFalse($cache->has('key1'));
    }
}
