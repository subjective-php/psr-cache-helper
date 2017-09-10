<?php

namespace Chadicus\Psr\SimpleCache;

/**
 * Trait for validating PSR-16 simple cache keys.
 */
trait KeyValidatorTrait
{
    /**
     * Verifies the given cache key is a legal value.
     *
     * @param mixed $key The cache key to validate.
     *
     * @return void
     *
     * @throws InvalidArgumentException Thrown if the $key string is not a legal value.
     */
    protected function validateKey($key)
    {
        if (!is_string($key) || $key === '') {
            throw new InvalidArgumentException('$key must be a valid non empty string');
        }

        if (preg_match('#[{}()/\\\@:]#', $key) > 0) {
            throw new InvalidArgumentException("Key '{$key}' contains unsupported characters");
        }
    }

    /**
     * Verifies all of the given cache keys are a legal values.
     *
     * @param array $keys The collection cache key to validate.
     *
     * @return void
     *
     * @throws InvalidArgumentException Thrown if the $key string is not a legal value.
     */
    protected function validateKeys(array $keys)
    {
        array_walk($keys, [$this, 'validateKey']);
    }
}
