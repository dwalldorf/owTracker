<?php

namespace DemoBundle\Form;

use AppBundle\Form\AppCollectionType;
use AppBundle\Form\BaseType;
use DemoBundle\Document\Demo;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DemoType extends BaseType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('userId', TextType::class)
            ->add('matchInfo', MatchInfoType::class)
            ->add('rounds', AppCollectionType::class, ['entry_type' => RoundType::class]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    function configure(OptionsResolver $resolver) {
        $resolver->setDefault('data_class', Demo::class);
    }
}