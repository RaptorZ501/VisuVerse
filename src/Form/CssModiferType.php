<?php

namespace App\Form;

use App\Entity\CssModifer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CssModiferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('bgHeader')
            ->add('colorHeader')
            ->add('bgBase')
            ->add('bgBox1')
            ->add('bgBox2')
            ->add('bgBox3')
            ->add('colorBase')
            ->add('colorBox1')
            ->add('colorBox2')
            ->add('colorBox3')
            ->add('bgNav')
            ->add('colorNav')
            ->add('titleHeader')
            ->add('titleBase')
            ->add('desBox1')
            ->add('desBox2')
            ->add('desBox3')
            ->add('userId')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CssModifer::class,
        ]);
    }
}
