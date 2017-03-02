<?php

namespace AppBundle\Form;

use AppBundle\Entity\Module;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

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
            ->add('year');
        $builder->add('term', ChoiceType::class, array(
            'choices'  => array(
                'Term 1' => 1,
                'Term 2' => 2,
                'Term 3' => 3,
                'Term 1 & 2' => 4,
                'Year around' => 5
            )));
        $builder->add('credit')
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
