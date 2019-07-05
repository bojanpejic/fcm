<?php

declare(strict_types=1);

namespace Kerox\Fcm\Model\Message;

use Kerox\Fcm\Helper\ValidatorTrait;
use Kerox\Fcm\Model\Message\Notification\ApnsNotification;

class Apns implements \JsonSerializable
{
    use ValidatorTrait;

    /**
     * @var array
     */
    protected $headers = [];

    /**
     * @var null|\Kerox\Fcm\Model\Message\Notification\ApnsNotification
     */
    protected $payload;

    /**
     * @var array
     */
    protected $fcmOptions = [];

    /**
     * @param array $headers
     *
     * @return \Kerox\Fcm\Model\Message\Apns
     */
    public function setHeaders(array $headers): self
    {
        $this->isValidData($headers);

        $this->headers = $headers;

        return $this;
    }

    /**
     * @param \Kerox\Fcm\Model\Message\Notification\ApnsNotification $payload
     *
     * @return \Kerox\Fcm\Model\Message\Apns
     */
    public function setPayload(ApnsNotification $payload): self
    {
        $this->payload = $payload;

        return $this;
    }

    public function setFcmOptions(array $fcmOptions): self
    {
        $this->isValidData($fcmOptions);

        $this->fcmOptions = $fcmOptions;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $array = [
            'headers' => $this->headers,
            'payload' => $this->payload,
        ];

        if (! empty($this->fcmOptions)) {
            $array['fcm_options'] = $this->fcmOptions;
        }

        return array_filter($array);
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
