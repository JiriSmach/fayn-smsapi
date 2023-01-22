<?php
declare(strict_types=1);

namespace JiriSmach\FaynSmsApi;

interface RequestInterface
{
    public const METHOD_GET = 'GET',
        METHOD_POST         = 'POST',
        METHOD_PATCH        = 'PATCH',
        METHOD_DELETE       = 'DELETE';

    public function getBodyJson(): string;
    public function getPath(): string;
    public function getMethod(): string;
    public function getUrlParams(): array;
}
