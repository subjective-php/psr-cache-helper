<?php

namespace Chadicus\Psr\SimpleCache;

/**
 * Contract for object responsible for serializing and unserializing data for caching.
 */
interface SerializerInterface
{
    /**
     * Unserializes cached data into the original state.
     *
     * @param array $data The data to unserialize.
     *
     * @return mixed
     */
    public function unserialize(array $data);

    /**
     * Serializes the given data for storage in caching.
     *
     * @param mixed $value The data to serialize for caching.
     *
     * @return array The result of serializing the given $data.
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException Thrown if the given value cannot be serialized for caching.
     */
    public function serialize($value) : array;
}
