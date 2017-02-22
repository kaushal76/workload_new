<?php

namespace AppBundle\Form;

use AppBundle\Entity\AllocationsForModule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class AllocationsForModuleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('allocatedHrs');
        $builder->add('staff');
        $builder->add('module');
        $builder->add('prepHrs',HiddenType::class, array(
            'data' => '0',
            ));
        $builder->add('assessmentHrs',HiddenType::class, array(
            'data' => '0',
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => AllocationsForModule::class,
        ));
    }

}