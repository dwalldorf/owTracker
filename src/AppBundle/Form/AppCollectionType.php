<?php

namespace AppBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\Validator\Constraints\Valid;

class AppCollectionType extends CollectionType {

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $entryOptionsNormalizer = function (Options $options, $value) {
            $value['block_name'] = 'entry';
            return $value;
        };

        $resolver->setDefaults(
            [
                'allow_add'      => true,
                'allow_delete'   => true,
                'prototype'      => true,
                'prototype_data' => null,
                'prototype_name' => '__name__',
                'entry_type'     => __NAMESPACE__ . '\TextType',
                'entry_options'  => [],
                'delete_empty'   => true,
                'constraints'    => [new Valid()],
            ]
        );

        $resolver->setNormalizer('entry_options', $entryOptionsNormalizer);
    }
}