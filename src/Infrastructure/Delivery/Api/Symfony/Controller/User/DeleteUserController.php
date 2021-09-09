<?php

namespace App\Infrastructure\Delivery\Api\Symfony\Controller\User;

use App\Application\DeleteUser\DeleteUserRequest;
use App\Application\DeleteUser\DeleteUserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class DeleteUserController extends AbstractController
{
    private DeleteUserService $service;

    public function __construct(DeleteUserService $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request)
    {
        try {
            $id = $request->get('id');

            $this->service->execute(
                new DeleteUserRequest($id)
            );

            return $this->json([
                'status' => 'success',
                'data' => null
            ]);

        } catch (\Throwable $e) {
            return $this->json([
                'message' => $e->getMessage(),
            ], $e->getCode()?:400);
        }
    }
}