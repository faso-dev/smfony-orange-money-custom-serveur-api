<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    #[Route('/', name: 'businessman_api')]
    #[Route('/api/v1/', name: 'businessman_api_v1_doc')]
    public function index(): Response
    {
        return $this->json([
            'message' => 'Businessman payment api',
            'version' => 'v1',
            'documentation' => [
                'request' => [
                    'url' => 'https://dc73-102-67-113-184.ngrok.io/api/v1/pay',
                    'method' => 'POST',
                    'headers' => [
                        'Content-type' => 'application/json',
                        'X-AUTH' => 'JWT TOKEN'
                    ],
                    'body' => [
                        "client_number" => "00000000",
                        "payment_amount" => "100",
                        "otp" => "123456",
                    ],
                ]
            ],
        ]);
    }
}
