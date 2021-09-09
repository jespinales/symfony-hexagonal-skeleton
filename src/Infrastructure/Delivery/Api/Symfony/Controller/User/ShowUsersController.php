<?php

namespace App\Infrastructure\Delivery\Api\Symfony\Controller\User;

use App\Application\Shared\Model\User\DtoUserCollectionDataTransformer;
use App\Application\ShowUsers\ShowUsersService;
use App\Infrastructure\Model\User\Doctrine\DoctrineUserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class ShowUsersController extends AbstractController
{
    private ShowUsersService $service;

    public function __construct(ContainerInterface $container)
    {
        /** @var DoctrineUserRepository $repository */
        $repository = $container->get(DoctrineUserRepository::class);

        /** @var DtoUserCollectionDataTransformer $dataTransformer */
        $dataTransformer = $container->get(DtoUserCollectionDataTransformer::class);

        $this->service = new ShowUsersService(
            $repository,
            $dataTransformer
        );
    }

    public function __invoke(): JsonResponse
    {
        $this->service->execute();

        return $this->json([
            'status' => 'success',
            'data' => [
                'users' => $this->service
                    ->userCollectionDataTransformer()
                    ->read()
            ]
        ]);
    }
}