<?php

declare(strict_types=1);

namespace Mijnkantoor\NMBRS\Traits;

use Mijnkantoor\NMBRS\Exceptions\NmbrsException;

trait ReportCallsTrait
{

    /**
     * getWageCodesByRunCompany
     * https://api.nmbrs.nl/soap/v3/ReportService.asmx?op=Reports_GetWageCodesByRunCompany_FilterByWageCode_Background
     *
     * @return null|string
     *
     * @throws NmbrsException
     */
    public function getWageCodesByRunCompanyFilterByWageCode(int $company_id, int $run_id, int $year, int $wageCode): ?string
    {
        try {
            $response = $this->reportClient->Reports_GetWageCodesByRunCompany_FilterByWageCode_Background(['companyId' => $company_id, 'runId' => $run_id, 'year' => $year, 'wageCode' => $wageCode]);

            return $response->Reports_GetWageCodesByRunCompany_FilterByWageCode_BackgroundResult ?? null;
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }

    /**
     * getWageCodesByRunCompany
     * https://api.nmbrs.nl/soap/v3/ReportService.asmx?op=Reports_GetWageCodesByRunCompany_Background
     *
     * @return string
     *
     * @throws NmbrsException
     */
    public function getWageCodesByRunCompany(int $company_id, int $run_id, int $year): ?string
    {
        try {
            $response = $this->reportClient->Reports_GetWageCodesByRunCompany_v2_Background(['companyId' => $company_id, 'runId' => $run_id, 'year' => $year]);

            return $response->Reports_GetWageCodesByRunCompany_v2_BackgroundResult ?? null;
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }

    /**
     * https://api.nmbrs.nl/soap/v3/ReportService.asmx?op=Reports_BackgroundTask_Result
     *
     * @param string $taskId
     *
     * @return null|object
     *
     * @throws NmbrsException
     */
    public function backgroundTask(string $taskId): ?object
    {
        try {
            $response = $this->reportClient->Reports_BackgroundTask_Result(['TaskId' => $taskId]);

            return $response->Reports_BackgroundTask_ResultResult ?? null;
        } catch (\Exception $e) {
            throw new NmbrsException($e->getMessage());
        }
    }

    /**
     * Wacht op het resultaat van een Nmbrs background-task met exponential backoff.
     * Polled met sleep-reeks 3, 5, 8, 13, 20, 30, 30, ... seconden (capped op 30s per iteratie)
     * en stopt zodra de volgende sleep de maxSeconds zou overschrijden.
     *
     * @param string $taskId
     * @param int $maxSeconds Totale max wachttijd in seconden (default 60)
     *
     * @return \stdClass Het volledige result object met Status='Success'
     *
     * @throws NmbrsException Bij status Failed/Error/Unknown of timeout
     */
    public function waitForBackgroundTaskResult(string $taskId, int $maxSeconds = 60): \stdClass
    {
        $sleepSequence = [3, 5, 8, 13, 20, 30];
        $start = time();
        $iteration = 0;
        $lastStatus = '';

        while (true) {
            $result = $this->backgroundTask($taskId);

            $lastStatus = strtolower((string)($result?->Status ?? ''));

            if ('success' === $lastStatus) {
                return $result;
            }

            if (in_array($lastStatus, ['failed', 'error', 'unknown'], true)) {
                throw new NmbrsException(
                    'Background task ' . $taskId . ' failed: status=' . $lastStatus
                );
            }

            $elapsed = time() - $start;
            $sleep = $sleepSequence[$iteration] ?? $maxSeconds;

            if (($elapsed + $sleep) > $maxSeconds) {
                $remaining = $maxSeconds - $elapsed;
                if ($remaining <= 0) {
                    break;
                }
                $sleep = min($sleep, $remaining);
            }

            sleep($sleep);
            $iteration++;
        }

        $elapsedFinal = time() - $start;
        if ('' !== $lastStatus) {
            $statusForMessage = $lastStatus;
        } else {
            $statusForMessage = 'unknown';
        }
        throw new NmbrsException(
            'Background task ' . $taskId . ' timeout after ' . $elapsedFinal . 's, last status: ' . $statusForMessage
        );
    }
}
