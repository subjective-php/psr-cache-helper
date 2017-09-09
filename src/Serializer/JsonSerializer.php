<?php

namespace Chadicus\Psr\SimpleCache\Serializer;

use \Chadicus\Psr\SimpleCache\InvalidArgumentException;

/**
 * Serializer implementation responsible for serializing and unserializing data to and from json.
 */
final class JsonSerializer implements SerializerInterface
{
    /**
     * @var boolean
     */
    private $decodeAsAssoc = true;

    /**
     * @var integer
     */
    private $encodeOptions = 0;

    /**
     * Construct a new JsonSerializer.
     *
     * @param boolean $decodeAsAssoc When TRUE, returned objects will be converted into associative arrays.
     * @param integer $encodeOptions Bitmask consisting of json endoding options.
     */
    public function __construct(bool $decodeAsAssoc = true, int $encodeOptions = 0)
    {
        $this->decodeAsAssoc = $decodeAsAssoc;
        $this->encodeOptions = $encodeOptions;
    }

    /**
     * Unserializes cached data into the original state.
     *
     * @param mixed $data The data to unserialize.
     *
     * @return mixed
     *
     * @throws \InvalidArgumentException Thrown if the given value cannot be unserialized.
     */
    public function unserialize($data)
    {
        try {
            return json_decode($data, $this->decodeAsAssoc);
        } finally {
            $this->ensureJson();
        }
    }//@codeCoverageIgnore

    /**
     * Serializes the given data for storage in caching.
     *
     * @param mixed $value The data to serialize for caching.
     *
     * @return mixed The result of serializing the given $data.
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException Thrown if the given value cannot be serialized for caching.
     */
    public function serialize($value)
    {
        try {
            return json_encode($value, $this->encodeOptions);
        } finally {
            $this->ensureJson();
        }
    }//@codeCoverageIgnore

    private function ensureJson()
    {
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException(json_last_error_msg());
        }
    }
}
