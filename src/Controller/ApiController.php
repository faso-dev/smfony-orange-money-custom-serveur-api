<?php

namespace App\Controller;

use App\Entity\OrangeTransactionData;
use App\Service\PaymentService;
use App\Service\PaymentTransactionDataValidatorService;
use CPay\Sdk\TransactionResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function json_decode;

#[Route('/api/v1/', name: 'businessman_api_')]
class ApiController extends AbstractController
{
    use PaymentHttpJsonResponseTrait;

    public function __construct(private PaymentService $paymentService, private PaymentTransactionDataValidatorService $transactionDataValidatorService)
    {
    }

    #[Route('pay', name: 'pay', methods: ['POST'])]
    public function index(Request $request): Response
    {
        $data = new OrangeTransactionData(json_decode($request->getContent(), true) ?? []);
        if (count($violations = $this->transactionDataValidatorService->validate($data)) === 0) {
            return $this->paymentService->pay(
                transactionData: $data->toOrangeTransactionData(),
                successCallable: fn(TransactionResponse $transactionResponse) => $this->onSuccessPaymentHttpJsonResponse($transactionResponse),
                errorCallable: fn(string $errorMessage, int $statusCode) => $this->onFailedPaymentHttpJsonResponse($errorMessage, $statusCode)
            );
        }
        return $this->invalidDataHttpJsonResponse($violations);
    }

}
