<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModuleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('item')
            ->add('code')
            ->add('name')
            ->add('term')
            ->add('year')
            ->add('credit')
            ->add('studentNos')
            ->add('preparationHrs')
            ->add('assessmentHrs')
            ->add('contactHrs')
            ->add('studioRatio')
            ->add('groupFactor')
            ->add('course')
            ->add('moduleCategory')
            ->add('groupFilter')
            ->add('assessmentCategory')
            ->add('preparationCategory')
            ->add('moduleLeader')
            ->add('internalModerator');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Module'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_module';
    }


}
