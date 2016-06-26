<?php

namespace DemoBundle\Form;

use AppBundle\Form\BaseType;
use DemoBundle\Document\MatchPlayer;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlayerType extends BaseType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('steamId', TextType::class)
            ->add('name', TextType::class);
    }

    public function configure(OptionsResolver $resolver) {
        $resolver->setDefault('data_class', MatchPlayer::class);
    }
}