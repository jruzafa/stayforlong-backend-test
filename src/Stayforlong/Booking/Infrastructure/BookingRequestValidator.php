<?php

declare(strict_types=1);

namespace Stayforlong\Booking\Infrastructure;

final class BookingRequestValidator
{
    private const array REQUIRED_FIELDS = [
        'request_id',
        'check_in',
        'nights',
        'selling_rate',
        'margin'
    ];

    public function validate(array $statsRequest): void
    {
        if (empty($statsRequest)) {
            throw new \InvalidArgumentException('Stats request is empty');
        }

        foreach ($statsRequest as $statsRequestValue) {
            foreach (self::REQUIRED_FIELDS as $requiredField) {
                if (!isset($statsRequestValue[$requiredField])) {
                    throw new \InvalidArgumentException( "Error! Field $requiredField is mandatory");
                }
            }
        }

        // todo: validate types?
    }
}