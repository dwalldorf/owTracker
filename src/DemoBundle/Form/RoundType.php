<?php

namespace DemoBundle\Form;

use AppBundle\Form\BaseType;
use DemoBundle\Document\MatchRound;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoundType extends BaseType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('roundNumber', NumberType::class)
            ->add('roundDuration', NumberType::class)
            ->add('roundEvents', RoundEventsType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    function configure(OptionsResolver $resolver) {
        $resolver->setDefault('data_class', MatchRound::class);
    }
}