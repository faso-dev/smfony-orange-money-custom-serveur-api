<?php

namespace App\Service;

use App\Entity\OrangeTransactionData;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PaymentTransactionDataValidatorService
{
    public function __construct(private ValidatorInterface $validator)
    {
    }

    public function validate(OrangeTransactionData $data): array
    {

        $violationsMessages = [];
        $violations = $this->validator->validate($data);
        if ($violations->count() > 0) {
            /** @var ConstraintViolationInterface $violation */
            foreach ($violations as $violation) {
                $violationsMessages[OrangeTransactionData::VALIDATION_PROPERIES[$violation->getPropertyPath()]][] = $violation->getMessage();
            }
        }

        return $violationsMessages;
    }
}