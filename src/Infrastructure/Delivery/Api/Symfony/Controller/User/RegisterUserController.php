<?php

namespace App\Infrastructure\Delivery\Api\Symfony\Controller\User;

use App\Application\RegisterUser\RegisterUserRequest;
use App\Application\RegisterUser\RegisterUserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class RegisterUserController extends AbstractController
{
    private RegisterUserService $service;

    public function __construct(RegisterUserService $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request)
    {
        $name = $request->get('name');
        $email = $request->get('email');

        try {

            $response = $this->service->execute(
                new RegisterUserRequest(
                    $name,
                    $email,
                )
            );

            return $this->json([
                'status' => 'success',
                'data' => [
                    'user' => $response->user()
                ]
            ]);

        } catch (\Throwable $e){

            $this->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], $e->getCode()?:500);

        }
    }
}