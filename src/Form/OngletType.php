<?php

namespace App\Form;

use App\Entity\Onglet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Image;
use Vich\UploaderBundle\Form\Type\VichImageType;





class OngletType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('imageFile', FileType::class, [
                'label'=> 'Choisissez une image',
                'required' => false, // Si l'upload de l'image est facultatif, sinon, retirez cette ligne
                'attr' => [ //'btn btn-success inputImg'
                    'class' => 'btn btn-success',
                    'aria-label'=> 'Choisissez une image',
                ],
            ])
            ->add('title', TextType::class)
            ->add('description', TextAreaType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Onglet::class,
        ]);
    }
}
