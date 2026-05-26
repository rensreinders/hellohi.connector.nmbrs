<?php

declare(strict_types=1);

namespace Mijnkantoor\NMBRS;

use SoapClient;

class LoggingSoapClient extends SoapClient
{
    /** @var callable */
    private $logger;

    private string $serviceName;

    /**
     * @param string $wsdl
     * @param array $options
     * @param callable $logger  function(string $direction, string $service, string $action, string $xml): void
     * @param string $serviceName
     */
    public function __construct(string $wsdl, array $options, callable $logger, string $serviceName)
    {
        parent::__construct($wsdl, $options);
        $this->logger = $logger;
        $this->serviceName = $serviceName;
    }

    /**
     * @param string $request
     * @param string $location
     * @param string $action
     * @param int $version
     * @param bool $oneWay
     *
     * @return string
     */
    public function __doRequest(string $request, string $location, string $action, int $version, bool $oneWay = false): string
    {
        ($this->logger)('request', $this->serviceName, $action, $this->formatXml($request));

        $response = parent::__doRequest($request, $location, $action, $version, $oneWay);

        ($this->logger)('response', $this->serviceName, $action, $this->formatXml((string)$response));

        return $response;
    }

    private function formatXml(string $xml): string
    {
        if (empty($xml)) {
            return '';
        }

        $dom = new \DOMDocument('1.0');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;

        if (@$dom->loadXML($xml)) {
            return (string)$dom->saveXML();
        }

        return $xml;
    }
}
