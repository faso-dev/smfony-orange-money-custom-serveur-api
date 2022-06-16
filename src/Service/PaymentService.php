<?php declare(strict_types=1);

namespace App\Service;

use App\Service\Enum\PaymentType;
use CPay\Sdk\Config\Credentials;
use CPay\Sdk\Config\TransactionData;
use CPay\Sdk\Payment;
use CPay\Sdk\Transaction;
use Symfony\Component\HttpFoundation\JsonResponse;


class PaymentService
{
    private ?Transaction $orangeTransaction = null;

    public function __construct(private string $username, private string $password, private string $merchantId)
    {
        if (null === $this->orangeTransaction) {
            $this->orangeTransaction = Payment::initWithCredentials(Credentials::from($this->username, $this->password, $this->merchantId));
        }
    }

    public function setPaymentType(PaymentType $paymentType): self
    {
        if (PaymentType::FAKE === $paymentType) {
            $this->orangeTransaction
                ->useDevApi()
                ->withoutSSLVerification();
        } else if (PaymentType::REAL === $paymentType) {
            $this->orangeTransaction->useProdApi();
        }
        return $this;
    }

    public function pay(TransactionData $transactionData, callable $successCallable, callable $errorCallable): JsonResponse
    {
        return $this->orangeTransaction
            ->withTransactionData($transactionData)
            ->on($successCallable, $errorCallable);
    }
}