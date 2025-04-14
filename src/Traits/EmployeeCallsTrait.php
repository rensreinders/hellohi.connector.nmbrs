<?php

declare(strict_types=1);

namespace Mijnkantoor\NMBRS\Traits;

// use App\Traits\ActivityLog;
use Mijnkantoor\NMBRS\Exceptions\NmbrsException;

trait EmployeeCallsTrait
{
    // use ActivityLog;

    /**
     * Get functions for each employee in a given company
     * https://api.nmbrs.nl/soap/v3/EmployeeService.asmx?op=Function_GetAll_AllEmployeesByCompany_V2
     *
     * @param int $company_id
     *
     * @return array
     *
     * @throws NmbrsException
     */
    public function getFunctionAllEmployeesByCompany(int $company_id): array
    {
        try {
            $response = $this->employeeClient->Function_GetAll_AllEmployeesByCompany_V2(['CompanyID' => $company_id]);
            return $this->wrapArray($response->Function_GetAll_AllEmployeesByCompany_V2Result);
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }



    /**
     * Get functions for each employee in a given company
     *
     * https://api.nmbrs.nl/soap/v3/EmployeeService.asmx?op=List_GetByCompany
     *
     * @param int $company_id
     *
     * @return array
     *
     * @throws NmbrsException
     */
    public function getAllEmployeesByCompany(int $company_id, int $employeeType): array
    {
        try {
            $response = $this->employeeClient->List_GetByCompany(['CompanyID' => $company_id, 'EmployeeType' => $employeeType]);
            return $this->wrapArray($response->List_GetByCompanyResult);
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }

    /**
     * Get the Address for each employee in a given company
     * https://api.nmbrs.nl/soap/v3/EmployeeService.asmx?op=Address_GetAll_AllEmployeesByCompany
     *
     * @param $company_id
     *
     * @return array
     *
     * @throws NmbrsException
     */
    public function getAllAddressEmployeesByCompany(int $company_id): array
    {
        try {
            $response = $this->employeeClient->Address_GetAll_AllEmployeesByCompany(['CompanyID' => $company_id]);
            return $this->wrapArray($response->Address_GetAll_AllEmployeesByCompanyResult);
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }

    /**
     * Get the Address for each employee in a given company
     * https://api.nmbrs.nl/soap/v3/EmployeeService.asmx?op=Address_GetAll_AllEmployeesByCompany
     *
     * @param int $employeeId
     *
     * @return array
     *
     * @throws NmbrsException
     */
    public function getCurrentAddressByEmployee(int $employeeId): array
    {
        try {
            $response = $this->employeeClient->Address_GetListCurrent(['EmployeeId' => $employeeId]);
            return $this->wrapArray($response->Address_GetListCurrentResult);
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }

    /**
     * Get the SVW for each employee in a given company
     * https://api.nmbrs.nl/soap/v3/EmployeeService.asmx?op=SVW_GetCurrent
     *
     * @param int $employeeId
     *
     * @return array
     *
     * @throws NmbrsException
     */
    public function getCurrentSVWByEmployee(int $employeeId): array
    {
        try {
            $response = $this->employeeClient->SVW_GetCurrent(['EmployeeId' => $employeeId]);
            return $this->wrapArray($response->SVW_GetCurrentResult);
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }

    /**
     * Get the Address for each employee in a given company
     * https://api.nmbrs.nl/soap/v3/EmployeeService.asmx?op=Schedule_GetCurrent
     *
     * @param int $employeeId
     *
     * @return object
     *
     * @throws NmbrsException
     */
    public function getCurrentScheduleByEmployee(int $employeeId): object
    {
        try {
            $response = $this->employeeClient->Schedule_GetCurrent(['EmployeeId' => $employeeId]);
            return $response->Schedule_GetCurrentResult;
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }

    /**
     * Get the Address for each employee in a given company
     * https://api.nmbrs.nl/soap/v3/EmployeeService.asmx?op=Schedule_GetList
     *
     * @param int $employeeId
     * @param int $Period
     * @param int $Year
     *
     * @return array
     *
     * @throws NmbrsException
     */
    public function getScheduleListByEmployeePeriodYear(int $employeeId, int $Period, int $Year): array
    {
        try {
            $response = $this->employeeClient->Schedule_GetList(['EmployeeId' => $employeeId, 'Period' => $Period, 'Year' => $Year]);
            return $this->wrapArray($response->Schedule_GetListResult);
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }

    /**
     * Get the Address for each employee in a given company
     * https://api.nmbrs.nl/soap/v3/EmployeeService.asmx?op=WageComponentFixed_GetCurrent
     *
     * @param int $employeeId
     *
     * @return array
     *
     * @throws NmbrsException
     */
    public function getCurrentWageComponentFixedByEmployee(int $employeeId): array
    {
        try {
            $response = $this->employeeClient->WageComponentFixed_GetCurrent(['EmployeeId' => $employeeId]);
            return $this->wrapArray($response->WageComponentFixed_GetCurrentResult);
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }

    /**
     * Get the Address for each employee in a given company
     * https://api.nmbrs.nl/soap/v3/EmployeeService.asmx?op=WageComponentFixed_GetCurrent
     *
     * @param int $employeeId
     *
     * @return array
     *
     * @throws NmbrsException
     */
    public function getCurrentWageTaxByEmployee(int $employeeId): array
    {
        try {
            $response = $this->employeeClient->WageTax_GetList(['EmployeeId' => $employeeId]);
            return $this->wrapArray($response->WageTax_GetListResult);
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }

    /**
     * Get the Address for each employee in a given company
     * https://api.nmbrs.nl/soap/v3/EmployeeService.asmx?op=WageComponentVar_GetCurrent
     *
     * @param int $employeeId
     *
     * @return array
     *
     * @throws NmbrsException
     */
    public function getCurrentWageComponentVarByEmployee(int $employeeId): array
    {
        try {
            $response = $this->employeeClient->WageComponentVar_GetCurrent(['EmployeeId' => $employeeId]);
            return $this->wrapArray($response->WageComponentVar_GetCurrentResult);
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }


    /**
     * Get the Address for each employee in a given company
     * https://api.nmbrs.nl/soap/v3/EmployeeService.asmx?op=WageComponentVar_GetCurrent
     *
     * @param int $employeeId
     *
     * @return array
     *
     * @throws NmbrsException
     */
    public function getCurrentSalariesByEmployee(int $employeeId, int $year, int $period): array
    {
        try {
            $response = $this->employeeClient->Salary_GetList(['EmployeeId' => $employeeId, 'Year' => $year, 'Period' => $period]);
            return $this->wrapArray($response->Salary_GetListResult);
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }

    /**
     * Get the Address for each employee in a given company
     * https://api.nmbrs.nl/soap/v3/EmployeeService.asmx?op=Salary_GetCurrent
     *
     * @param int $employeeId
     *
     * @return array
     *
     * @throws NmbrsException
     */
    public function getCurrentSalaryByEmployee(int $employeeId): array
    {
        try {
            $response = $this->employeeClient->Salary_GetCurrent(['EmployeeId' => $employeeId]);
            return $this->wrapArray($response->Salary_GetCurrentResult);
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }

    /**
     * Get all absences (ziek, zwangerschap etc) for all employees in a given company
     * https://api.nmbrs.nl/soap/v3/EmployeeService.asmx?op=Absence_GetAll_AllEmployeesByCompany
     *
     * @param $company_id
     *
     * @return array
     *
     * @throws NmbrsException
     */
    public function getAllAbsenceEmployeesByCompany(int $company_id): array
    {
        try {
            $response = $this->employeeClient->Absence_GetAll_AllEmployeesByCompany(['CompanyId' => $company_id]);
            return $this->wrapArray($response->Absence_GetAll_AllEmployeesByCompanyResult);
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }

    /**
     * Get all personal info for all employees in a given company
     * https://api.nmbrs.nl/soap/v3/EmployeeService.asmx?op=PersonalInfo_GetAll_AllEmployeesByCompany
     * @param $company_id
     * @return array
     * @throws NmbrsException
     */
    public function getAllPersonalInfoEmployeesByCompany(int $company_id): array
    {
        try {
            $response = $this->employeeClient->PersonalInfo_GetAll_AllEmployeesByCompany(['CompanyID' => $company_id]);
            return $this->wrapArray($response->PersonalInfo_GetAll_AllEmployeesByCompanyResult);
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }

    /**
     * Get salary for all employees in a given company
     * https://api.nmbrs.nl/soap/v3/EmployeeService.asmx?op=Salary_GetAll_AllEmployeesByCompany
     *
     * @param int $company_id
     *
     * @return array
     * @throws NmbrsException
     */
    public function getAllSalaryEmployeesByCompany(int $company_id): array
    {
        try {
            $response = $this->employeeClient->Salary_GetAll_AllEmployeesByCompany(['CompanyID' => $company_id]);

            // if (is_object($response->Salary_GetAll_AllEmployeesByCompanyResult ?? null) && is_array($response->Salary_GetAll_AllEmployeesByCompanyResult->EmployeeSalaryItem ?? null)) {
            //     return $response->Salary_GetAll_AllEmployeesByCompanyResult->EmployeeSalaryItem;
            // }

            return $this->wrapArray($response->Salary_GetAll_AllEmployeesByCompanyResult->EmployeeSalaryItem ?? null);
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }

    /**
     * Get personal info + salary + contract + adres for all employees in a given company
     * https://api.nmbrs.nl/soap/v3/EmployeeService.asmx?op=PersonalInfoContractSalaryAddress_GetAll_AllEmployeesByCompany
     *
     * @param int $company_id
     *
     * @return array
     *
     * @throws NmbrsException
     */
    public function getAllPersonalInfoContractSalaryAddressEmployeesByCompany(int $company_id): array
    {
        try {
            $response = $this->employeeClient->PersonalInfoContractSalaryAddress_GetAll_AllEmployeesByCompany(['CompanyID' => $company_id]);

            if (property_exists($response->PersonalInfoContractSalaryAddress_GetAll_AllEmployeesByCompanyResult, 'PersonalInfoContractSalaryAddress')) {
                return $response->PersonalInfoContractSalaryAddress_GetAll_AllEmployeesByCompanyResult->PersonalInfoContractSalaryAddress;
            }

            return $this->wrapArray($response->PersonalInfoContractSalaryAddress_GetAll_AllEmployeesByCompanyResult);
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }

    /**
     * Get current active department by EmployeeID
     * https://api.nmbrs.nl/soap/v3/EmployeeService.asmx?op=Department_GetCurrent
     *
     * @param int $employee_id
     *
     * @return array
     *
     * @throws NmbrsException
     */
    public function getCurrentDepartmentByEmployee(int $employee_id): array
    {
        try {
            $response = $this->employeeClient->Department_GetCurrent(['EmployeeId' => $employee_id]);
            return $this->wrapArray($response->Department_GetCurrentResult);
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }

    /**
     * Get current active personal info by EmployeeID
     * https://api.nmbrs.nl/soap/v3/EmployeeService.asmx?op=PersonalInfo_GetCurrent
     *
     * @param int $employee_id
     *
     * @return object
     *
     * @throws NmbrsException
     */
    public function getCurrentPersonalInfoByEmployee(int $employee_id): object
    {
        try {
            $response = $this->employeeClient->PersonalInfo_GetCurrent(['EmployeeId' => $employee_id]);
            return $response->PersonalInfo_GetCurrentResult;
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }

    /**
     * Get active contracts for current period by EmployeeID
     * https://api.nmbrs.nl/soap/v3/EmployeeService.asmx?op=Contract_GetCurrentPeriod
     * @todo determine if this is the correct method. (could also be Contract_GetAll.)
     *
     * @param int $employee_id
     *
     * @return array
     *
     * @throws NmbrsException
     */
    public function getCurrentContractByEmployee(int $employee_id): array
    {
        try {
            $response = $this->employeeClient->Contract_GetCurrentPeriod(['EmployeeId' => $employee_id]);

            if (property_exists($response->EmployeeContractItem->EmployeeContracts, 'EmployeeContract')) {
                foreach ($response->EmployeeContractItem->EmployeeContracts->EmployeeContract as $key => $item) {
                    if (is_string($key)) {
                        return $this->wrapArray($response->EmployeeContractItem->EmployeeContracts);
                    } else {
                        return $this->wrapArray((object) ['EmployeeContract' => end($response->EmployeeContractItem->EmployeeContracts->EmployeeContract)]);
                    }
                }
            }
            return $this->wrapArray((object) ['EmployeeContract' => []]);
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }

    /**
     * Get All contracts for a given Employee
     * https://api.nmbrs.nl/soap/v3/EmployeeService.asmx?op=Contract_GetAll
     *
     * @param $employee_id
     *
     * @return array
     *
     * @throws NmbrsException
     */
    public function getAllContractsByEmployee(int $employee_id): array
    {
        try {
            $response = $this->employeeClient->Contract_GetAll(['EmployeeId' => $employee_id]);
            return $this->wrapArray($response->Contract_GetAllResult);
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }

    /**
     * Get All contracts for a given Employee
     * https://api.nmbrs.nl/soap/v3/EmployeeService.asmx?op=LeaveBalance_Get
     *
     * @param int $employee_id
     *
     * @return array
     *
     * @throws NmbrsException
     */
    public function getLeaveBalance(int $employee_id): array
    {
        try {
            $response = $this->employeeClient->LeaveBalance_Get(['EmployeeId' => $employee_id]);
            return $this->wrapArray($response->LeaveBalance_GetResult);
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }

    /**
     * Get current labour agreement settings for current period by EmployeeID
     * https://api.nmbrs.nl/soap/v3/EmployeeService.asmx?op=LabourAgreements_GetCurrent
     * @todo determine if this is the correct method. (could also be LabourAgreements_Get.)
     *
     * @param int $employee_id
     *
     * @return array
     *
     * @throws NmbrsException
     */
    public function getCurrentLabourAgreementsByEmployee(int $employee_id): array
    {
        try {
            $response = $this->employeeClient->LabourAgreements_GetCurrent(['EmployeeId' => $employee_id]);
            return $this->wrapArray($response->LabourAgreements_GetCurrentResult);
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }

    /**
     * Get all labour agreement settings for current period by EmployeeID
     * https://api.nmbrs.nl/soap/v3/EmployeeService.asmx?op=LabourAgreements_Get
     *
     * @param int $employee_id
     *
     * @return array
     *
     * @throws NmbrsException
     */
    public function getAllLabourAgreementsByEmployee(int $employee_id): array
    {
        try {
            $response = $this->employeeClient->LabourAgreements_Get(['EmployeeId' => $employee_id]);
            return $this->wrapArray($response->LabourAgreements_GetResult);
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }

    /**
     * Get all employee types
     * https://api.nmbrs.nl/soap/v3/EmployeeService.asmx?op=EmployeeType_GetList
     *
     * @return array
     *
     * @throws NmbrsException
     */
    public function getListOfEmployeeTypes(): array
    {
        try {
            $response = $this->employeeClient->EmployeeType_GetList();
            return $this->wrapArray($response->EmployeeType_GetListResult);
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }

    /**
     * NL-only. Insert a absence with cause, this item will start from the given date in the object.
     * https://api.nmbrs.nl/soap/v3/EmployeeService.asmx?op=Absence2_Insert
     * @todo determine if this is the correct method. (could also be Absence_insert.)
     *
     * @param object $medicalFile
     *
     * @return array
     *
     * @throws NmbrsException
     */
    public function setAbsenceByNewMedicalFile(object $medicalFile): array
    {

        $input = [
            'EmployeeId' => $medicalFile->employee->payroll_id,
            'NewDossier' => true,
            'Absence' => [
                'AbsenceId' => $medicalFile->id,
                // 'AbsenceId' => 123456789,
                'Comment' => $medicalFile->particularities ?? null,
                'Dossier' => $medicalFile->payrollVerzuimType,
                'Dossiernr' => $medicalFile->id,
                // 'Dossiernr' => 7654321,
                'End' => isset($medicalFile->closed_at) ? $this->displayDateTimeXsd($medicalFile->closed_at) :  null,
                'Percentage' => $medicalFile->sick_percentage ?? '',
                'RegistrationEndDate' => isset($medicalFile->closed_at) ? $this->displayDateTimeXsd($medicalFile->closed_at) :  null,
                'RegistrationStartDate' => $this->displayDateTimeXsd($medicalFile->started_at), // '2022-06-21T10:20:44.000000Z',
                'Start' => $this->displayDateTimeXsd($medicalFile->started_at), // '2022-06-21T10:20:44.000000Z',
            ],
        ];

        try {
            $response = $this->employeeClient->Absence_Insert($input);

            $medicalFile->update([
                'payroll_id' => $response->Absence_InsertResult
            ]);

            $return_array = [
                'status' => 'success',
                'message' => null,
                'title' => 'Verzuimmelding verstuurd naar NMBRS'
            ];
        } catch (\Exception $e) {
            $this->errorLog($e, 'Nmbrs', $medicalFile->employee, 'Fout bij versturen van verzuimmelding naar NMBRS', $input);

            $return_array = [
                'status' => 'failed',
                'message' => $e->getMessage(),
                'title' => 'Fout bij versturen van verzuimmelding naar NMBRS'
            ];
        }

        return $return_array;
    }

    /**
     * NL-only. Insert a absence with cause, this item will start from the given date in the object.
     * https://api.nmbrs.nl/soap/v3/EmployeeService.asmx?op=Absence2_Insert
     * @todo determine if this is the correct method. (could also be Absence_insert.)
     *
     * @param object $medicalFile
     *
     * @return array
     *
     * @throws NmbrsException
     */
    public function setAbsenceByReopenedMedicalFile(object $medicalFile): array
    {
        /**
         * info: NMBRS doesnt work with composed medicalFiles.
         * action: create a new one every time a medicalFiles reopens.
         */
        $dossiernr = $medicalFile->id . '00' . $medicalFile->getVerzuimFrequency();
        $reopened_at = $medicalFile->tasks()->where('type', 'open_medicalFile')->latest()->first()->start_date ?? $this->now();

        $input = [
            'EmployeeId' => $medicalFile->employee->payroll_id,
            // 'NewDossier' => $medicalFile->tasks()->where('type', 'open_medicalFile')->first() ? false : true,
            'NewDossier' => true,
            'Absence' => [
                // 'AbsenceId' => '',
                'AbsenceId' => (int) $dossiernr,
                'Comment' => $medicalFile->particularities ?? null,
                'Dossier' => $medicalFile->payrollVerzuimType,
                'Dossiernr' => (int) $dossiernr,
                // 'Dossiernr' => 7654321,
                'End' => isset($medicalFile->closed_at) ? $this->displayDateTimeXsd($medicalFile->closed_at) :  null,
                'Percentage' => $medicalFile->sick_percentage ?? '',
                'RegistrationEndDate' => isset($medicalFile->closed_at) ? $this->displayDateTimeXsd($medicalFile->closed_at) :  null,
                'RegistrationStartDate' => $this->displayDateTimeXsd($reopened_at), // '2022-06-21T10:20:44.000000Z',
                'Start' => $this->displayDateTimeXsd($reopened_at), // '2022-06-21T10:20:44.000000Z',
            ],
        ];

        try {
            $response = $this->employeeClient->Absence_Insert($input);

            $medicalFile->update([
                'payroll_id' => $response->Absence_InsertResult
            ]);

            $return_array = [
                'status' => 'success',
                'message' => null,
                'title' => 'Dossier heropend melding verstuurd naar NMBRS',
            ];
        } catch (\Exception $e) {
            $this->errorLog($e, 'Nmbrs', $medicalFile->employee, 'Fout bij versturen van dossier heropend melding naar NMBRS', $input);

            $return_array = [
                'status' => 'failed',
                'message' => $e->getMessage(),
                'title' => 'Fout bij versturen van dossier heropend melding naar NMBRS',
            ];
        }

        return $return_array;
    }

    /**
     * NL-only. Insert a absence recovery message.
     * https://api.nmbrs.nl/soap/v3/EmployeeService.asmx?op=Absence_RecoveryInsert
     * @todo determine if this is the correct method. (could also be Absence_insert.)
     *
     * @param object $medicalFile
     *
     * @return array
     *
     * @throws NmbrsException
     */
    public function recoverAbsenceByMedicalFile(object $medicalFile): array
    {
        $input = [
            'AbsenceID' => $medicalFile->payroll_id,
            'Comment' => $medicalFile->tasks()->where('name', 'Betermelding')->latest()->first()->description ?? null,
            'EmployeeId' => $medicalFile->employee->payroll_id,
            'Lastdayabsence' => $this->displayDateTimeXsd($medicalFile->closed_at),
            'Reportdate' => $this->displayDateTimeXsd($medicalFile->closed_at),
        ];

        try {
            $this->employeeClient->Absence_RecoveryInsert($input);

            $return_array = [
                'status' => 'success',
                'message' => null,
                'title' => 'Betermelding verstuurd naar NMBRS',
            ];
        } catch (\Exception $e) {
            $this->errorLog($e, 'Nmbrs', $medicalFile->employee, 'Fout bij versturen van betermelding naar NMBRS', $input);

            $return_array = [
                'status' => 'failed',
                'message' => $e->getMessage(),
                'title' => 'Fout bij versturen van betermelding naar NMBRS',
            ];
        }

        return $return_array;
    }

    /**
     * NL-only. Insert a absence partial recovery message.
     * https://api.nmbrs.nl/soap/v3/EmployeeService.asmx?op=Absence2_Insert
     * @todo determine if this is the correct method. (could also be Absence_insert.)
     *
     * @param object $medicalFile
     *
     * @return array
     *
     * @throws NmbrsException
     */
    public function partialRecoverAbsenceByMedicalFile(object $medicalFile): array
    {
        $input = [
            'AbsenceID' => $medicalFile->payroll_id,
            'Comment' => null,
            'EmployeeId' => $medicalFile->employee->payroll_id,
            'Percent' => $medicalFile->sick_percentage,
            'Reportdate' => $this->displayDateTimeXsd($medicalFile->latest_course_absence_percentage['start']),
            'StartDate' => $this->displayDateTimeXsd($medicalFile->latest_course_absence_percentage['start']),
        ];

        try {
            $response = $this->employeeClient->Absence_PartialRecoveryInsert($input);

            $medicalFile->payroll_id = $response->Absence_PartialRecoveryInsertResult;
            $medicalFile->saveQuietly();

            $return_array = [
                'status' => 'success',
                'message' => null,
                'title' => 'Bijstelling dossier verstuurd naar NMBRS',
            ];
        } catch (\Exception $e) {
            $this->errorLog($e, 'Nmbrs', $medicalFile->employee, 'Fout bij versturen van bijstelling dossier naar NMBRS', $input);

            $return_array = [
                'status' => 'failed',
                'message' => $e->getMessage(),
                'title' => 'Fout bij versturen van bijstelling dossier naar NMBRS',
            ];
        }

        return $return_array;
    }

    /**
     * Contract_GetAll_AllEmployeesByCompany
     *
     * @param int $company_id
     *
     * @return object
     */
    public function getAllContractsByCompany(int $company_id): object
    {
        try {
            $result = $this->employeeClient->Contract_GetAll_AllEmployeesByCompany(['CompanyID' => $company_id]);
            return $result->Contract_GetAll_AllEmployeesByCompanyResult;
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }

    /**
     * Employment_GetAll_AllEmployeesByCompany
     * https://api.nmbrs.nl/soap/v3/EmployeeService.asmx?op=Employment_GetAll_AllEmployeesByCompany
     *
     * @param int $company_id
     *
     * @return object[]
     */
    public function getAllEmploymentsByCompany(int $company_id): array
    {
        try {
            $result = $this->employeeClient->Employment_GetAll_AllEmployeesByCompany(['CompanyID' => $company_id]);
            return $this->wrapArray($result->Employment_GetAll_AllEmployeesByCompanyResult->EmployeeEmploymentItem ?? null);
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }

    /**
     * Get employments for one employee
     * @info: uses same call as getAllEmploymentsByCompany, but added some code to get employee specific
     *
     * @param int $company_id
     * @param int $employee_id
     *
     * @return object|null
     */
    public function getAllEmploymentsByCompanyAndEmployee(int $company_id, int $employee_id): ?object
    {
        try {
            $employments = $this->getAllEmploymentsByCompany($company_id);

            foreach ($employments as $employment) {
                if ($employee_id == $employment->EmployeeId) {
                    return $employment->EmployeeEmployments;
                }
            }
            return null;
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }

    /**
     * Get latest employment for one employee
     * @info: uses same call as getAllEmploymentsByCompany, but added some code to get employee specific
     */
    public function getlatestEmploymentByCompanyAndEmployee($company_id, $employee_id)
    {
        try {
            $employments = $this->getAllEmploymentsByCompany($company_id);

            # multiple employments
            foreach ($employments as $employment) {
                if ($employee_id == $employment->EmployeeId) {

                    if (is_array($employment->EmployeeEmployments->Employment)) {
                        $data = [];
                        $data['Employment'] = $employment->EmployeeEmployments->Employment[0];
                        return $data;
                    }

                    return $employment->EmployeeEmployments;
                }
            }
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }

    /**
     * Get list of absence types by employee
     *
     */
    public function getAbsenceList($employee_id)
    {
        try {
            $result = $this->employeeClient->Absence_GetList(['EmployeeId' => $employee_id]);

            return $result;
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }

    /**
     * Get list of wage tax settings by employee
     *
     */
    public function getWageTaxSettingsByEmployee($employee_id)
    {
        try {
            $result = $this->employeeClient->WageTax_Get([
                'EmployeeId' => $employee_id,
                'Period' => 1,
                'Year' => $this->now()->format('Y'),
            ]);

            return $this->wrapArray($result->WageTax_GetResult);
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }

    /**
     * Get current function by employee
     *
     * @param int $employee_id
     *
     * @param object
     */
    public function getCurrentFunctionByEmployee(int $employee_id): object
    {
        try {
            $result = $this->employeeClient->Function_GetCurrent(['EmployeeId' => $employee_id]);

            return $result->Function_GetCurrentResult;
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }

    private function displayDateTimeXsd(string $date): ?string
    {
        if (function_exists('displayDateTimeXsd')) {
            return displayDateTimeXsd($date);
        }
        $dateTimeObject = \DateTime::createFromFormat('Y-m-d|', $date);
        if (false !== $dateTimeObject) {
            return $dateTimeObject->format(\DateTime::ATOM);
        }
        return null;
    }

    private function now(): \DateTime
    {
        if (function_exists('now')) {
            return now();
        }
        return new \DateTime();
    }
}
