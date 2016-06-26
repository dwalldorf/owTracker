<?php

namespace DemoBundle\Form;

use AppBundle\Form\BaseType;
use DemoBundle\Document\MatchInfo;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MatchInfoType extends BaseType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('map', TextType::class)
            ->add('team1', TeamType::class)
            ->add('team2', TeamType::class)
            ->add('totalRoundsTeam1', NumberType::class)
            ->add('totalRoundsTeam2', NumberType::class);
    }

    public function configure(OptionsResolver $resolver) {
        $resolver->setDefault('data_class', MatchInfo::class);
    }
}