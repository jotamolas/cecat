<?php

// src/AppBundle/Form/RegistrationType.php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class RegistroType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('number', NumberType::class)
                ->add('address', TextType::class)
                ->add('city', TextType::class)
                ->add('phone', TextType::class)
                ->add('save', \Symfony\Component\Form\Extension\Core\Type\SubmitType::class)

        ;
    }

}
