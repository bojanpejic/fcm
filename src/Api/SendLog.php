<?php

declare(strict_types=1);

namespace Kerox\Fcm\Api;

use Kerox\Fcm\Model\Message;
use Kerox\Fcm\Request\SendRequest;
use Kerox\Fcm\Response\SendResponse;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;

/**
 * Class Send.
 */
class SendLog extends AbstractApi
{
    private $logger;

    public function __construct($oauthToken, $projectId, $client, $logger)
    {
        parent::__construct($oauthToken, $projectId, $client);

        $this->logger = $logger;
    }
    /**
     * @param \Kerox\Fcm\Model\Message $message
     * @param bool                     $validateOnly
     *
     * @return \Kerox\Fcm\Response\SendResponse
     */
    public function message(Message $message, bool $validateOnly = false): SendResponse
    {
        $uri = sprintf('%s/messages:send', $this->projectId);

        $request = new SendRequest($this->oauthToken, $message, $validateOnly);
        $build = $request->build();
        $this->logger->log('Request Payload: '.json_encode($build));
        try {
            $response = $this->client->post($uri, $build);
        } catch (RequestException $e) {
            $errorResponse = $e->getResponse();
            $response = new Response(
                $errorResponse->getStatusCode(), $errorResponse->getHeaders(), $errorResponse->getBody()
            );
        }

        return new SendResponse($response);
    }
}
