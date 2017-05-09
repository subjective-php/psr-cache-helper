<?php

namespace Chadicus\Psr\SimpleCache;

/**
 * Trait for validating PSR-16 simple cache expiress.
 */
trait TTLValidatorTrait
{
    /**
     * Verifies the the given cache expires is a legal value.
     *
     * @param mixed $ttl The cache ttl value to validate.
     *
     * @return void
     *
     * @throws InvalidArgumentException Thrown if $ttl is not null, integer or a \DateInterval instance
     */
    protected function validateTTL($ttl)
    {
        if ($ttl === null) {
            return;
        }

        if ($ttl instanceof \DateInterval) {
            return;
        }

        if (is_int($ttl)) {
            return;
        }

        throw new InvalidArgumentException('$ttl must be null, an integer or \DateInterval instance');
    }
}
