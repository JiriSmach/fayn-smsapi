<?php declare(strict_types=1);

namespace JiriSmach\FaynSmsApi;

class SmsWrapper implements SmsInterface
{
    private array $numbers = [];
    private string $text = '';
    public function getData(): array
    {
        return [];
    }

    public function setNumbers(array $numbers): self
    {
        $this->numbers = $numbers;
        return $this;
    }

    public function setText(string $text): self
    {
        $this->text = $text;
        return $this;
    }
}
