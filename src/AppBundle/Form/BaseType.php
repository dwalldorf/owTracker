<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

abstract class BaseType extends AbstractType {

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefault('csrf_protection', false)
            ->setDefault('allow_extra_fields', true)
            ->setDefault('constraints', [new Valid()]);

        $this->configure($resolver);
    }

    /**
     * @param OptionsResolver $resolver
     */
    abstract function configure(OptionsResolver $resolver);
}