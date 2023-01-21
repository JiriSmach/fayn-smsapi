<?php declare(strict_types=1);

namespace JiriSmach\FaynSmsApi\Wrappers;

use InvalidArgumentException;
use JiriSmach\FaynSmsApi\Helpers\Numbers;
use JiriSmach\FaynSmsApi\SmsInterface;
use LengthException;

class SmsWrapper implements SmsInterface
{
    private ?string $id = null;
    private string $messageId = '';
    private string $reciever = '';
    private string $text = '';
    private string $sender = '';
    private string $textId = '';
    private bool $priority = false;
    private string $sendAt = '';
    private string $status = '';
    private string $deliveredAt = '';
    private string $receivedAt = '';
    private bool $read = false;
    private Numbers $numberHelper;

    public function __construct()
    {
        $this->numberHelper = new Numbers();
    }

    public function getData(): array
    {
        return [
            'aNumber' => $this->sender, //sender
            'textId' => $this->textId,
            'bNumber' => $this->reciever, //reciever
            'messageType' => self::SMS_TYPE,
            'text' => $this->text,
            'priority' => $this->priority,
            'sendAt' => $this->sendAt, // dateTime
            'externalId' => $this->id,
        ];
    }

    public function setId(string $id): self
    {
        if (mb_strlen($id) > 36) {
            throw new LengthException('Maximum is 36 chars.');
        }
        $this->id = $id;
        return $this;
    }

    /**
     * @param string $receiver
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
     * @param string $sender
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

    public function setSendAt(string $sendAt): self
    {
        $this->sendAt = $sendAt;
        return $this;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function setDeliveredAt(string $deliveryAt): self
    {
        $this->deliveredAt = $deliveryAt;
        return $this;
    }

    public function setReceivedAt(string $receivedAt): self
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

    public function getSendAt(): string
    {
        return $this->sendAt;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getDeliveredAt(): string
    {
        return $this->deliveredAt;
    }

    public function getReceivedAt(): string
    {
        return $this->receivedAt;
    }

    public function getRead(): bool
    {
        return $this->read;
    }
}
