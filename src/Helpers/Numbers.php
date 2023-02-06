<?php

declare(strict_types=1);

namespace JiriSmach\FaynSmsApi\Helpers;

use InvalidArgumentException;

class Numbers
{
    /**
     * @param  string $phoneNumber
     * @param  int[]  $requiredCountryCallingCodes - example: [420, 1, 86, 250]
     * @return string
     * @throws InvalidArgumentException
     */
    public function validatePhoneNumber(string $phoneNumber, array $requiredCountryCallingCodes = []): string
    {
        $phoneNumber = \str_replace([' ', '-', '(', ')'], '', $phoneNumber);
        $phoneNumber = \str_replace('+', '00', $phoneNumber);
        $regex = '(0{2}[0-9]{1,4})([0-9]{8,15})';
        $requiredCountryCallingCodes = \array_unique(
            \array_filter(
                $requiredCountryCallingCodes,
                static function ($x) {
                    return \is_numeric($x) && \strlen((string)$x) <= 4;
                },
            ),
        );
        if (!empty($requiredCountryCallingCodes)) {
            $calingCodes = [];
            foreach ($requiredCountryCallingCodes as $callingCode) {
                $len = \strlen((string)$callingCode);
                $calingCodes[] = '([00' . $callingCode . ']{' . ($len + 2) . '})';
            }
            $regex = '(' . \implode('|', $calingCodes) . ')([0-9]{8,15})';
        }
        if (!\preg_match('/^' . $regex . '$/', $phoneNumber)) {
            throw new \InvalidArgumentException('Invalid phone number: ' . $phoneNumber);
        }

        return $phoneNumber;
    }
}
