<?php

namespace ChadicusTest\Psr\SimpleCache;

use Chadicus\Psr\SimpleCache\KeyValidatorTrait;

/**
 * @coversDefaultClass \Chadicus\Psr\SimpleCache\KeyValidatorTrait
 * @covers ::<private>
 */
final class KeyValidatorTraitTest extends \PHPUnit\Framework\TestCase
{
    use KeyValidatorTrait;

    /**
     * @test
     * @covers ::validateKey
     *
     * @return void
     */
    public function validateKeyWithString()
    {
        $this->assertNull($this->validateKey('a valid string'));
    }

    /**
     * @param mixed $key The key value which will throw an execption.
     *
     * @test
     * @covers ::validateKey
     * @expectedException \Psr\SimpleCache\InvalidArgumentException
     * @dataProvider provideInvalidKeys
     *
     * @return void
     */
    public function validateKeyWithInvalidValue($key)
    {
        $this->validateKey($key);
    }

    /**
     * Provides valid keys for testing.
     *
     * @return array
     */
    public function provideInvalidKeys() : array
    {
        return [
            ['an empty string' => ''],
            ['an object' => new \StdClass()],
            ['an integer' => 123],
            ['reserved characters' => '@key'],
        ];
    }
}
