<?php

namespace SubjectivePHP\Psr\SimpleCache\Serializer;

use SubjectivePHP\Psr\SimpleCache\InvalidArgumentException;

/**
 * Serializer implementation that does nothing with the given data.
 */
final class NullSerializer implements SerializerInterface
{
    /**
     * Unserializes cached data into the original state.
     *
     * @param mixed $data The data to unserialize.
     *
     * @return mixed
     */
    public function unserialize($data)
    {
        return $data;
    }

    /**
     * Serializes the given data for storage in caching.
     *
     * @param mixed $value The data to serialize for caching.
     *
     * @return mixed The result of serializing the given $data.
     */
    public function serialize($value)
    {
        return $value;
    }
}
