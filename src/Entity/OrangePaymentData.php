<?php declare(strict_types=1);


namespace App\Entity;

use CPay\Sdk\Config\TransactionData;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class OrangePaymentData
{
    public const VALIDATION_PROPERIES = [
        'clientNumber' => 'client_number',
        'paymentAmount' => 'payment_amount',
        'otp' => 'otp',
    ];

    #[
        NotBlank(message: 'Le numéro du client est obligatoire'),
    ]
    public ?string $clientNumber;
    #[
        NotBlank(message: 'Le montant de la transaction est obligatoire'),
        Positive(message: 'Le montant de la transaction ne peut négatif'),
    ]
    public ?string $paymentAmount;
    #[
        NotBlank(message: 'Le code otp est obligatoire')
    ]
    public ?string $otp;

    private function __construct(array $data)
    {
        $this->clientNumber = $data['client_number'] ?? null;
        $this->paymentAmount = $data['payment_amount'] ?? null;
        $this->otp = $data['otp'] ?? null;
    }

    public static function createFromJsonData(array $data = []): self
    {
        return new self($data);
    }

    public function toOrangeTransactionData(): TransactionData
    {
        return TransactionData::from($this->clientNumber, $this->paymentAmount, $this->otp);
    }
}