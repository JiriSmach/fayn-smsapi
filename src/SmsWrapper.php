<?php declare(strict_types=1);

namespace JiriSmach\FaynSmsApi;

class SmsWrapper implements SmsInterface
{
    private ?string $id = null;
    private string $number = '';
    private string $text = '';
    public function getData(): array
    {
        return [
            'aNumber' => '', //sender
            'textId' => '',
            'bNumber' => $this->number, //reciever
            'messageType' => 'SMS',
            'text' => $this->text,
            'priority' => false,
            'sendAt' => '', // dateTime
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
}
