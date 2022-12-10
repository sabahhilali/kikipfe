<?php

namespace Faculte\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AbonnementType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('adherent',EntityType::class, array(
                'class'=>'FaculteAdminBundle:Adherent',
                'placeholder' => 'Choisissez un adherent',
                'empty_data' => null,
                'required'=> true))
            ->add('activite',EntityType::class, array(
                'class'=>'FaculteAdminBundle:Activite',
                'placeholder' => 'Choisissez un activite',
                'empty_data' => null,
                'required'=> true))
            ->add('tarifs',EntityType::class, array(
                'class'=>'FaculteAdminBundle:Tarif',
                'placeholder' => 'Choisissez un tarif',
                'empty_data' => null,
                'mapped'=> false,
                'required'=> true));
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Faculte\AdminBundle\Entity\Abonnement'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'faculte_adminbundle_abonnement';
    }


}
