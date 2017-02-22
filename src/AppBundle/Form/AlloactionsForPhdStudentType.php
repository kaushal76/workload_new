<?php

namespace AppBundle\Form;

use AppBundle\Entity\AllocationsForModule;
use AppBundle\Entity\AllocationsForPhdStudent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class AlloactionsForPhdStudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('allocatedHrs');
        $builder->add('staff');
        $builder->add('phdStudent');
        $builder->add('supportHrs',HiddenType::class, array(
            'data' => '0',
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => AllocationsForPhdStudent::class,
        ));
    }

}