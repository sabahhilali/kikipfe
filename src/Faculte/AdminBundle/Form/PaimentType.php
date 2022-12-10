<?php

namespace Faculte\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Faculte\AdminBundle\Entity\Adherent;

class PaimentType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('adherent', EntityType::class, array(
            'class'=> Adherent::class,
            'required'=> true,
            'placeholder' => 'Choisissez un Adhérent',
            'choice_label' => 'nom'
                )
            )
            ->add('activites', EntityType::class, array(
                'class'=>'FaculteAdminBundle:Activite',
                'placeholder' => 'Choisissez un activite',
                'empty_data' => null,
                'required'=> true))
            ->add('tarif',EntityType::class, array(
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
            'data_class' => 'Faculte\AdminBundle\Entity\Paiment'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'faculte_adminbundle_paiment';
    }



}
