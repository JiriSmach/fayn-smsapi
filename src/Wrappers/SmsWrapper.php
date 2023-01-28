<?php

declare(strict_types=1);

namespace JiriSmach\FaynSmsApi\Wrappers;

use DateTime;
use DateTimeInterface;
use InvalidArgumentException;
use JiriSmach\FaynSmsApi\Helpers\Numbers;
use JiriSmach\FaynSmsApi\SmsInterface;

class SmsWrapper implements SmsInterface
{
    private ?string $id = null;
    private string $messageId = '';
    private string $reciever = '';
    private string $text = '';
    private string $sender = '';
    private string $textId = '';
    private bool $priority = false;
    private DateTimeInterface $sendAt;
    private string $status = '';
    private ?DateTimeInterface $deliveredAt = null;
    private ?DateTimeInterface $receivedAt = null;
    private bool $read = false;
    private Numbers $numberHelper;

    public function __construct()
    {
        $this->numberHelper = new Numbers();
        $this->setDefaultValues();
    }

    /**
     * @return array<string, mixed>
     */
    public function getData(): array
    {
        return [
            'aNumber' => $this->sender,
            'textId' => $this->textId,
            'bNumber' => $this->reciever,
            'messageType' => self::SMS_TYPE,
            'text' => $this->text,
            'priority' => $this->priority,
            'sendAt' => (string)$this->sendAt->getTimestamp(),
            'externalId' => $this->id,
        ];
    }

    public function setId(string $id): self
    {
        if (\mb_strlen($id) > 36) {
            throw new \LengthException('Maximum is 36 chars.');
        }
        $this->id = $id;

        return $this;
    }

    /**
     * @param  string $receiver
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setReceiver(string $receiver): self
    {
        $this->reciever = $this->numberHelper->validatePhoneNumber($receiver, [420]);

        return $this;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function setMessageId(string $messageId): self
    {
        $this->messageId = $messageId;

        return $this;
    }

    /**
     * @param  string $sender
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setSender(string $sender): self
    {
        $this->sender = $this->numberHelper->validatePhoneNumber($sender, [420]);

        return $this;
    }

    public function setTextId(string $textId): self
    {
        $this->textId = $textId;

        return $this;
    }

    public function setPriority(bool $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function setSendAt(DateTimeInterface $sendAt): self
    {
        $this->sendAt = $sendAt;

        return $this;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function setDeliveredAt(DateTimeInterface $deliveryAt): self
    {
        $this->deliveredAt = $deliveryAt;

        return $this;
    }

    public function setReceivedAt(DateTimeInterface $receivedAt): self
    {
        $this->receivedAt = $receivedAt;

        return $this;
    }

    public function setRead(bool $read): self
    {
        $this->read = $read;

        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getReciever(): string
    {
        return $this->reciever;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getMessageId(): string
    {
        return $this->messageId;
    }

    public function getSender(): string
    {
        return $this->sender;
    }

    public function getTextId(): string
    {
        return $this->textId;
    }

    public function getPriority(): bool
    {
        return $this->priority;
    }

    public function getSendAt(): DateTimeInterface
    {
        return $this->sendAt;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getDeliveredAt(): ?DateTimeInterface
    {
        return $this->deliveredAt;
    }

    public function getReceivedAt(): ?DateTimeInterface
    {
        return $this->receivedAt;
    }

    public function getRead(): bool
    {
        return $this->read;
    }

    private function setDefaultValues(): void
    {
        $this->sendAt = new DateTime();
    }
}
