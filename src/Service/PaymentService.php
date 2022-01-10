<?php

namespace App\Service;

use CPay\Sdk\Config\Credentials;
use CPay\Sdk\Config\TransactionData;
use CPay\Sdk\Exception\TransactionException;
use CPay\Sdk\Payment;
use CPay\Sdk\Transaction;
use CPay\Sdk\TransactionResponse;
use Symfony\Component\HttpKernel\KernelInterface;

class PaymentService
{
    private ?Transaction $orangeTransaction = null;

    public function __construct(private string $username, private string $password, private string $merchantId, private KernelInterface $kernel)
    {
        if (null === $this->orangeTransaction) {
            $this->orangeTransaction = Payment::initWithCredentials(Credentials::from($this->username, $this->password, $this->merchantId));
        }
    }

    public function pay(TransactionData $transactionData, callable $successCallable, callable $errorCallable): mixed
    {
        $transaction = $this->orangeTransaction
            ->useDevApi()
            ->withTransactionData($transactionData);

        if ($this->kernel->getEnvironment() == 'prod') {
            $transaction->useProdApi();
        }
        return $transaction
            ->withoutSSLVerification()
            ->on($successCallable, $errorCallable);
    }
}