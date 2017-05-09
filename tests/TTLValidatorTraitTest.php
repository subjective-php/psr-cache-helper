<?php

namespace ChadicusTest\Psr\SimpleCache;

use Chadicus\Psr\SimpleCache\TTLValidatorTrait;

/**
 * @coversDefaultClass \Chadicus\Psr\SimpleCache\TTLValidatorTrait
 * @covers ::<private>
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
    public function provideValidTTLs()
    {
        return [
            ['null' => null],
            ['DateInterval' => \DateInterval::createFromDateString('1 day')],
            ['int' => 3600],
        ];
    }

    /**
     * @param mixed $ttl The ttl value which will throw an execption.
     *
     * @test
     * @covers ::validateTTL
     * @expectedException \Psr\SimpleCache\InvalidArgumentException
     * @dataProvider provideInvalidTTLs
     *
     * @return void
     */
    public function validateTTLWithInvalidValue($ttl)
    {
        $this->validateTTL($ttl);
    }

    /**
     * Provides valid ttls for testing.
     *
     * @return array
     */
    public function provideInvalidTTLs()
    {
        return [
            ['string' => ''],
            ['float' => 1.1],
            ['DdateTime' => new \DateTime()],
        ];
    }
}
