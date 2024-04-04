<?php

namespace SubjectivePHPTest\Psr\SimpleCache\Serializer;

use SubjectivePHP\Psr\SimpleCache\Serializer\NullSerializer;

/**
 * @coversDefaultClass \SubjectivePHP\Psr\SimpleCache\Serializer\NullSerializer
 * @covers ::<private>
 */
final class NullSerializerTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     * @covers ::unserialize
     *
     * @return void
     */
    public function unserialize()
    {
        $serializer = new NullSerializer();
        $data = ['foo' => 'abc', 'bar' => 123];
        $this->assertSame($data, $serializer->unserialize($data));
    }

    /**
     * @test
     * @covers ::serialize
     *
     * @return void
     */
    public function serialize()
    {
        $serializer = new NullSerializer();
        $data = ['foo' => 'abc', 'bar' => 123];
        $this->assertSame($data, $serializer->serialize($data));
    }
}
