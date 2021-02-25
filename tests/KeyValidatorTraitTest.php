<?php

namespace SubjectivePHPTest\Psr\SimpleCache;

use SubjectivePHP\Psr\SimpleCache\KeyValidatorTrait;

/**
 * @coversDefaultClass \SubjectivePHP\Psr\SimpleCache\KeyValidatorTrait
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
     * @dataProvider provideInvalidKeys
     *
     * @return void
     */
    public function validateKeyWithInvalidValue($key)
    {
        $this->expectException(\Psr\SimpleCache\InvalidArgumentException::class);
        $this->validateKey($key);
    }

    /**
     * @test
     * @covers ::validateKeys
     *
     * @return void
     */
    public function validateKeysWithString()
    {
        $this->assertNull($this->validateKeys(['a valid string', 'another valid string']));
    }

    /**
     * @param mixed $key The key value which will throw an execption.
     *
     * @test
     * @covers ::validateKeys
     * @dataProvider provideInvalidKeys
     *
     * @return void
     */
    public function validateKeysWithInvalidValue($key)
    {
        $this->expectException(\Psr\SimpleCache\InvalidArgumentException::class);
        $this->validateKeys(['valid_key', $key, 'another_valid_key']);
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
