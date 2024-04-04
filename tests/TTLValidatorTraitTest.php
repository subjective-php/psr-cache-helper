<?php

namespace SubjectivePHPTest\Psr\SimpleCache;

use SubjectivePHP\Psr\SimpleCache\TTLValidatorTrait;

/**
 * @coversDefaultClass \SubjectivePHP\Psr\SimpleCache\TTLValidatorTrait
 */
final class TTLValidatorTraitTest extends \PHPUnit\Framework\TestCase
{
    use TTLValidatorTrait;

    /**
     * @param mixed $ttl The ttl value which will validate.
     *
     * @test
     * @covers ::validateTTL
     * @dataProvider provideValidTTLs
     *
     * @return void
     */
    public function validateTTLWithValidValues($ttl)
    {
        $this->assertNull($this->validateTTL($ttl));
    }

    /**
     * Provides valid ttls for testing.
     *
     * @return array
     */
    public static function provideValidTTLs()
    {
        return [
            [null],
            [\DateInterval::createFromDateString('1 day')],
            [3600],
        ];
    }

    /**
     * @param mixed $ttl The ttl value which will throw an execption.
     *
     * @test
     * @covers ::validateTTL
     * @dataProvider provideInvalidTTLs
     *
     * @return void
     */
    public function validateTTLWithInvalidValue($ttl)
    {
        $this->expectException(\Psr\SimpleCache\InvalidArgumentException::class);

        $this->validateTTL($ttl);
    }

    /**
     * Provides valid ttls for testing.
     *
     * @return array
     */
    public static function provideInvalidTTLs()
    {
        return [
            [''],
            [1.1],
            [new \DateTime()],
        ];
    }
}
