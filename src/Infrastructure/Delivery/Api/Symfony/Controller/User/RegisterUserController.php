<?php

namespace App\Infrastructure\Delivery\Api\Symfony\Controller\User;

use App\Application\RegisterUser\RegisterUserRequest;
use App\Application\RegisterUser\RegisterUserService;
use App\Application\Shared\Model\User\DtoUserDataTransformer;
use App\Infrastructure\Model\User\Doctrine\DoctrineUserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class RegisterUserController extends AbstractController
{
    private RegisterUserService $service;

    public function __construct(ContainerInterface $container)
    {
        /** @var DoctrineUserRepository $repository */
        $repository = $container->get(DoctrineUserRepository::class);

        $this->service = new RegisterUserService(
            $repository,
            new DtoUserDataTransformer()
        );
    }

    public function __invoke(Request $request)
    {
        $name = $request->get('name');
        $email = $request->get('email');

        try {

            $this->service->execute(
                new RegisterUserRequest(
                    $name,
                    $email,
                )
            );

            return $this->json([
                'status' => 'success',
                'data' => [
                    'user' => $this->service->userDataTransformer()->read()
                ]
            ]);

        } catch (\Throwable $e){

            return $this->json([
                'message' => $e->getMessage(),
            ], $e->getCode()?:400);

        }
    }
}