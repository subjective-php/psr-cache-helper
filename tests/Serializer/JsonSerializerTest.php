<?php

namespace ChadicusTest\Psr\SimpleCache\Serializer;

use Chadicus\Psr\SimpleCache\Serializer\JsonSerializer;

/**
 * @coversDefaultClass \Chadicus\Psr\SimpleCache\Serializer\JsonSerializer
 * @covers ::__construct
 * @covers ::<private>
 */
final class JsonSerializerTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     * @covers ::unserialize
     *
     * @return void
     */
    public function unserialize()
    {
        $serializer = new JsonSerializer();
        $this->assertSame(['foo' => 'abc', 'bar' => 123], $serializer->unserialize('{"foo": "abc","bar": 123}'));
    }

    /**
     * @test
     * @covers ::unserialize
     *
     * @return void
     */
    public function unserializeToObject()
    {
        $serializer = new JsonSerializer(false);
        $this->assertEquals(
            (object)['foo' => 'abc', 'bar' => 123],
            $serializer->unserialize('{"foo": "abc","bar": 123}')
        );
    }

    /**
     * @test
     * @covers ::unserialize
     * @expectedException \Psr\SimpleCache\InvalidArgumentException
     * @expectedExceptionMessage Syntax error
     *
     * @return void
     */
    public function unserializeFailure()
    {
        $serializer = new JsonSerializer();
        $json = '{"foo": "abc","bar": 123';
        $serializer->unserialize($json);
    }

    /**
     * @test
     * @covers ::serialize
     *
     * @return void
     */
    public function serialize()
    {
        $serializer = new JsonSerializer(true, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        $expected = <<<JSON
{
    "foo": "abc",
    "bar": 123
}
JSON;
        $this->assertSame($expected, $serializer->serialize(['foo' => 'abc', 'bar' => 123]));
    }

    /**
     * @test
     * @covers ::serialize
     * @expectedException \Psr\SimpleCache\InvalidArgumentException
     * @expectedExceptionMessage Inf and NaN cannot be JSON encoded
     *
     * @return void
     */
    public function serializeFailure()
    {
        $serializer = new JsonSerializer();
        $serializer->serialize(['foo' => NAN]);
    }
}
