<?php

namespace DemoBundle\Form;

use AppBundle\Form\BaseType;
use DemoBundle\Document\RoundEventKill;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoundEventKillType extends BaseType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('killer', TextType::class)
            ->add('killed', TextType::class)
            ->add('timeInRound', NumberType::class)
            ->add('headshot', CheckboxType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    function configure(OptionsResolver $resolver) {
        $resolver->setDefault('data_class', RoundEventKill::class);
    }
}