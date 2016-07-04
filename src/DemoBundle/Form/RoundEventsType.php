<?php

namespace DemoBundle\Form;

use AppBundle\Form\AppCollectionType;
use AppBundle\Form\BaseType;
use DemoBundle\Document\RoundEvents;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoundEventsType extends BaseType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('kills', AppCollectionType::class, ['entry_type' => RoundEventKillType::class])
            ->add('bombPlant', RoundEventBombPlantType::class)
            ->add('bombDefuse', RoundEventBombDefuseType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    function configure(OptionsResolver $resolver) {
        $resolver->setDefault('data_class', RoundEvents::class);
    }
}