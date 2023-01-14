<?php declare(strict_types=1);

namespace JiriSmach\FaynSmsApi;

interface RequestInterface
{
    public function getBodyJson(): string;
}
