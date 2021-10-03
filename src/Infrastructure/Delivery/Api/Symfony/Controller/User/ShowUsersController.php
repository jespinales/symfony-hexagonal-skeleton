<?php

namespace App\Infrastructure\Delivery\Api\Symfony\Controller\User;

use App\Application\ShowUsers\ShowUsersService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class ShowUsersController extends AbstractController
{
    private ShowUsersService $service;

    public function __construct(ShowUsersService $service)
    {
        $this->service = $service;
    }

    public function __invoke(): JsonResponse
    {
        try{
            $response = $this->service->execute();

            return $this->json([
                'status' => 'success',
                'data' => [
                    'users' => $response->users()
                ]
            ]);

        } catch (\Throwable $e){

            return $this->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], $e->getCode() ?? 500);

        }
    }
}