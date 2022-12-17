<?php

namespace App\Infrastructure\Delivery\Api\Symfony\Controller\Auth;

use App\Application\ApplicationException;
use App\Application\Login\LoginRequest;
use App\Application\Login\LoginService;
use App\Infrastructure\Validation\Symfony\Auth\LoginValidator;
use App\Infrastructure\Validation\Symfony\ValidationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;

class LoginController extends AbstractController
{
    private LoginService $loginService;
    private LoginValidator $validator;
    private TranslatorInterface $translator;

    public function __construct(
        LoginService $loginService,
        LoginValidator $validator,
        TranslatorInterface $translator
    ){
        $this->validator = $validator;
        $this->loginService = $loginService;
        $this->translator = $translator;
    }

    public function __invoke(Request $request)
    {
        try {
            $this->validator
                ->validate($request->toArray());

            $password = $request->get('password');
            $email = $request->get('email');

            $response = $this->loginService->execute(
                new LoginRequest($password, $email)
            );

            return $this->json([
                'status' => 'success',
                'data' => [
                    'user' => $response->user()
                ]
            ]);

        } catch (ValidationException $e){
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