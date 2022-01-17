<?php

namespace App\Service;

use App\Exception\AssertException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidatorObjectService
{
    public function __construct(private ValidatorInterface $validator)
    {

    }

    public function validate(Object $object)
    {
         $errors = $this->validator->validate($object);
        if (count($errors) > 0) {
            $violations = [];
            foreach($errors as $error){
                $violations[] = $error->getMessage();
            }
            throw AssertException::createMessage(json_encode($violations));
        }
    }
}
