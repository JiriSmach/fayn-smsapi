<?php

declare(strict_types=1);

namespace JiriSmach\FaynSmsApi;

use DateTimeInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Utils;
use JiriSmach\FaynSmsApi\Request\StatisticsRequest;
use JiriSmach\FaynSmsApi\Wrappers\CreditHistoryWrapper;
use JiriSmach\FaynSmsApi\Wrappers\StatisticsDataWrapper;

class Statistics
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param  DateTimeInterface|null $from
     * @param  DateTimeInterface|null $to
     * @param  int|null               $userId
     * @return StatisticsDataWrapper
     * @throws \JiriSmach\FaynSmsApi\Exceptions\LoginException
     * @throws GuzzleException
     */
    public function getStatistics(
        ?DateTimeInterface $from = null,
        ?DateTimeInterface $to = null,
        ?int $userId = null,
    ): StatisticsDataWrapper {
        $statisticsRequest = new StatisticsRequest($userId);
        if ($from) {
            $statisticsRequest->addUrlParam('creditHistoryFrom', $from->format(DateTimeInterface::ATOM));
        }

        if ($to) {
            $statisticsRequest->addUrlParam('creditHistoryTo', $to->format(DateTimeInterface::ATOM));
        }

        $response = $this->connection->doRequest($statisticsRequest);
        $responseArray = Utils::jsonDecode($response->getBody()?->getContents() ?: '', true);
        $statisticsDataWrapper = new StatisticsDataWrapper();

        $statisticsDataWrapper->setCredit($responseArray['credit'] ?? 0);
        foreach (($responseArray['creditHistory'] ?? []) as $creditHistory) {
            $statisticsDataWrapper->addCreditHistory(new CreditHistoryWrapper(
                $creditHistory['date'] ?? '',
                $creditHistory['value'] ?? 0,
            ));
        }
        $smsStaticstics = $responseArray['smsStaticstics'] ?? [];
        $statisticsDataWrapper->setAvrgMonthSent($smsStaticstics['avrgMonthSent'] ?? '');
        $statisticsDataWrapper->setAvrgMonthReceived($smsStaticstics['avrgMonthReceived'] ?? '');
        $statisticsDataWrapper->setLastMonthSentMessages($smsStaticstics['lastMonthSentMessages'] ?? '');
        $statisticsDataWrapper->setLastMonthDeliveredMessages($smsStaticstics['lastMonthDeliveredMessages'] ?? '');
        $statisticsDataWrapper->setUndeliveredMessages($smsStaticstics['undeliveredMessages'] ?? '');
        $statisticsDataWrapper->setDeliveredMessages($smsStaticstics['deliveredMessages'] ?? '');
        $statisticsDataWrapper->setReceivedMessages($smsStaticstics['receivedMessages'] ?? '');
        $statisticsDataWrapper->setUnknownStateMessages($smsStaticstics['unknownStateMessages'] ?? '');
        $statisticsDataWrapper->setInQueueMessages($smsStaticstics['inQueueMessages'] ?? '');
        $statisticsDataWrapper->setLastMonthSentSmsCount($smsStaticstics['lastMonthSentSmsCount'] ?? '');
        $statisticsDataWrapper->setLastMonthDeliveredSmsCount($smsStaticstics['lastMonthDeliveredSmsCount'] ?? '');
        $statisticsDataWrapper->setUndeliveredSmsCount($smsStaticstics['undeliveredSmsCount'] ?? '');
        $statisticsDataWrapper->setDeliveredSmsCount($smsStaticstics['deliveredSmsCount'] ?? '');
        $statisticsDataWrapper->setInQueueSmsCount($smsStaticstics['inQueueSmsCount'] ?? '');
        $statisticsDataWrapper->setUnknownStateSmsCount($smsStaticstics['unknownStateSmsCount'] ?? '');

        return $statisticsDataWrapper;
    }
}
