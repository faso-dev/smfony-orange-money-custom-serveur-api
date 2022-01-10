<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\OrangePaymentData;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PaymentTransactionDataValidatorService
{
    public function __construct(private ValidatorInterface $validator)
    {
    }

    public function validate(OrangePaymentData $data): array
    {

        $violationsMessages = [];
        $violations = $this->validator->validate($data);
        if ($violations->count() > 0) {
            /** @var ConstraintViolationInterface $violation */
            foreach ($violations as $violation) {
                $violationsMessages[OrangePaymentData::VALIDATION_PROPERIES[$violation->getPropertyPath()]][] = $violation->getMessage();
            }
        }

        return $violationsMessages;
    }
}