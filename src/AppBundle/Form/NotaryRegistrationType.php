<?php

// src/AppBundle/Form/RegistrationType.php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\Notary;

class NotaryRegistrationType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('registro', EntityType::class, [
                    'label' => 'Registro',
                    'class' => 'AppBundle:Registro',
                    'choice_label' => 'description',
                    'expanded' => FALSE,
                    'multiple' => FALSE
                ])
                ->add('notaryTypeId', EntityType::class, [
                    'label' => 'Tipo',
                    'class' => 'AppBundle:NotaryType',
                    'choice_label' => 'description'
                ])
                ->add('save', \Symfony\Component\Form\Extension\Core\Type\SubmitType::class)

        ;
    }

    
    public function getParent() {
        return 'AppBundle\Form\RegistrationType';
    }
    
    public function configureOptions(\Symfony\Component\OptionsResolver\OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Notary::class
        ]);
        
    }
    
    
}
