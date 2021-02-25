<?php

namespace SubjectivePHPTest\Psr\SimpleCache\Serializer;

use SubjectivePHP\Psr\SimpleCache\Serializer\BasicSerializer;

/**
 * @coversDefaultClass \SubjectivePHP\Psr\SimpleCache\Serializer\BasicSerializer
 * @covers ::<private>
 */
final class BasicSerializerTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     * @covers ::unserialize
     *
     * @return void
     */
    public function unserialize()
    {
        $serializer = new BasicSerializer();
        $this->assertSame(
            ['foo' => 'abc', 'bar' => 123],
            $serializer->unserialize('a:2:{s:3:"foo";s:3:"abc";s:3:"bar";i:123;}')
        );
    }

    /**
     * @test
     * @covers ::unserialize
     *
     * @return void
     */
    public function unserializeInvalidData()
    {
        $this->expectException(\Psr\SimpleCache\InvalidArgumentException::class);
        $this->expectExceptionMessage('unserialize(): Error at offset 34 of 34 bytes');

        $serializer = new BasicSerializer();
        $serializer->unserialize('a:2:{s:3:"foo";s:3:"abc";s:3:"bar"');
    }

    /**
     * @test
     * @covers ::unserialize
     *
     * @return void
     */
    public function unserializeNonStringData()
    {
        $this->expectException(\Psr\SimpleCache\InvalidArgumentException::class);
        $this->expectExceptionMessage('$data must be a string');

        $serializer = new BasicSerializer();
        $serializer->unserialize(true);
    }

    /**
     * @test
     * @covers ::serialize
     *
     * @return void
     */
    public function serialize()
    {
        $serializer = new BasicSerializer();
        $this->assertSame(
            'a:2:{s:3:"foo";s:3:"abc";s:3:"bar";i:123;}',
            $serializer->serialize(['foo' => 'abc', 'bar' => 123])
        );
    }

    /**
     * @test
     * @covers ::serialize
     *
     * @return void
     */
    public function serializeFilure()
    {
        $this->expectException(\Psr\SimpleCache\InvalidArgumentException::class);
        $this->expectExceptionMessage("Serialization of 'Closure' is not allowed");

        $serializer = new BasicSerializer();
        $serializer->serialize(
            function () {
            }
        );
    }
}
