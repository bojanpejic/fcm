<?php

declare(strict_types=1);

namespace Kerox\Fcm\Helper;

use InvalidArgumentException;

trait ValidatorTrait
{
    /**
     * @param array $data
     *
     * @throws \InvalidArgumentException
     */
    public function isValidData(array $data): void
    {
        foreach ($data as $key => $value) {
            if (!\is_string($key) || !\is_string($value)) {
                throw new InvalidArgumentException('Array must only contain string for key and value.');
            }
        }
    }

    /**
     * @param string $ttl
     *
     * @throws \InvalidArgumentException
     */
    public function isValidTtl(string $ttl): void
    {
        if (!preg_match('/^\d+(\.\d{1,9})?s$/', $ttl)) {
            throw new InvalidArgumentException('Invalid TTL format.');
        }
    }

    /**
     * @param string $lang
     *
     * @throws \InvalidArgumentException
     */
    public function isValidLang(string $lang): void
    {
        if (!preg_match('/^[a-z]{2}-[A-Z]{2}$/', $lang)) {
            throw new InvalidArgumentException('Invalid lang format.');
        }
    }

    /**
     * @param array $vibratePattern
     *
     * @throws \InvalidArgumentException
     */
    public function isValidVibratePattern(array $vibratePattern): void
    {
        foreach ($vibratePattern as $pattern) {
            if (!\is_int($pattern)) {
                throw new InvalidArgumentException('Vibrate pattern must only contain integer.');
            }
        }
    }

    /**
     * @param string $url
     *
     * @throws \InvalidArgumentException
     */
    protected function isValidUrl(string $url): void
    {
        if (!preg_match(
            '/^https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&\/=]*)$/',
            $url
        )) {
            throw new InvalidArgumentException(sprintf('%s is not a valid url.', $url));
        }
    }

    /**
     * @param string $topic
     *
     * @throws \InvalidArgumentException
     */
    public function isValidTopicName(string $topic): void
    {
        if (!preg_match('/^[a-zA-Z0-9-_.~%]+$/', $topic)) {
            throw new InvalidArgumentException(sprintf('%s is an invalid topic name.', $topic));
        }
    }

    /**
     * @param string $json
     *
     * @throws \InvalidArgumentException
     */
    public function isValidJson(string $json): void
    {
        json_decode($json);
        if (json_last_error() != JSON_ERROR_NONE) {
            throw new InvalidArgumentException(sprintf('%s is not a valid JSON string.', $json));
        }
    }
}
