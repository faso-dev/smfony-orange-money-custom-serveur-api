<?php

namespace App\Controller;

use App\Service\Enum\PaymentType;
use App\Service\PaymentService;
use App\Service\PaymentTransactionDataValidatorService;
use App\Service\Trait\Http\Request\PaymentHttpRequestProcessorTrait;
use App\Service\Trait\Http\Response\PaymentHttpJsonResponseTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/', name: 'businessman_api_')]
class ApiController extends AbstractController
{
    use PaymentHttpJsonResponseTrait;
    use PaymentHttpRequestProcessorTrait;

    public function __construct(private PaymentService $paymentService, private PaymentTransactionDataValidatorService $transactionDataValidatorService)
    {
    }

    #[Route('pay', name: 'pay', methods: ['POST'])]
    public function makeRealPayment(Request $request): JsonResponse
    {
        return $this->processPaymentRequest($request, PaymentType::REAL);
    }

    #[Route('dev/pay', name: 'fake_pay', methods: ['POST'])]
    public function makeTestPayment(Request $request): JsonResponse
    {
        return $this->processPaymentRequest($request, PaymentType::FAKE);
    }


}
