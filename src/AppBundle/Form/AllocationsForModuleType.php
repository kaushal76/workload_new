<?php

namespace AppBundle\Form;

use AppBundle\Entity\AllocationsForModule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class AllocationsForModuleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('allocatedHrs');
        $builder->add('staff', EntityType::class, array(
            'class' => 'AppBundle:Staff',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('u')
                    ->orderBy('u.surname', 'ASC');
            },

        ));
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