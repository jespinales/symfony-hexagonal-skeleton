<?php

namespace App\Infrastructure\Delivery\Api\Symfony\Controller\User;

use App\Application\ShowUsers\ShowUsersRequest;
use App\Application\ShowUsers\ShowUsersService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ShowUsersController extends AbstractController
{
    private ShowUsersService $service;

    public function __construct(ShowUsersService $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $page = $request->get('page') ?? 1;
        $perPage = $request->get('perPage') ?? 15;

        try {
            $response = $this->service
                ->execute(new ShowUsersRequest($page, $perPage));

            return $this->json([
                'status' => 'success',
                'data' => [
                    'pagination' => $response->pagination()
                ]
            ]);

        } catch (\Throwable $e){

            return $this->json([
                'status' => 'error',
                'message' => 'An error occurred.'
            ], 500);

        }
    }
}