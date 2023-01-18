<?php declare(strict_types=1);

namespace JiriSmach\FaynSmsApi\Request;

class SmsGetRequest extends SmsRequest
{
    private ?string $messageId;
    private ?string $externalId;
    public function __construct(?string $messageId = null, ?string $externalId = null)
    {
        $this->messageId = $messageId;
        $this->externalId = $externalId;
    }

    public function getMethod(): string
    {
        if ($this->messageId) {
            return parent::getMethod() . '/' . $this->messageId;
        } elseif ($this->externalId) {
            return parent::getMethod() . '/by-external-id/' . $this->externalId;
        }
        throw new \Exception('Need some ID');
    }

    /**
     * @return array
     */
    public function getUrlParams(): array
    {
        return [];
    }

    public function getBodyJson(): string
    {
        return '';
    }
}
