<?php

namespace App\Infrastructure\Validation\Symfony\User;

use App\Infrastructure\Validation\Symfony\RequestValidation;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IdenticalTo;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Type;

class UserRegisterValidator extends RequestValidation
{
    protected function rules(): Collection
    {
        return new Collection([
            'name' => [
                new NotBlank(),
                new Type('string'),
                new Length(['max' => 50, 'min' => 3]),
            ],
            'email' => [
                new NotBlank(),
                new Type('string'),
                new Length(['max' => 100]),
                new Email(),
            ],
            'password' => [
                new NotBlank(),
                new Type('string'),
                new Length(['min' => 4 ,'max' => 50]),
            ],
        ]);
    }
}