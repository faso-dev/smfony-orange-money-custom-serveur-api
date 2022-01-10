<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function sprintf;


class HomeController extends AbstractController
{
    #[Route('/', name: 'businessman_api')]
    #[Route('/api/v1/', name: 'businessman_api_v1_doc')]
    public function index(Request $request): Response
    {
        return $this->json([
            'message' => 'My custom serveur payment api',
            'version' => 'v1',
            'documentation' => [
                'version' => 'v1',
                'make_payment_request' => [
                    'with_fetch_or_axios' => [
                        'url' => sprintf("%s/api/v1/pay", $request->getSchemeAndHttpHost()),
                        'method' => 'POST',
                        'headers' => [
                            'Content-type' => 'application/json',
                        ],
                        'body_or_data' => [
                            "client_number" => "00000000",
                            "payment_amount" => "100",
                            "otp" => "123456",
                        ],
                    ]
                ]
            ],
        ]);
    }
}
