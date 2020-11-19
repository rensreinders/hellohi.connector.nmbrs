<?php

declare(strict_types=1);

namespace Mijnkantoor\NMBRS;

use Mijnkantoor\NMBRS\Traits\CompanyCallsTrait;
use Mijnkantoor\NMBRS\Traits\DebtorCallsTrait;
use SoapClient;
use SoapHeader;

class NmbrsClient
{
    const DEBTOR_SERVICE = 'DebtorService';
    const COMPANY_SERVICE = 'CompanyService';

    const DeclarationPeriodMonth = '1';
    const DeclarationPeriodFourWeek = '2';
    const DeclarationPeriodWeek = '3';

    protected $debtorClient = null;

    use CompanyCallsTrait;
    use DebtorCallsTrait;

    public function __construct($username, $password, $domain)
    {
        $this->debtorClient = $this->getClientForService(self::DEBTOR_SERVICE, $username, $password, $domain);
        $this->companyClient = $this->getClientForService(self::COMPANY_SERVICE, $username, $password, $domain);
    }

    protected function getClientForService($service, $username, $password, $domain)
    {
        $ns = "https://api.nmbrs.nl/soap/v3/".$service;

        $client = new SoapClient($ns.".asmx?WSDL", ['trace' => 1]);

        $authHeader = new SoapHeader($ns, "AuthHeaderWithDomain", [
            'Username' => $username,
            'Token' => $password,
            'Domain' => $domain,
        ]);
        $client->__setSoapheaders([ $authHeader ]);

        return $client;
    }

    private function wrapArray($data)
    {
        if(isset($data->ID)) { // object
            return [$data];
        } elseif(is_array($data)) { // array of objects
            return $data;
        }

        return [];
    }
}