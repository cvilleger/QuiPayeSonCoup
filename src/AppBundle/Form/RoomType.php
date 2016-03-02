<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoomType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                    'label' => 'Nom de la room'
                )
            )
            ->add('description', 'text', array(
                    'label' => 'Description',
                    'required' => false
                )
            )
            ->add('isActivated', 'choice', array(
                    'label' => 'Activé',
                    'choices' => array( true => 'Oui', false => 'Non'),
                    'expanded' => true,
                    'multiple' => false
                )
            )
            ->add('dateStart', 'datetime', array(
                    'label' => 'Date de création',
                    'disabled' => true
                )
            )
            ->add('pictureName', 'file', array(
                    'label' => 'Image',
                    'required' => false
                )
            )
            ->add('administrator', 'entity', array(
                    'label' => 'Administrateur de la room',
                    'class' => 'UserBundle:User',
                    'choice_label' => 'username'
                )
            )
            ->add('users', 'entity', array(
                'label' => 'Invités de la room',
                'class' => 'UserBundle:User',
                'choice_label' => 'username',
                'multiple' => true
            ))
            ->add('save', 'submit', array(
                    'label' => 'Créer la room'
                )
            )
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Room'
        ));
    }
}
