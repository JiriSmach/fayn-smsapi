<?php declare(strict_types=1);

namespace JiriSmach\FaynSmsApi;

class SmsWrapper implements SmsInterface
{
    private ?string $id = null;
    private string $messageId;
    private string $number = '';
    private string $text = '';
    private string $sender;
    private string $textId; //": "alphanum",
    private bool $priority = false;
    private string $sendAt; //": "string",
    private string $status; //": "entered",
    private string $deliveredAt; //": "string"

    public function getData(): array
    {
        return [
            'aNumber' => $this->sender, //sender
            'textId' => $this->textId,
            'bNumber' => $this->number, //reciever
            'messageType' => self::SMS_TYPE,
            'text' => $this->text,
            'priority' => $this->priority,
            'sendAt' => $this->sendAt, // dateTime
            'externalId' => $this->id, // system SMS ID (1-36 chars)
        ];
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setNumber(string $numbers): self
    {
        $this->number = $numbers;
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

    public function setSender(string $sender): self
    {
        $this->sender = $sender;
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
}
