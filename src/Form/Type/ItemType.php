<?php

namespace App\Form\Type;

use App\Entity\Item;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', TextType::class, array('required' => true))
            ->add('referencia', TextType::class, array('required' => true))
            ->add('vrPrecio', NumberType::class, array('required' => true))
            ->add('porcentaje', NumberType::class, array('required' => true))
            ->add('descripcion', TextareaType::class, array('required' => false))
            ->add('urlImagen', FileType::class, array('required' => false, 'label' => 'Adjuntar imagen'))
            ->add('guardar', SubmitType::class, array('label' => 'Guardar'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // uncomment if you want to bind to a class
            'data_class' => Item::class,
        ]);
    }
}
