<?php

namespace App\Validator;

use App\Entity\Flat;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class FlatPhotoValidator extends ConstraintValidator
{
    private $path;
    public function __construct(KernelInterface $kernel)
    {
        $this->path = $kernel->getProjectDir().'/public'.Flat::PHOTO_WEB_PATH;
    }

    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\FlatPhoto */
        if (null === $value || '' === $value) {
            return;
        }

        if (!is_array($value))
            throw new UnexpectedValueException($value, 'array');

        foreach ($value as $v)
        {
            if(!is_string($v))
                throw new UnexpectedValueException($v, 'string');

            if(!preg_match('#^[a-z0-9]+\.[a-z0-9]+$#is', $v) || !file_exists($this->path.$v))
            {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $v)
                    ->addViolation();
            }

        }
    }
}
