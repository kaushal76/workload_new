<?php

namespace AppBundle\Form;

use AppBundle\Entity\Module;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

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
            ->add('internalModerator')
            ->add('internalModeratorHrs')
            ->add('moduleLeaderHrs');
        $builder->add('allocationsForModule', CollectionType::class, array(
                'entry_type'   => AllocationsForModuleType::class,
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
            'data_class' => Module::class,
        ));
    }


}
