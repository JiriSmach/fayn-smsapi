<?php declare(strict_types=1);

namespace JiriSmach\FaynSmsApi\Request;

use DateTimeInterface;

class SmsGetListRequest extends SmsRequest
{
    private ?DateTimeInterface $datetimeTo;
    private ?DateTimeInterface $datetimeFrom;

    public function __construct(?DateTimeInterface $datetimeTo = null, ?DateTimeInterface $datetimeTo = null)
    {
        $this->datetimeFrom = $datetimeFrom;
        $this->datetimeTo = $datetimeTo;
    }

    public function getMethod(): string
    {
        return parent::getMethod() . '/list';
    }

    /**
     * @return array
     */
    public function getUrlParams(): array
    {
        $params = [];
        if ($this->datetimeFrom) {
            $params['timeFrom'] = $this->datetimeFrom->format(DateTimeInterface::ATOM);
        }
        if ($this->datetimeTo) {
            $params['timeTo'] = $this->datetimeTo->format(DateTimeInterface::ATOM);
        }
        
        return $params;
    }

    public function getBodyJson(): string
    {
        return '';
    }
}
