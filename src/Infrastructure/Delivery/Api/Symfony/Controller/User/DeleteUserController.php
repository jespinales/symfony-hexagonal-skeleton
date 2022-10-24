<?php

namespace App\Infrastructure\Delivery\Api\Symfony\Controller\User;

use App\Application\ApplicationException;
use App\Application\DeleteUser\DeleteUserRequest;
use App\Application\DeleteUser\DeleteUserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;

class DeleteUserController extends AbstractController
{
    private DeleteUserService $service;
    private TranslatorInterface $translator;

    public function __construct(
        DeleteUserService $service,
        TranslatorInterface $translator)
    {
        $this->service = $service;
        $this->translator = $translator;
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

        } catch (ApplicationException $e){
            return $this->json([
                'status' => 'fail',
                'message' => $this->translator
                    ->trans($e->getMessage(), [], 'messages')
            ], $e->getCode());
        } catch (\Throwable $e){
            return $this->json([
                'status' => 'error',
                'message' => 'An error occurred'
            ], 500);
        }
    }
}