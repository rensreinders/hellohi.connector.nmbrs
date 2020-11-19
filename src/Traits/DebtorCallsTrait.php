<?php

declare(strict_types=1);

namespace Mijnkantoor\NMBRS\Traits;

use Mijnkantoor\NMBRS\Exceptions\NmbrsException;

trait DebtorCallsTrait
{
    public function getAllDebtors()
    {
        try {
            $response = $this->debtorClient->List_GetAll();

            return $this->wrapArray($response->List_GetAllResult->Debtor);
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }

    public function getDebtorById($id)
    {
        try {
            $response = $this->debtorClient->Debtor_Get(['DebtorId' => $id]);

            return $response->Debtor_GetResult ?? null;
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }

    public function getHighestDebtorNumber()
    {
        $highestNumber = 0;

        foreach($this->getAllDebtors() as $debtor) {
            if($debtor->Number > $highestNumber || $highestNumber == null) {
                $highestNumber = $debtor->Number;
            }
        }

        return $highestNumber;
    }

    public function createDebtor($name, $number) {
        $data = [
            'Name' => $name,
            'Id' => -1, // id -1 means auto increment remote
            'Number' => $number,
        ];

        try {
            $response = $this->debtorClient->Debtor_Insert(['Debtor' => $data]);

            return $response->Debtor_InsertResult ?? null;
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }

    public function updateDebtor($id, $newData) {

        // request needs to be full object, unset values will be emptied on update
        $current = $this->getDepbtorById($id);
        $data = array_merge((array)$current, $newData);

        try {
            $this->debtorClient->Debtor_Update(['Debtor' => $data]);
            // no return value here...
            return true;
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }

}