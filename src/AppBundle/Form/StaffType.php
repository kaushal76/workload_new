<?php

namespace AppBundle\Form;


use AppBundle\Entity\Staff;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class StaffType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title');
        $builder->add('firstname');
        $builder->add('surname');
        $builder->add('fte', null,array('label'=>'FTE'));
        $builder->add('allocations', CollectionType::class, array(
            'entry_type'   => AllocationType::class,
            'allow_add'   => true,
            'allow_delete' => true,
            'by_reference' => false,
        ));
        $builder->add('allocationsForModule', CollectionType::class, array(
            'entry_type'   => AllocationsForModuleType::class,
            'allow_add'   => true,
            'allow_delete' => true,
            'by_reference' => false,
        ));
        $builder->add('allocationsForPhdStudent', CollectionType::class, array(
            'entry_type'   => AlloactionsForPhdStudentType::class,
            'allow_add'   => true,
            'allow_delete' => true,
            'by_reference' => false,
        ));

        $builder->add('empbasis', ChoiceType::class, array(
            'choices'  => array(
                'In house' => 'In house',
                'Part time Hourly Paid' => 'PTHP',
                'Postgraduate support' => 'PhD student',

            ),
            'label'=>'Employment basis'));
        $builder->add('comments', null,array('label'=>'Notes'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults(array(
            'data_class' => Staff::class,
        ));
    }

}