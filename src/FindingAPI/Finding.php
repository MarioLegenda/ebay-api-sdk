<?php

namespace FindingAPI;

use FindingAPI\Core\Event\AddProcessorEvent;
use SDKBuilder\AbstractSDK;
use FindingAPI\Core\Event\ItemFilterEvent;
use FindingAPI\Core\Response\ResponseInterface;
use FindingAPI\Core\Response\ResponseProxy;

use SDKBuilder\SDK\SDKInterface;
use FindingAPI\Core\Response\FakeGuzzleResponse;
use SDKOfflineMode\SDKOfflineMode;

use SDKBuilder\Request\AbstractRequest;
use FindingAPI\Core\Processor\Get\GetItemFiltersProcessor;

class Finding extends AbstractSDK
{
    /**
     * @var ResponseInterface $response
     */
    private $response;
    /**
     * @param string $inlineResponse
     * @return ResponseInterface
     */
    public function getResponse(string $inlineResponse = null) : ResponseInterface
    {
        if (is_string($inlineResponse)) {
            $response = new ResponseProxy(
                $inlineResponse,
                new FakeGuzzleResponse($inlineResponse),
                $this->getRequest()->getResponseFormat()
            );

            $this->response = $response;

            return $this->response;
        }

        if ($this->offlineModeSwitch === true) {
            if ($this->offlineMode instanceof SDKOfflineMode) {
                return $this->offlineMode->getResponse();
            }
        }

        if ($this->response instanceof ResponseInterface) {
            return $this->response;
        }

        $response = new ResponseProxy(
            $this->responseToParse,
            $this->guzzleResponse,
            $this->getRequest()->getResponseFormat()
        );

        unset($this->responseToParse);
        unset($this->guzzleResponse);

        $this->response = $response;

        return $this->response;
    }
}