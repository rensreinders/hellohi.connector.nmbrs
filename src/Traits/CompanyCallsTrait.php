<?php

declare(strict_types=1);

namespace Mijnkantoor\NMBRS\Traits;

use Mijnkantoor\NMBRS\Exceptions\NmbrsException;

trait CompanyCallsTrait
{
    protected $companyCache = [];
    
    public function getAllCompaniesByDebtorId($id)
    {
        try {
            $response = $this->companyClient->List_GetByDebtor(['DebtorId' => $id]);
            
            return $this->wrapArray($response->List_GetByDebtorResult->Company ?? null);
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }
    
    public function getCurrentAddressByCompanyId($id)
    {
        try {
            $response = $this->companyClient->Address_GetCurrent(['CompanyId' => $id]);
            
            return $response->Address_GetCurrentResult ?? null;
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }
    
    public function getFirstCompanyByDeb6torId($id)
    {
        return $this->getAllCompaniesByDebtorId($id)[0] ?? null;
    }
    
    public function getAllWageTaxByYear($companyId, $year)
    {
        try {
            $response = $this->companyClient->WageTax_GetList([
                'CompanyId' => $companyId,
                'intYear' => $year,
            ]);
            
            return $this->wrapArray($response->WageTax_GetListResult->WageTax ?? null);
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }
    
    public function getAllRunsByYear($companyId, $year)
    {
        try {
            $response = $this->companyClient->Run_GetList([
                'CompanyId' => $companyId,
                'Year' => $year,
            ]);
            
            return $this->wrapArray($response->Run_GetListResult->RunInfo ?? null);
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }
    
    public function getPayslipsPdf($companyId, $year, $runId)
    {
        try {
            $response = $this->companyClient->SalaryDocuments_GetAllPayslipsPDFByRunCompany_v2([
                'CompanyId' => $companyId,
                'intYear' => $year,
                'RunID' => $runId
            ]);
            
            return $response->SalaryDocuments_GetAllPayslipsPDFByRunCompany_v2Result->PDF ?? null;
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }
    
    public function getWageTaxXml($companyId, $wageDeclarationId)
    {
        try {
            $response = $this->companyClient->WageTax_GetXML([
                'CompanyId' => $companyId,
                'LoonaangifteID' => $wageDeclarationId,
            ]);
            
            return $response->WageTax_GetXMLResult ?? null;
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }
    
    
    public function setWageTaxSendExternal($companyId, $wageDeclarationId)
    {
        try {
            $response = $this->companyClient->WageTax_SetSentExternal([
                'CompanyId' => $companyId,
                'LoonaangifteID' => $wageDeclarationId,
            ]);
            
            return $response->WageTax_SetSentExternalResult ?? null;
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }
    
    public function getHighestCompanyNumber()
    {
        $highestNumber = 0;
        
        foreach($this->getAllCompanies() as $company) {
            if($company->Number > $highestNumber || $highestNumber == null) {
                $highestNumber = $company->Number;
            }
        }
        
        return $highestNumber;
    }
    
    public function getAllCompanies()
    {
        if(count($this->companyCache) > 0) {
            return $this->companyCache;
        }
        
        try {
            $response = $this->companyClient->List_GetAll();
            $response = $this->wrapArray($response->List_GetAllResult->Company ?? null);
            
            $this->companyCache = $response;
            
            return $response;
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }
    
    public function getCompanyById($id)
    {
        foreach($this->getAllCompanies() as $company) {
            if($company->ID == $id) {
                return $company;
            }
        }
        
        return null;
    }
    
    public function createCompanyForDeptor($deptorId, $data)
    {
        $data['DebtorId'] = $deptorId;
        
        try {
            $response = $this->companyClient->Company_Insert($data);
            $response = $response->Company_InsertResult ?? null;
            
            return $response;
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }
    
    public function createAddressForCompany($companyId, $newData = [])
    {
        $data['Address'] = $newData;
        $data['Address']['Id'] = 0; // auto increment on this call
        $data['CompanyId'] = $companyId;
        
        try {
            $response = $this->companyClient->Address_Insert($data);
            
            return $response->Address_InsertResult ?? null;
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }
    
    public function updateAddressForCompany($companyId, $addressId, $newData = [])
    {
        $data['Address'] = $newData;
        $data['Address']['Id'] = $addressId;
        $data['CompanyId'] = $companyId;
        
        try {
            $this->companyClient->Address_Update($data);
            // no return value here...
            return true;
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }
    
    public function createBankAccountForCompany($companyId, $newData = [])
    {
        $data['BankAccount'] = $newData;
        $data['BankAccount']['Id'] = 0; // auto increment on this call
        $data['CompanyId'] = $companyId;
        
        try {
            $response = $this->companyClient->BankAccount_Insert($data);
            
            return $response->BankAccount_InsertResult ?? null;
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }
    
    public function updateBankAccountForCompany($companyId, $bankAccountId, $newData = []) {
        
        $data['BankAccount'] = $newData;
        $data['BankAccount']['Id'] = $bankAccountId;
        $data['CompanyId'] = $companyId;
        
        try {
            $this->companyClient->BankAccount_Update($data);
            // no return value here...
            return true;
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }
    
    public function getDefaultBankAccountForCompany($companyId) {
        try {
            $result = $this->companyClient->BankAccount_GetCurrent(['CompanyId' => $companyId]);
            
            return isset($result->BankAccount_GetCurrentResult->Id) && $result->BankAccount_GetCurrentResult->Id
                ? $result->BankAccount_GetCurrentResult : null;
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }
    
    public function getSEPA($companyId, $year, $runId, $paymentDate)
    {
        try {
            $response = $this->companyClient->SalaryDocuments_GetSEPA([
                'CompanyId' => $companyId,
                'Year' => $year,
                'RunID' => $runId,
                'paymentDate' => $paymentDate
            ]);
            
            return $response->SalaryDocuments_GetSEPAResult ?? null;
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }
    
    /**
     * Journaal posten
     *https://api.nmbrs.nl/soap/v3/CompanyService.asmx?op=SalaryDocuments_AnnualDocument_JournalEntriesCompanyrCumulative
     */
    public function getAnnualSalaryDocuments($companyId, $year, $runId)
    {
        try {
            $response = $this->companyClient->SalaryDocuments_AnnualDocument_JournalEntriesCompanyrCumulative([
                'CompanyId' => $companyId,
                'Year' => $year,
                'RunId' => $runId
            ]);
            
            return $response->SalaryDocuments_AnnualDocument_JournalEntriesCompanyrCumulativeResult ?? null;
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }
    
    /**
     * Ingediende loonaangiften
     * https://api.nmbrs.nl/soap/v3/CompanyService.asmx?op=SalaryDocuments_AnnualDocument_WageTaxDeclarationOverviewByPeriod
     */
    public function getAnnualWageTaxDocuments($companyId, $year, $runId)
    {
        try {
            $response = $this->companyClient->SalaryDocuments_AnnualDocument_WageTaxDeclarationOverviewByPeriod([
                'CompanyId' => $companyId,
                'Year' => $year,
                'RunId' => $runId
            ]);
            
            return $response->SalaryDocuments_AnnualDocument_WageTaxDeclarationOverviewByPeriodResult ?? null;
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }
    
    /**
     *  Ingediende loonaangiften
     * https://api.nmbrs.nl/soap/v3/CompanyService.asmx?op=SalaryDocuments_AnnualDocument_SentWageTaxDeclarations
     */
    public function getAnnualSentWageTaxDocuments($companyId, $year, $runId)
    {
        try {
            $response = $this->companyClient->SalaryDocuments_AnnualDocument_SentWageTaxDeclarations([
                'CompanyId' => $companyId,
                'Year' => $year,
                'RunId' => $runId
            ]);
            
            return $response->SalaryDocuments_AnnualDocument_SentWageTaxDeclarationsResult ?? null;
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }
    
    /**
     * Verzamelloonstaat cumulatief
     * https://api.nmbrs.nl/soap/v3/CompanyService.asmx?op=SalaryDocuments_AnnualDocument_PaymentListCumulative
     */
    public function getAnnualPaymentList($companyId, $year, $runId)
    {
        try {
            $response = $this->companyClient->SalaryDocuments_AnnualDocument_PaymentListCumulative([
                'CompanyId' => $companyId,
                'Year' => $year,
                'RunId' => $runId
            ]);
            
            return $response->SalaryDocuments_AnnualDocument_PaymentListCumulativeResult ?? null;
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }
    
    /**
     * Reservering saldo
     * https://api.nmbrs.nl/soap/v3/CompanyService.asmx?op=SalaryDocuments_AnnualDocument_ReservationSaldos
     */
    public function getAnnualReservationsSaldoDocuments($companyId, $year, $runId)
    {
        try {
            $response = $this->companyClient->SalaryDocuments_AnnualDocument_ReservationSaldos([
                'CompanyId' => $companyId,
                'Year' => $year,
                'RunId' => $runId
            ]);
            
            return $response->SalaryDocuments_AnnualDocument_ReservationSaldosResult ?? null;
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }
}
