<?php

namespace Chadicus\Psr\SimpleCache\Serializer;

use Chadicus\Psr\SimpleCache\InvalidArgumentException;

/**
 * Uses native php serialize functions for serializing data.
 */
final class BasicSerializer implements SerializerInterface
{
    /**
     * Unserializes cached data into the original state.
     *
     * @param mixed $data The data to unserialize.
     *
     * @return mixed
     *
     * @throws InvalidArgumentException Thrown if the given value cannot be unserialized.
     */
    public function unserialize($data)
    {
        $this->throwIfTrue(!is_string($data), '$data must be a string');

        set_error_handler($this->getErrorHandler());
        try {
            $unserialized = unserialize($data);
            $this->throwIfTrue($unserialized === false, '$data could not be unserialized');
            return $unserialized;
        } finally {
            restore_error_handler();
        }
    }//@codeCoverageIgnore

    /**
     * Serializes the given data for storage in caching.
     *
     * @param mixed $value The data to serialize for caching.
     *
     * @return mixed The result of serializing the given $data.
     *
     * @throws InvalidArgumentException Thrown if the given value cannot be serialized for caching.
     */
    public function serialize($value)
    {
        try {
            return serialize($value);
        } catch (\Throwable $t) {
            throw new InvalidArgumentException($t->getMessage(), 0, $t);
        }
    }

    private function throwIfTrue(bool $condition, string $message)
    {
        if ($condition) {
            throw new InvalidArgumentException($message);
        }
    }

    private function getErrorHandler() : callable
    {
        return function ($level, $message, $file, $line) {
            throw new InvalidArgumentException($message, $level);
        };
    }
}
