<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class buscarDniType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder
                ->add('dni', TextType::class,[
                    'error_bubbling' => false,
                    'constraints' => [
                        new \AppBundle\Validator\Constraints\ValidateCredits([
                         'cost' => $options['cost'],
                         'balance' => $options['balance']   
                        ])
                    ]
                ])
                ->add('genre', ChoiceType::class, [
                    'error_bubbling' => true,
                    'expanded' => true,
                    'multiple' => false,
                    'choices' => [
                        'Masculino' => 'M',
                        'Femenino' => 'F',
            ]])
               ;
    }
   
    
    public function configureOptions(\Symfony\Component\OptionsResolver\OptionsResolver $resolver) {
        $resolver->setDefaults([
            'cost' => null,
            'balance' => null,
        ]);
    }
}
