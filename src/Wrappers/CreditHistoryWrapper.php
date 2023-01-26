<?php

declare(strict_types=1);

namespace JiriSmach\FaynSmsApi\Wrappers;

class CreditHistoryWrapper
{
    private string $date;
    private int $value;

    public function __construct(string $date, int $value)
    {
        $this->date  = $date;
        $this->value = $value;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
