<?php

namespace App\Infrastructure\Delivery\Api\Symfony\Controller\User;

use App\Application\ApplicationException;
use App\Application\RegisterUser\RegisterUserRequest;
use App\Application\RegisterUser\RegisterUserService;
use App\Infrastructure\Validation\Symfony\User\UserRegisterValidator;
use App\Infrastructure\Validation\Symfony\ValidationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegisterUserController extends AbstractController
{
    private RegisterUserService $service;
    private UserRegisterValidator $validator;
    private TranslatorInterface $translator;

    public function __construct(
        RegisterUserService $service,
        UserRegisterValidator $validator,
        TranslatorInterface $translator
    ){
        $this->service = $service;
        $this->validator = $validator;
        $this->translator = $translator;
    }

    public function __invoke(Request $request)
    {
        $name = $request->get('name');
        $email = $request->get('email');
        $password = $request->get('password');

        try {
            $this->validator
                ->validate($request->toArray());

            $response = $this->service
                ->execute(new RegisterUserRequest($name, $email, $password)
            );

            return $this->json([
                'status' => 'success',
                'data' => [
                    'user' => $response->user()
                ]
            ]);

        }catch (ValidationException $e){
            return $this->json([
                'status' => 'fail',
                'message' => $e->getMessage(),
                'errors' => $e->getErrors()
            ], $e->getCode());
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