<?php

namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
#[\Attribute] class MotDePasseFort extends Constraint
{
    public $message = 'Le mot de passe doit contenir au moins une minuscule, une majuscule, un chiffre et un caractère spécial.';
}
