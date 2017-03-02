<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class PhdStudentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('totalHrs')
            ->add('item');
        $builder->add('mode', ChoiceType::class, array(
            'choices'  => array(
                'Full time' => 1,
                'Part time' => 2,
            ),
        ));

        $builder->add('allocationsForPhDStudent', CollectionType::class, array(
            'entry_type'   => AlloactionsForPhdStudentType::class,
            'allow_add'   => true,
            'allow_delete' => true,
            'by_reference' => false,
        ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\PhdStudent'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_phdstudent';
    }

}
