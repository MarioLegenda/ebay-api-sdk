<?php

namespace FindingAPI\Core;

use FindingAPI\Core\Exception\RequestException;
use FindingAPI\Definition\Type\DefinitionTypeInterface;
use FindingAPI\Processor\ProcessorFactory;
use GuzzleHttp\Client;
use Symfony\Component\Yaml\Yaml;

class Request
{
    /**
     * @var RequestParameters $parameters
     */
    private $parameters;
    /**
     * @var bool $configLoaded
     */
    private static $configLoaded = false;

    /**
     * Request constructor.
     * @param array|null $parameters
     */
    public function __construct()
    {
        if (self::$configLoaded === false) {
            $config = Yaml::parse(file_get_contents(__DIR__.'/config.yml'))['finding'];
            $this->parameters = new RequestParameters($config['parameters'], $config['possible']);
        }
    }

    /**
     * @param string $url
     * @return Request
     * @throws RequestException
     */
    public function setEbayUrl(string $url) : Request
    {
        $this->parameters->setParameter('ebay_url', $url);

        return $this;
    }

    /**
     * @param string $serviceVersion
     * @return Request
     * @throws Exception\RequestException
     */
    public function setServiceVersion(string $serviceVersion) : Request
    {
        $this->parameters->setParameter('SERVICE-VERSION', $serviceVersion);

        return $this;
    }

    /**
     * @param string $method
     * @return Request
     * @throws RequestException
     */
    public function setMethod(string $method) : Request
    {
        if (RequestParameters::REQUEST_METHOD_GET !== $method and RequestParameters::REQUEST_METHOD_POST !== $method) {
            throw new RequestException('Unknown request method ' . $method . '. Only GET and POST are allowed');
        }

        $this->parameters->setParameter('method', strtolower($method));

        return $this;
    }

    /**
     * @param string $operationName
     * @return Request
     * @throws RequestException
     */
    public function setOperationName(string $operationName) : Request
    {
        $this->parameters->setParameter('OPERATION-NAME', $operationName);

        return $this;
    }

    /**
     * @param string $format
     * @return Request
     * @throws RequestException
     */
    public function setResponseDataFormat(string $format) : Request
    {
        $allowedFormat = array('xml', 'json');
        $format = strtolower($format);

        if (RequestParameters::RESPONSE_DATA_FORMAT_XML !== $format and RequestParameters::RESPONSE_DATA_FORMAT_JSON !== $format) {
            throw new RequestException('Response format can only be ' . implode(', ', $allowedFormat));
        }

        $this->parameters->setParameter('RESPONSE-DATA-FORMAT', $format);

        return $this;
    }

    /**
     * @param string $securityId
     * @return Request
     * @throws RequestException
     */
    public function setSecurityAppId(string $securityId) : Request
    {
        $this->parameters->setParameter('SECURITY-APPNAME', $securityId);

        return $this;
    }

    /**
     * @return bool
     */
    public function isRequestValid() : bool
    {
        return $this->parameters->valid();
    }

    /**
     * @return RequestParameters
     */
    public function getParameters() : RequestParameters
    {
        return $this->parameters;
    }

    /**
     * @param string $definitionType
     */
    public function sendRequest(string $request)
    {
        $client = new Client();

        $response = $client->request($this->getParameters()->getParameter('method')->getValue(), $request);

        var_dump((string) $response->getBody());
    }
}