<?php declare(strict_types=1);

namespace JiriSmach\FaynSmsApi;

interface RequestInterface
{
    public function getBodyJson(): string;
    public function getMethod(): string;
    public function getUrlParams(): array;
}
