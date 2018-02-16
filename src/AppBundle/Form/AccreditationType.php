<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccreditationType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                
                ->add('Creditos', \Symfony\Component\Form\Extension\Core\Type\MoneyType::class, [
                    'currency' => 'ARS'
                ]);
                //->add('Acreditar', \Symfony\Component\Form\Extension\Core\Type\SubmitType::class);
    }

}
