<?php

namespace App\Controller;

use App\Service\Enum\PaymentType;
use App\Service\PaymentService;
use App\Service\PaymentTransactionDataValidatorService;
use App\Service\Traits\Http\Request\PaymentHttpRequestProcessorTrait;
use App\Service\Traits\Http\Response\PaymentHttpJsonResponseTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/v1/", name="cpay_api_")
 */
class ApiController extends AbstractController
{
    use PaymentHttpJsonResponseTrait;
    use PaymentHttpRequestProcessorTrait;

    private PaymentService $paymentService;

    private PaymentTransactionDataValidatorService $transactionDataValidatorService;

    public function __construct(PaymentService $paymentService, PaymentTransactionDataValidatorService $transactionDataValidatorService)
    {
        $this->paymentService = $paymentService;
        $this->transactionDataValidatorService = $transactionDataValidatorService;
    }

    /**
     * @Route("pay", name="pay", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function makeRealPayment(Request $request): JsonResponse
    {
        return $this->processPaymentRequest($request, PaymentType::REAL);
    }

    /**
     * @Route("dev/pay", name="fake_pay", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function makeTestPayment(Request $request): JsonResponse
    {
        return $this->processPaymentRequest($request, PaymentType::FAKE);
    }


}
