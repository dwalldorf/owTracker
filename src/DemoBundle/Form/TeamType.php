<?php

namespace DemoBundle\Form;

use AppBundle\Form\AppCollectionType;
use AppBundle\Form\BaseType;
use DemoBundle\Document\MatchTeam;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeamType extends BaseType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('teamName', TextType::class)
            ->add('players', AppCollectionType::class, ['entry_type' => PlayerType::class]);
    }

    public function configure(OptionsResolver $resolver) {
        $resolver->setDefault('data_class', MatchTeam::class);
    }
}