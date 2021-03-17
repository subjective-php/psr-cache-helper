<?php

namespace SubjectivePHPTest\Psr\SimpleCache\Serializer;

use SubjectivePHP\Psr\SimpleCache\Serializer\JsonSerializer;

/**
 * @coversDefaultClass \SubjectivePHP\Psr\SimpleCache\Serializer\JsonSerializer
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
     *
     * @return void
     */
    public function unserializeFailure()
    {
        $this->expectException(\Psr\SimpleCache\InvalidArgumentException::class);
        $this->expectExceptionMessage('Syntax error');

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
     *
     * @return void
     */
    public function serializeFailure()
    {
        $this->expectException(\Psr\SimpleCache\InvalidArgumentException::class);
        $this->expectExceptionMessage('Inf and NaN cannot be JSON encoded');

        $serializer = new JsonSerializer();
        $serializer->serialize(['foo' => NAN]);
    }
}
