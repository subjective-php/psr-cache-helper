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
     * @var NullSerializer
     */
    private $serializer;

    /**
     * Prepare each test
     *
     * @return void
     */
    public function setUp()
    {
        $this->serializer = new NullSerializer();
    }

    /**
     * @test
     * @covers ::unserialize
     *
     * @return void
     */
    public function unserialize()
    {
        $data = ['foo' => 'abc', 'bar' => 123];
        $this->assertSame($data, $this->serializer->unserialize($data));
    }

    /**
     * @test
     * @covers ::serialize
     *
     * @return void
     */
    public function serialize()
    {
        $data = ['foo' => 'abc', 'bar' => 123];
        $this->assertSame($data, $this->serializer->serialize($data));
    }
}
