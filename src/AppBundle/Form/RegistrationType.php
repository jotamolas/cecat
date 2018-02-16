<?php

// src/AppBundle/Form/RegistrationType.php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Person;

class RegistrationType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('idPerson', TextType::class,[
                    'label' => 'DNI'
                ])
                ->add('firstName', TextType::class,[
                    'label' => 'Nombre'
                ])
                ->add('lastName', TextType::class,[
                    'label' => 'Apellido'
                ])
                ->add('phone', TextType::class,[
                    'label' => 'Telefono'
                ])
                //->add('_type')
                ;
    }

    public function getParent() {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getName() {
        return 'app_user_registration';
    }
	
    public function configureOptions(OptionsResolver $resolver)
   {
    $resolver->setDefaults(array(
        'data_class' => Person::class,
    ));
   }

}
