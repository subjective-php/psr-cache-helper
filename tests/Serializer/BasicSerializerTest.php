<?php

namespace ChadicusTest\Psr\SimpleCache\Serializer;

use Chadicus\Psr\SimpleCache\Serializer\BasicSerializer;

/**
 * @coversDefaultClass \Chadicus\Psr\SimpleCache\Serializer\BasicSerializer
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
     * @expectedException \Psr\SimpleCache\InvalidArgumentException
     * @expectedExceptionMessage unserialize(): Error at offset 34 of 34 bytes
     *
     * @return void
     */
    public function unserializeInvalidData()
    {
        $serializer = new BasicSerializer();
        $serializer->unserialize('a:2:{s:3:"foo";s:3:"abc";s:3:"bar"');
    }

    /**
     * @test
     * @covers ::unserialize
     * @expectedException \Psr\SimpleCache\InvalidArgumentException
     * @expectedExceptionMessage $data must be a string
     *
     * @return void
     */
    public function unserializeNonStringData()
    {
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
     * @expectedException \Psr\SimpleCache\InvalidArgumentException
     * @expectedExceptionMessage Serialization of 'Closure' is not allowed
     *
     * @return void
     */
    public function serializeFilure()
    {
        $serializer = new BasicSerializer();
        $serializer->serialize(
            function () {
            }
        );
    }
}
