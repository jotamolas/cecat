<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class ReportDateType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder->add('date_from', \Symfony\Component\Form\Extension\Core\Type\DateType::class, [
                    'label' => 'Desde',
                    'widget' => 'single_text',
                ])
                ->add('date_to', \Symfony\Component\Form\Extension\Core\Type\DateType::class, [
                    'label' => 'Hasta',
                    'widget' => 'single_text',
        ]);
    }

}
