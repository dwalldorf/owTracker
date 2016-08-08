<?php

namespace DemoBundle\Form;

use AppBundle\Form\BaseType;
use DemoBundle\Document\RoundEventBombDefused;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoundEventBombDefuseType extends BaseType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('player', TextType::class)
            ->add('timeInRound', NumberType::class)
            ->add('timeLeft', NumberType::class)
            ->add('withDefuseKit', CheckboxType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    function configure(OptionsResolver $resolver) {
        $resolver->setDefault('data_class', RoundEventBombDefused::class);
    }
}