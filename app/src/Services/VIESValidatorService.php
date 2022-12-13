<?php

namespace Services;
use Ibericode\Vat\Validator;

class VIESValidatorService
{
    public static function validate(string $vatNumber){
        $validator = new Validator();
        return $validator->validateVatNumber($vatNumber);
    }
}