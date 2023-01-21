<?php declare(strict_types=1);

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

    public function __construct(
        Connection $connection
    ) {
        $this->connection = $connection;
    }

    /**
     * @param DateTimeInterface|null $from
     * @param DateTimeInterface|null $to
     * @param int|null $userId
     * @return StatisticsDataWrapper
     * @throws Exceptions\LoginException
     * @throws GuzzleException
     */
    public function getStatistics(?DateTimeInterface $from = null, ?DateTimeInterface $to = null, ?int $userId = null): StatisticsDataWrapper
    {
        $statisticsRequest = new StatisticsRequest($userId);
        if ($from) {
            $statisticsRequest->addUrlParam('creditHistoryFrom', $from->format(DateTimeInterface::ATOM));
        }
        if ($to) {
            $statisticsRequest->addUrlParam('creditHistoryTo', $to->format(DateTimeInterface::ATOM));
        }

        $response = $this->connection->getRequest($statisticsRequest);
        $responseArray = Utils::jsonDecode($response->getBody()?->getContents() ?: '', true);
        $statisticsDataWrapper = new StatisticsDataWrapper();

        $statisticsDataWrapper->setCredit($responseArray['credit'] ?? 0);
        foreach (($responseArray['creditHistory'] ?? []) as $creditHistory) {
            $statisticsDataWrapper->addCreditHistory(new CreditHistoryWrapper(
                $creditHistory['date'] ?? '',
                $creditHistory['value'] ?? 0
            ));
        }

        $statisticsDataWrapper->setAvrgMonthSent($responseArray['smsStaticstics']['avrgMonthSent'] ?? '');
        $statisticsDataWrapper->setAvrgMonthReceived($responseArray['smsStaticstics']['avrgMonthReceived'] ?? '');
        $statisticsDataWrapper->setLastMonthSentMessages($responseArray['smsStaticstics']['lastMonthSentMessages'] ?? '');
        $statisticsDataWrapper->setLastMonthDeliveredMessages($responseArray['smsStaticstics']['lastMonthDeliveredMessages'] ?? '');
        $statisticsDataWrapper->setUndeliveredMessages($responseArray['smsStaticstics']['undeliveredMessages'] ?? '');
        $statisticsDataWrapper->setDeliveredMessages($responseArray['smsStaticstics']['deliveredMessages'] ?? '');
        $statisticsDataWrapper->setReceivedMessages($responseArray['smsStaticstics']['receivedMessages'] ?? '');
        $statisticsDataWrapper->setUnknownStateMessages($responseArray['smsStaticstics']['unknownStateMessages'] ?? '');
        $statisticsDataWrapper->setInQueueMessages($responseArray['smsStaticstics']['inQueueMessages'] ?? '');
        $statisticsDataWrapper->setLastMonthSentSmsCount($responseArray['smsStaticstics']['lastMonthSentSmsCount'] ?? '');
        $statisticsDataWrapper->setLastMonthDeliveredSmsCount($responseArray['smsStaticstics']['lastMonthDeliveredSmsCount'] ?? '');
        $statisticsDataWrapper->setUndeliveredSmsCount($responseArray['smsStaticstics']['undeliveredSmsCount'] ?? '');
        $statisticsDataWrapper->setDeliveredSmsCount($responseArray['smsStaticstics']['deliveredSmsCount'] ?? '');
        $statisticsDataWrapper->setInQueueSmsCount($responseArray['smsStaticstics']['inQueueSmsCount'] ?? '');
        $statisticsDataWrapper->setUnknownStateSmsCount($responseArray['smsStaticstics']['unknownStateSmsCount'] ?? '');

        return $statisticsDataWrapper;
    }
}
