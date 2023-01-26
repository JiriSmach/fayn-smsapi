<?php

declare(strict_types=1);

namespace JiriSmach\FaynSmsApi\Wrappers;

class StatisticsDataWrapper
{
    private int $credit = 0;

    /** @var CreditHistoryWrapper[] */
    private array $creditHistory = [];
    private string $avrgMonthSent;
    private string $avrgMonthReceived;
    private string $lastMonthSentMessages;
    private string $lastMonthDeliveredMessages;
    private string $undeliveredMessages;
    private string $deliveredMessages;
    private string $receivedMessages;
    private string $unknownStateMessages;
    private string $inQueueMessages;
    private string $lastMonthSentSmsCount;
    private string $lastMonthDeliveredSmsCount;
    private string $undeliveredSmsCount;
    private string $deliveredSmsCount;
    private string $inQueueSmsCount;
    private string $unknownStateSmsCount;

    public function setCredit(int $credit): self
    {
        $this->credit = $credit;

        return $this;
    }

    public function addCreditHistory(CreditHistoryWrapper $creditHistoryWrapper): self
    {
        $this->creditHistory[$creditHistoryWrapper->getDate()] = $creditHistoryWrapper;

        return $this;
    }

    public function setAvrgMonthSent(string $avrgMonthSent): self
    {
        $this->avrgMonthSent = $avrgMonthSent;

        return $this;
    }

    public function setAvrgMonthReceived(string $avrgMonthReceived): self
    {
        $this->avrgMonthReceived = $avrgMonthReceived;

        return $this;
    }

    public function setLastMonthSentMessages(string $lastMonthSentMessages): self
    {
        $this->lastMonthSentMessages = $lastMonthSentMessages;

        return $this;
    }

    public function setLastMonthDeliveredMessages(string $lastMonthDeliveredMessages): self
    {
        $this->lastMonthDeliveredMessages = $lastMonthDeliveredMessages;

        return $this;
    }

    public function setUndeliveredMessages(string $undeliveredMessages): self
    {
        $this->undeliveredMessages = $undeliveredMessages;

        return $this;
    }

    public function setDeliveredMessages(string $deliveredMessages): self
    {
        $this->deliveredMessages = $deliveredMessages;

        return $this;
    }

    public function setReceivedMessages(string $receivedMessages): self
    {
        $this->receivedMessages = $receivedMessages;

        return $this;
    }

    public function setUnknownStateMessages(string $unknownStateMessages): self
    {
        $this->unknownStateMessages = $unknownStateMessages;

        return $this;
    }

    public function setInQueueMessages(string $inQueueMessages): self
    {
        $this->inQueueMessages = $inQueueMessages;

        return $this;
    }

    public function setLastMonthSentSmsCount(string $lastMonthSentSmsCount): self
    {
        $this->lastMonthSentSmsCount = $lastMonthSentSmsCount;

        return $this;
    }

    public function setLastMonthDeliveredSmsCount(string $lastMonthDeliveredSmsCount): self
    {
        $this->lastMonthDeliveredSmsCount = $lastMonthDeliveredSmsCount;

        return $this;
    }

    public function setUndeliveredSmsCount(string $undeliveredSmsCount): self
    {
        $this->undeliveredSmsCount = $undeliveredSmsCount;

        return $this;
    }

    public function setDeliveredSmsCount(string $deliveredSmsCount): self
    {
        $this->deliveredSmsCount = $deliveredSmsCount;

        return $this;
    }

    public function setInQueueSmsCount(string $inQueueSmsCount): self
    {
        $this->inQueueSmsCount = $inQueueSmsCount;

        return $this;
    }

    public function setUnknownStateSmsCount(string $unknownStateSmsCount): self
    {
        $this->unknownStateSmsCount = $unknownStateSmsCount;

        return $this;
    }

    public function getCredit(): int
    {
        return $this->credit;
    }

    /**
     * @return CreditHistoryWrapper[]
     */
    public function getCreditHistory(): array
    {
        return $this->creditHistory;
    }

    public function getAvrgMonthSent(): string
    {
        return $this->avrgMonthSent;
    }

    public function getAvrgMonthReceived(): string
    {
        return $this->avrgMonthReceived;
    }

    public function getLastMonthSentMessages(): string
    {
        return $this->lastMonthSentMessages;
    }

    public function getLastMonthDeliveredMessages(): string
    {
        return $this->lastMonthDeliveredMessages;
    }

    public function getUndeliveredMessages(): string
    {
        return $this->undeliveredMessages;
    }

    public function getDeliveredMessages(): string
    {
        return $this->deliveredMessages;
    }

    public function getReceivedMessages(): string
    {
        return $this->receivedMessages;
    }

    public function getUnknownStateMessages(): string
    {
        return $this->unknownStateMessages;
    }

    public function getInQueueMessages(): string
    {
        return $this->inQueueMessages;
    }

    public function getLastMonthSentSmsCount(): string
    {
        return $this->lastMonthSentSmsCount;
    }

    public function getLastMonthDeliveredSmsCount(): string
    {
        return $this->lastMonthDeliveredSmsCount;
    }

    public function getUndeliveredSmsCount(): string
    {
        return $this->undeliveredSmsCount;
    }

    public function getDeliveredSmsCount(): string
    {
        return $this->deliveredSmsCount;
    }

    public function getInQueueSmsCount(): string
    {
        return $this->inQueueSmsCount;
    }

    public function getUnknownStateSmsCount(): string
    {
        return $this->unknownStateSmsCount;
    }
}
