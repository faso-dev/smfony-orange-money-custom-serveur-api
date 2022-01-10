<?php declare(strict_types=1);

namespace App\Service\Traits\Http\Request;

use App\Entity\OrangePaymentData;
use App\Service\Enum\PaymentType;
use CPay\Sdk\TransactionResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use function count;
use function json_decode;

trait PaymentHttpRequestProcessorTrait
{
    /**
     * @param Request $request
     * @param string $paymentType
     * @return JsonResponse
     */
    private function processPaymentRequest(Request $request, string $paymentType): JsonResponse
    {
        $orangePaymentData = OrangePaymentData::createFromJsonData(json_decode($request->getContent(), true) ?? []);
        if (count($violations = $this->transactionDataValidatorService->validate($orangePaymentData)) === 0) {
            return $this->paymentService
                ->setPaymentType($paymentType)
                ->pay(
                    $orangePaymentData->toOrangeTransactionData(),
                    fn(TransactionResponse $transactionResponse) => $this->onSuccessPaymentHttpJsonResponse($transactionResponse),
                    fn(string $errorMessage, int $statusCode) => $this->onFailedPaymentHttpJsonResponse($errorMessage, $statusCode)
                );
        }
        return $this->invalidDataHttpJsonResponse($violations);
    }
}