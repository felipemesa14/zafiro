<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TerceroType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('formaPagoRel', EntityType::class, array(
                    'class' => 'App:FormaPago',
                    'query_builder' => function (EntityRepository $em) {
                        return $em->createQueryBuilder('fp')
                                ->orderBy('fp.codigoFormaPagoPk', 'ASC');
                    },
                    'choice_label' => 'nombre',
                    'required' => true))
                ->add('numeroIdentificacion', NumberType::class, array('required' => true))
                ->add('nombreCorto', TextType::class, array('required' => true))
                ->add('telefono', TextType::class, array('required' => false))
                ->add('fax', TextType::class, array('required' => false))
                ->add('ciudad', TextType::class, array('required' => false))
                ->add('direccion', TextType::class, array('required' => false))
                ->add('celular', TextType::class, array('required' => false))
                ->add('email', EmailType::class, array('required' => false))
                ->add('cliente', CheckboxType::class, array('required' => false))
                ->add('proveedor', CheckboxType::class, array('required' => false))
                ->add('comentarios', TextareaType::class, array('required' => false))
                ->add('guardar', SubmitType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Tercero'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'App_tercero';
    }

}
