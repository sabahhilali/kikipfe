<?php

namespace Faculte\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CoachType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('cin')
                ->add('nom')
                ->add('prenom')
                ->add('dateNaiss')
                ->add('lieuNaiss')
                ->add('sexe', ChoiceType::class, array(
                            'choices' => array(
                            'Homme' => 'Masculin',
                            'Femme' => 'Feminin',)))
                ->add('tel')
                ->add('adrss')
                ->add('salaire')
                ->add('pathFile',FileType::Class, array(
                            'data_class' => null)) ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Faculte\AdminBundle\Entity\Coach'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'faculte_adminbundle_coach';
    }


}
