<?php

namespace App\Infrastructure\Validation\Symfony\Auth;

use App\Infrastructure\Validation\Symfony\RequestValidation;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class LoginValidator extends RequestValidation
{
    protected function rules(): Collection
    {
        return new Collection([
            'password' => [
                new NotBlank(),
                new Type('string'),
                new Length(['min' => 4 ,'max' => 50]),
            ],
            'email' => [
                new NotBlank(),
                new Type('string'),
                new Length(['max' => 100]),
                new Email(),
            ],
        ]);
    }
}