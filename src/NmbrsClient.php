<?php

declare(strict_types=1);

namespace Mijnkantoor\NMBRS;

use Mijnkantoor\NMBRS\Traits\CompanyCallsTrait;
use Mijnkantoor\NMBRS\Traits\DebtorCallsTrait;
use Mijnkantoor\NMBRS\Traits\EmployeeCallsTrait;
use Mijnkantoor\NMBRS\Traits\ReportCallsTrait;
use SoapClient;
use SoapHeader;

class NmbrsClient
{
    const DEBTOR_SERVICE = 'DebtorService';
    const COMPANY_SERVICE = 'CompanyService';
    const EMPLOYEE_SERVICE = 'EmployeeService';
    const REPORT_SERVICE = 'ReportService';

    const DeclarationPeriodMonth = '1';
    const DeclarationPeriodFourWeek = '2';
    const DeclarationPeriodWeek = '3';

    protected SoapClient $debtorClient;
    protected SoapClient $companyClient;
    protected SoapClient $employeeClient;
    protected SoapClient $reportClient;

    /**
     * @var false
     */
    private $sandbox;

    /** @var callable|null */
    private $logger = null;

    use CompanyCallsTrait;
    use DebtorCallsTrait;
    use EmployeeCallsTrait;
    use ReportCallsTrait;

    /**
     * __construct
     *
     * @param string $username
     * @param string $password
     * @param string $domain
     * @param bool $sandbox
     * @param callable|null $logger  function(string $direction, string $service, string $action, string $xml): void
     */
    public function __construct(string $username, string $password, string $domain, bool $sandbox = false, ?callable $logger = null)
    {
        $this->sandbox = $sandbox;
        $this->logger = $logger;

        $this->debtorClient = $this->getClientForService(self::DEBTOR_SERVICE, $username, $password, $domain);
        $this->companyClient = $this->getClientForService(self::COMPANY_SERVICE, $username, $password, $domain);
        $this->employeeClient = $this->getClientForService(self::EMPLOYEE_SERVICE, $username, $password, $domain);
        $this->reportClient = $this->getClientForService(self::REPORT_SERVICE, $username, $password, $domain);
    }

    /**
     * setLogger
     *
     * @param callable $logger  function(string $direction, string $service, string $action, string $xml): void
     *
     * @return void
     */
    public function setLogger(callable $logger): void
    {
        $this->logger = $logger;
    }

    /**
     * getBaseUrl
     *
     * @return string
     */
    protected function getBaseUrl(): string
    {
        if ($this->sandbox) {
            $url = "https://api-sandbox.nmbrs.nl/soap/v3/";
        } else {
            $url = "https://api.nmbrs.nl/soap/v3/";
        }
        return $url;
    }

    /**
     * getClientForService
     *
     * @param string $service
     * @param string $username
     * @param string $password
     * @param string $domain
     *
     * @return SoapClient
     */
    protected function getClientForService(string $service, string $username, string $password, string $domain): SoapClient
    {
        $ns = $this->getBaseUrl() . $service;
        $options = ['trace' => 1];

        if (!is_null($this->logger)) {
            $client = new LoggingSoapClient($ns . '.asmx?WSDL', $options, $this->logger, $service);
        } else {
            $client = new SoapClient($ns . '.asmx?WSDL', $options);
        }

        $authHeader = new SoapHeader($ns, "AuthHeaderWithDomain", [
            'Username' => $username,
            'Token' => $password,
            'Domain' => $domain,
        ]);
        $client->__setSoapheaders([$authHeader]);

        return $client;
    }

    /**
     * wrapArray
     *
     * @param mixed $data
     *
     * @return array
     */
    private function wrapArray(mixed $data): array
    {
        if ($data == null) {
            return [];
        }

        if (is_array($data)) { // array of objects
            return $data;
        }

        return [$data];
    }
}
