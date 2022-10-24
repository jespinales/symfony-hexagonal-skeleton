<?php

namespace App\Infrastructure\Validation\Symfony;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

abstract class RequestValidation
{
    private ValidatorInterface $validator;
    protected array $errors = [];
    protected array $request = [];
    private TranslatorInterface $translator;

    public function __construct(
        ValidatorInterface $validator,
        TranslatorInterface $translator)
    {
        $this->validator = $validator;
        $this->translator = $translator;
    }

    protected abstract function rules();

    public function validate(array $request): ?static
    {
        $this->request = $request;
        $errors = $this->validator
            ->validate($request, $this->rules());

        if ($errors->count() > 0) {
            foreach($errors as $error) {
                $this->errors[
                    str_replace(['[', ']'] , '', $error->getPropertyPath())
                ][] = $error->getMessage();
            }

            throw new ValidationException(
                $this->errors,
                $this->translator->trans('data.invalid', [], 'validators'),
                402);
        }

        return $this;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}